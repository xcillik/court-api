<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Surface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        DB::table("reservations")->delete();
        DB::table("courts")->delete();
        DB::table("surfaces")->delete();

        $this->call([
            SurfaceSeeder::class,
            CourtSeeder::class,
            UserSeeder::class,
            ReservationSeeder::class
        ]);
    }
}
