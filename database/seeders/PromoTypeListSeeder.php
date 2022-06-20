<?php

namespace Database\Seeders;

use App\Models\PromoType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoTypeListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promoTypes = ['percentage', 'number'];

        collect($promoTypes)->map(function ($type) {
            PromoType::create(['name' => $type]);
        });
    }
}
