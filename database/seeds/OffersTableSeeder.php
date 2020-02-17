<?php

use App\Offer;
use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch
        Offer::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few offers in our database
        for ($i = 0; $i < 50; $i++) {
            Offer::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph
            ]);
        }
    }
}
