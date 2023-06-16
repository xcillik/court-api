<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;
use Illuminate\Support\Str;

class ReservationsController extends Controller {
    public function index() {
        $reservations = Reservation::select("reservation_id", "court_id", "doubles", "phone_number", "start_ts", "end_ts")
            ->paginate(20);

        return response()->json($reservations->items())
            ->header("X-Total", $reservations->total())
            ->header("X-Prev-Page", $reservations->previousPageUrl())
            ->header("X-Next-Page", $reservations->nextPageUrl());
    }

    public function show(string $reservation_id) {
        $reservation = Reservation::select("reservation_id", "court_id", "doubles", "phone_number", "start_ts", "end_ts")
            ->firstWhere("reservation_id", $reservation_id);
        
        if ($reservation === null)
            return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);
        
        return response()->json($reservation);
    }

    public function showByCourtId(string $court_id) {
        $reservations = Reservation::select("reservation_id", "court_id", "doubles", "phone_number", "start_ts", "end_ts")
            ->where("court_id", $court_id)
            ->paginate(20);
        
        if (count($reservations->items()) === 0)
            return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);
        
        return response()->json($reservations->items())
            ->header("X-Total", $reservations->total())
            ->header("X-Prev-Page", $reservations->previousPageUrl())
            ->header("X-Next-Page", $reservations->nextPageUrl());
    }

    public function showByPhoneNumber(string $phone_number) {
        $reservations = Reservation::select("reservation_id", "court_id", "doubles", "phone_number", "start_ts", "end_ts")
            ->where("phone_number", $phone_number)
            ->paginate(20);
        
        if (count($reservations->items()) === 0)
            return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);
        
        return response()->json($reservations->items())
            ->header("X-Total", $reservations->total())
            ->header("X-Prev-Page", $reservations->previousPageUrl())
            ->header("X-Next-Page", $reservations->nextPageUrl());
    }

    public function showByUserId(string $user_id) {
        $reservations = Reservation::select("reservation_id", "court_id", "doubles", "phone_number", "start_ts", "end_ts")
            ->where("user_id", $user_id)
            ->paginate(20);
        
        if (count($reservations->items()) === 0)
            return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);
        
        return response()->json($reservations->items())
            ->header("X-Total", $reservations->total())
            ->header("X-Prev-Page", $reservations->previousPageUrl())
            ->header("X-Next-Page", $reservations->nextPageUrl());
    }

    private function checkIntervalOverlap(ValidationValidator $validator): void {
        $start_ts = $validator->safe()->start_ts;
        $end_ts = $validator->safe()->end_ts;

        $count = Reservation::where("end_ts", ">", $start_ts)
            ->where("start_ts", "<", $end_ts)
            ->count();

        if ($count > 0)
            $validator->errors()->add("start_ts", "Already exists reservation at this time");
    }

    public function store(Request $request) {
        // Validate user input
        $validator = Validator::make($request->all(), [
            "court_id" => "required|numeric|gt:0|exists:courts,court_id",
            "doubles" => "required|in:0,1",
            "phone_number" => "required|regex:/^[0-9]{14}$/",
            "start_ts" => "required|date_format:Y-m-d H:i:s",
            "end_ts" => "required|date_format:Y-m-d H:i:s|after:start_ts"
        ])->after($this->checkIntervalOverlap(...));

        $validator->validate();
        $court_id = $validator->safe()->court_id;
        // Save reservation into DB
        $new_reservation = Reservation::create([
            "court_id" => $court_id,
            "user_id" => Auth::id(), // not null bc. of middleware making sure user is logged
            "doubles" => $validator->safe()->doubles,
            "phone_number" => $validator->safe()->phone_number,
            "start_ts" => $validator->safe()->start_ts,
            "end_ts" => $validator->safe()->end_ts
        ]);

        $total_price = $new_reservation->calculateRentCost();

        return response()->json([
            "reservation_id" => $new_reservation->reservation_id,
            "total_price" => $total_price
        ], Response::HTTP_CREATED);
    }

    public function destroy(string $reservation_id) {
        $reservation = Reservation::find($reservation_id);

        if ($reservation === null)
            return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);

        // Logged user tries to delete reservations that does not belong to him
        if ($reservation->user_id !== Auth::id())
            return response()->json(["error" => "403 Forbidden"], Response::HTTP_FORBIDDEN);
        
        $reservation->delete();

        return response()->json([
            "court_id" => $reservation->court->court_id,
            "phone_number" => $reservation->phone_number,
            "start_ts" => $reservation->start_ts,
            "end_ts" => $reservation->end_ts
        ], $status = Response::HTTP_OK);
    }
}
