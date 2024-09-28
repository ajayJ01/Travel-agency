<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ConnectedFlightsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $flights = DB::table('flights')->pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            $flightId = $faker->randomElement($flights);
            $connectedFlightId = $faker->randomElement(array_diff($flights, [$flightId]));

            DB::table('connected_flights')->insert([
                'flight_id' => $flightId,
                'connected_flight_id' => $connectedFlightId,
                'connection_duration' => $faker->numberBetween(30, 180), // Duration in minutes
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
