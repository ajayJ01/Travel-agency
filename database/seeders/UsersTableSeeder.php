<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->boolean ? now() : null, // Randomly set email_verified_at
                'password' => Hash::make('password'), // Default password, hashed
                'remember_token' => $faker->optional()->word, // Optional remember token
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
