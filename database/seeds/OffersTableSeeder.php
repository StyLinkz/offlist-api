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
        for ($i = 0; $i < 5; $i++) {

            // Images
            $images = [
                'overview' => [
                    'url' => 'https://via.placeholder.com/300x150',
                ],
                'bedroom' => [
                    'url' => 'https://via.placeholder.com/300x150',
                ],
                'bathroom' => [
                    'url' => 'https://via.placeholder.com/300x150',
                ],
                'garden' => [
                    'url' => 'https://via.placeholder.com/300x150',
                ],
            ];

            // Location
            $location = [
// @TODO Make it as ID instead of raw string
//                'country' => [
//                    'id' => 82,
//                    'code' => 'DE',
//                    'name' => 'Germany',
//                ],
//                'state' => [
//                    'id' => 1359,
//                    'name' => 'Berlin',
//                ],
                'country' => 'Germany',
                'city' => 'Berlin',
                'street' => 'Bayern Munich',
                'house_number' => '123',
                'zip_code' => '10115',
                'map' => [
                    'lat' => '52.529497',
                    'long' => '13.3679928',
                ],
                'description' => 'This is a location description',
                'display_mode' => 'all',
            ];

            // Documents
            $documents = [
                'terms_of_use' => [
                    'name' => 'Terms of use',
                    'link' => 'https://dev.offlist.de/sample.pdf',
                ],
                'privacy_policy' => [
                    'name' => 'Privacy policy',
                    'link' => 'https://dev.offlist.de/sample.pdf',
                ],
                'benefit' => [
                    'name' => 'Benefit',
                    'link' => 'https://dev.offlist.de/sample.pdf',
                ],
            ];

            // Seller
            $seller = [
                'avatar' => 'https://via.placeholder.com/150x150',
                'prename' => 'Minh',
                'name' => 'Duc',
                'company' => 'Freelancer',
                'country' => '1',
                'city' => '1',
                'street' => '123 Berlin',
                'zip_code' => '10115',
                'phone' => '+496912345678',
                'email' => 'ducnm@malinator.com',
                'website' => 'offlist.de',
            ];

            // Data
            $data = [
//                'main' => [
//                    'data' => [
//                        'rooms' => '10',
//                        'area' => '120',
//                    ],
//                ],
                'general' => [
                    'data' => [
                        'property_type' => [
                            'name' => 'Property Type',
                            'value' => 'Apartment',
                        ],
                        'rooms' => [
                            'name' => 'Rooms',
                            'value' => '10',
                        ],
                        'living_space' => [
                            'name' => 'Living space',
                            'value' => '200',
                        ],
                        'bed_room' => [
                            'name' => 'Bedroom',
                            'value' => '6',
                        ],
                        'bath_room' => [
                            'name' => 'Bathroom',
                            'value' => '3',
                        ],
                        'living_room' => [
                            'name' => 'Living Room',
                            'value' => '3',
                        ],
                        'cellars' => [
                            'name' => 'Cellars',
                            'value' => '1',
                        ],
                        'floors_in_total' => [
                            'name' => 'Floors in total',
                            'value' => '3',
                        ],
                        'parking_space' => [
                            'name' => 'Parking space',
                            'value' => '100m2',
                        ],
                        'free_from' => [
                            'name' => 'Free from',
                            'value' => '15/03/2020',
                        ],
                        'status' => [
                            'name' => 'Status',
                            'value' => 'Available',
                        ],
                    ],
                ],
                'building_fabric' => [
                    'name' => 'Building fabric & energy certificate',
                    'data' => [
                        'object_state' => [
                            'name' => 'Object state',
                            'value' => 'Full',
                        ],
                        'equipment' => [
                            'name' => 'Equipment',
                            'value' => 'Full',
                        ],
                        'energy_source' => [
                            'name' => 'Energy source',
                            'value' => 'Full',
                        ],
                        'heating_type' => [
                            'name' => 'Heating type',
                            'value' => 'Modern',
                        ],
                    ],
                ],
                'furnishing' => [
                    'name' => 'Furnishing',
                    'data' => [
                        'description' => [
                            'value' => 'This is some furnishing texts',
                        ],
                    ],
                ],
                'floor_plan' => [
                    'name' => 'Floor plan',
                    'type' => 'images',
                    'data' => [
                        'first_floor' => [
                            'name' => 'First floor',
                            'value' => 'https://via.placeholder.com/300x150',
                        ],
                        'second_floor' => [
                            'name' => 'Second floor',
                            'value' => 'https://via.placeholder.com/300x150',
                        ],
                        'third_floor' => [
                            'name' => 'Third floor',
                            'value' => 'https://via.placeholder.com/300x150',
                        ],
                    ],
                ],
            ];

            Offer::create([
                'offer_type_id' => 1,
                'offer_category_id' => 1,
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'price' => $faker->randomNumber(6),
                'commission' => $faker->randomNumber(2) . '%',
                'price_tax' => $faker->randomNumber(7),
                'images' => json_encode($images),
                'location' => json_encode($location),
                'documents' => json_encode($documents),
                'seller' => json_encode($seller),
                'data' => json_encode($data),
                'publish_type' => 'public',
                'status' => 'activated',
            ]);
        }
    }
}
