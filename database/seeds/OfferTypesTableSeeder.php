<?php

use App\OfferType;
use Illuminate\Database\Seeder;

class OfferTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch
        OfferType::truncate();

        // And now, let's create a few offer_types in our database
        $types = [
            'real_estate' => 'Real Estate',
            'car' => 'Luxury Cars',
            'art' => 'Art',
            'horse' => 'Horses',
            'yacht' => 'Yachts',
            'jet' => 'Private Jets',
        ];
        foreach ($types as $name => $display_name) {
            OfferType::create([
                'name' => $name,
                'display_name' => $display_name,
            ]);
        }
    }
}
