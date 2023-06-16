<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourtsController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\SurfaceController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
// Another option might be to use the phone number and send SMS with validation code or use email
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::post("/refresh", [AuthController::class, "refresh"]);
Route::post("/logout", [AuthController::class, "logout"]);

// General
Route::any("/", function () {
    return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);
});

// Surfaces
Route::get("/surfaces", [SurfaceController::class, "index"]);
Route::get("/surfaces/{surface_id}", [SurfaceController::class, "show"])
    ->where("surface_id", "[0-9]+");

// Let's just say these manages an administrator
// Route::post("/surfaces", [SurfaceController::class, "store"]);
// Route::delete("/surfaces/{surface_id}", [SurfaceController::class, "destroy"])
//     ->where("surface_id", "[0-9]+");

// Courts
Route::get("/courts", [CourtsController::class, "index"]);
Route::get("/courts/{court_id}", [CourtsController::class, "show"])
    ->where("court_id", "[0-9]+");

// These also manages an administrator
// Route::post("/courts", [CourtsController::class, "store"]);
// Route::delete("/courts/{court_id}", [CourtsController::class, "destroy"])
//     ->where("court_id", "[0-9]+");

// Reservations
Route::get("/reservations", [ReservationsController::class, "index"]);
Route::get("/reservations/{reservation_id}", [ReservationsController::class, "show"])
    ->where("reservation_id", "[0-9]+");
Route::get("/reservations/court_id/{court_id}", [ReservationsController::class, "showByCourtId"])
    ->where("court_id", "[0-9]+");
Route::get("/reservations/phone_number/{phone_number}", [ReservationsController::class, "showByPhoneNumber"])
    ->where("phone_number", "^[0-9]{15}$");
Route::get("/reservations/user_id/{user_id}", [ReservationsController::class, "showByUserId"])
    ->where("user_id", "[0-9]+");

Route::middleware("auth:api")->group(function() {
    Route::post("/reservations", [ReservationsController::class, "store"]);
    Route::delete("/reservations/{reservation_id}", [ReservationsController::class, "destroy"])
        ->where("reservation_id", "[0-9]+");
});


// Route::fallback(function() {
//     return response()->json(["error" => "404 Not Found"], 404);
// });
