<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(OffersTableSeeder::class);
        $this->call(OfferTypesTableSeeder::class);
        $this->call(OfferCategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(OfferTagsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(AdminMenuSeeder::class);
    }
}
