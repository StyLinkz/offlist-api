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

            // Seller
            $seller = [
                'avatar' => 'https://placehold.co/150x150.png',
                'prename' => 'Minh',
                'name' => 'Duc',
                'email' => 'ducnm@malinator.com',
                'phone' => '+496912345678',
                'company' => 'Freelancer',
                'website' => 'offlist.de',
                'address' => '123 Berlin',
                'city' => 'Berlin',
                'zipcode' => '10115',
                'contact_mode' => 'new',
                // 'country' => '1',
            ];

            // Location
            $location = [
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
            ];

            // Images
            $images = [
                'file_0' => [
                    'name' => 'overview',
                    'url' => 'https://placehold.co/300x150.png',
                ],
                'file_1' => [
                    'name' => 'bedroom',
                    'url' => 'https://placehold.co/300x150.png',
                ],
                'file_2' => [
                    'name' => 'bathroom',
                    'url' => 'https://placehold.co/300x150.png',
                ],
                'file_3' => [
                    'name' => 'garden',
                    'url' => 'https://placehold.co/300x150.png',
                ],
            ];

            // Documents
            $documents = [
                'file_0' => [
                    'name' => 'Terms of use',
                    'url' => 'https://dev.offlist.de/sample.pdf',
                ],
                'file_1' => [
                    'name' => 'Privacy policy',
                    'url' => 'https://dev.offlist.de/sample.pdf',
                ],
                'file_2' => [
                    'name' => 'Benefit',
                    'url' => 'https://dev.offlist.de/sample.pdf',
                ],
            ];

            // Data
            $data = [
                'primary' => [
                    'data' => [
                        'currency' => [
                            'name' => 'Currency',
                            'value' => 'EUR',
                        ],
                        'size' => [
                            'name' => 'Size',
                            'value' => "$faker->randomNumber(2)",
                        ],
                        'year_of_construction' => [
                            'name' => 'Year of creation',
                            'value' => '1990',
                        ],
                        'free_from' => [
                            'name' => 'Free from',
                            'value' => '2022-12-01',
                        ],
                        'status' => [
                            'name' => 'Status',
                            'value' => 'For sale',
                        ],
                    ],
                ],
                'secondary' => [
                    'data' => [
                        'rooms' => [
                            'name' => 'Rooms',
                            'value' => '10',
                        ],
                        'bedroom' => [
                            'name' => 'Bedroom',
                            'value' => '6',
                        ],
                        'bath_room' => [
                            'name' => 'Bathroom',
                            'value' => '3',
                        ],
                        'living_room' => [
                            'name' => 'Living room',
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
                    ],
                ],
                'building_fabric' => [
                    'name' => 'Building fabric & energy certificate',
                    'data' => [
                        'object_state' => [
                            'name' => 'Object state',
                            'value' => 'First occupancy',
                        ],
                        'equipment' => [
                            'name' => 'Equipment',
                            'value' => 'Standard',
                        ],
                        'energy_source' => [
                            'name' => 'Energy source',
                            'value' => 'Natural gas',
                        ],
                        'heating_type' => [
                            'name' => 'Heating type',
                            'value' => 'Heat pump',
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
                    // 'type' => 'images',
                    'data' => [
                      'images' => [
                        'value' => null
                      ],
                    ],
                ],
            ];

            Offer::create([
                'user_id' => '1',
                'offer_type_id' => '1',
                'offer_category_id' => '1',
                'privacy' => 'public',
                'market_type' => 'offmarket',
                'available_type' => 'private',
                'publish_type' => 'auto',
                'status' => 'activated',
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'price' => $faker->randomNumber(6),
                'price_tax' => $faker->randomNumber(6),
                'commission' => $faker->randomNumber(2),
                'tags' => json_encode([]),
                'groups' => json_encode([]),
                'images' => json_encode($images),
                'location' => json_encode($location),
                'documents' => json_encode($documents),
                'data' => json_encode($data),
                'seller' => json_encode($seller),
            ]);
        }
    }
}
