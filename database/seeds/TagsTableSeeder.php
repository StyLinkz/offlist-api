<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch
        Tag::truncate();

        // And now, let's create a few offer_types in our database
        $tags = [
            'rented' => 'Rented',
            'fitted_kitchen' => 'Fitted Kitchen',
            'parking_space' => 'Parking Space',
            'cellar' => 'Cellar',
            'villa' => 'Villa',
            'apartment' => 'Apartment',
        ];
        foreach ($tags as $name => $display_name) {
            Tag::create([
                'name' => $name,
                'display_name' => $display_name,
            ]);
        }
    }
}
