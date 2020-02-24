<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first
        User::truncate();

        $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password
        // let's hash it before the loop, or else our seeder
        // will be too slow
        $password = Hash::make('offlist');

        User::create([
            'prename' => 'Admin',
            'name' => 'Admin',
            'email' => 'offlist@mailinator.com',
            'password' => $password,
            'role' => 'admin',
        ]);

        // And now let's generate a few dozen users for our app
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->firstName,
                'prename' => $faker->lastName,
                'company' => $faker->company,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'password' => $password,
                'role' => 'user',
                'offer_types' => '1,2,3',
                'api_token' => Str::random(60),
            ]);
        }
    }
}
