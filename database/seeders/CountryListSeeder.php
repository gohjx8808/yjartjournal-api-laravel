<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $open = fopen(public_path() . '/countrycode.csv', 'r');

        while (($country = fgetcsv($open)) !== false) {
            Country::create([
                'iso2' => $country[1],
                'iso3' => $country[2],
                'name' => $country[0],
                'phone_code' => $country[3],
            ]);
        }
    }
}
