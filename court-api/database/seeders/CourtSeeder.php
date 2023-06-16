<?php

namespace Database\Seeders;

use App\Models\Surface;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourtSeeder extends Seeder {
    private function seed_one(): void {
        DB::table("courts")->insert([
            "surface_id" => Surface::all()->random()->surface_id,
            "name" => Str::random(7),
            "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
            "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
        ]);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void {
        for ($i=0; $i < 45; $i++) { 
            $this->seed_one();
        }
    }
}
