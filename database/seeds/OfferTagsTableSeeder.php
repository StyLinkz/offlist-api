<?php

use App\OfferTag;
use Illuminate\Database\Seeder;

class OfferTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Let's truncate our existing records to start from scratch
        OfferTag::truncate();

        // And now, let's create a few offer_types in our database
        $offerTags = [
            [
                'offer_id' => '1',
                'tag_id' => '1',
            ],
            [
                'offer_id' => '1',
                'tag_id' => '2',
            ],
            [
                'offer_id' => '1',
                'tag_id' => '3',
            ],
            [
                'offer_id' => '2',
                'tag_id' => '1',
            ],
            [
                'offer_id' => '2',
                'tag_id' => '2',
            ],
            [
                'offer_id' => '2',
                'tag_id' => '3',
            ],
        ];

        foreach ($offerTags as $offerTag) {
            OfferTag::create([
                'offer_id' => $offerTag['offer_id'],
                'tag_id' => $offerTag['tag_id'],
            ]);
        }
    }
}
