<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['To Pay', 'To Ship', 'To Receive', 'Completed'];

        collect($statuses)->map(function ($status) {
            OrderStatus::firstOrCreate([
                'name' => $status
            ]);
        });
    }
}
