<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationSeeder extends Seeder {
    private function randomPhoneNumber(): string {
        # format: 0042YXXXXXXXXX
        $res = "0042";
        $res .= (string) rand(0, 1);

        for ($i = 0; $i < 9; $i++) { 
            $res .= (string) rand(0, 9);
        }

        return $res;
    }

    private function roundTo15Minutes(int $ts): int {
        return round($ts / (15 * 60)) * (15 * 60);
    }

    private function randomTimeInteval(): array {
        $start = $this->roundTo15Minutes(time());
        // end will be between 1 hour and two days
        $end = $start + rand(60*60, 60*60*24*2);
        $end = $this->roundTo15Minutes($end);

        # shift both levels by max 30 days to the past or future
        $range = 60*60*24*30;
        $shift = rand(-$range, $range);
        $shift = $this->roundTo15Minutes($shift);

        $start += $shift;
        $end += $shift;

        return [$start, $end];
    }

    private function seed_one(): void {
        [$start, $end] = $this->randomTimeInteval();
        $format = "Y-m-d H:i:s";

        DB::table("reservations")->insert([
            // "court_id" => Court::all()->random()->surface_id,
            "court_id" => 1,
            "user_id" => User::all()->random()->user_id,
            "doubles" => rand(0,1) == 1,
            "phone_number" => $this->randomPhoneNumber(),
            "start_ts" => Carbon::createFromTimestamp($start)->format($format),
            "end_ts" => Carbon::createFromTimestamp($end)->format($format),
            "created_at" => Carbon::now()->format($format),
            "updated_at" => Carbon::now()->format($format),
        ]);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void {
        for ($i=0; $i < 4; $i++) { 
            $this->seed_one();
        }
    }
}
