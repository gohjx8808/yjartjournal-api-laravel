<?php

namespace Database\Seeders;

use App\Models\SortByOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SortByOptionListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = ['Name: A to Z', 'Name: Z to A', 'Price: Low to High', 'Price: High to Low'];

        collect($options)->map(function ($option) {
            SortByOption::firstOrCreate([
                'name' => $option
            ]);
        });
    }
}
