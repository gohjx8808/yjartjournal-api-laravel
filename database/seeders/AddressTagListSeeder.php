<?php

namespace Database\Seeders;

use App\Models\AddressTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressTagListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addressTags = ['home', 'work'];

        collect($addressTags)->map(function ($tag) {
            AddressTag::create(['name' => $tag]);
        });
    }
}
