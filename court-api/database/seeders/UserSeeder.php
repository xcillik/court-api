<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table("users")->insert([
            "email" => "test@example.com",
            "password" => Hash::make("00000000"),
            "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
            "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
        ]);

        DB::table("users")->insert([
            "email" => "test2@example.com",
            "password" => Hash::make("11111111"),
            "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
            "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
        ]);
    }
}
