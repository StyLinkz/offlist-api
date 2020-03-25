<?php

use App\OfferCategory;
use Illuminate\Database\Seeder;

class OfferCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Let's truncate our existing records to start from scratch
        OfferCategory::truncate();

        // And now, let's create a few offer_types in our database
        $types = [
            '1' => [
                'apartment' => 'Apartment',
                'hotel' => 'Hotel',
                'villa' => 'Villa',
                'resort' => 'Resort',
                'homestay' => 'Homestay',
                'bungalow' => 'Bungalow',
            ],
        ];
        foreach ($types as $type => $categories) {
            foreach ($categories as $name => $display_name) {
                OfferCategory::create([
                    'offer_type_id' => $type,
                    'name' => $name,
                    'display_name' => $display_name,
                ]);
            }
        }
    }
}
