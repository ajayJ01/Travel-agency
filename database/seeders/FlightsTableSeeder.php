<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FlightsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('flights')->insert([
                'flight_number' => $faker->unique()->word,
                'source' => $faker->city,
                'destination' => $faker->city,
                'price' => $faker->randomFloat(2, 100, 1000),
                'departure_time' => $faker->dateTimeBetween('now', '+1 year'),
                'arrival_time' => $faker->dateTimeBetween('+1 hour', '+2 years'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
