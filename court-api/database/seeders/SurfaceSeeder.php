<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SurfaceSeeder extends Seeder {
    private function randomSurface(): string {
        $surfaces = ["Sand", "Gravel", "Concrete", "Grass", "Rubber", "Tiles", "PlasticGrass"];

        return $surfaces[array_rand($surfaces)];
    }

    private function seed_one(): void {
        DB::table("surfaces")->insert([
            "rent_cost" => random_int(150, 500),
            "name" => $this->randomSurface(),
            "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
            "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
        ]);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void {
        for ($i=0; $i < 10; $i++) { 
            $this->seed_one();
        }
    }
}
