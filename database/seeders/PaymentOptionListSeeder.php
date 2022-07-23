<?php

namespace Database\Seeders;

use App\Models\PaymentOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentOptionListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentOptions = ['Touch \'n Go eWallet', 'Bank Transfer'];

        collect($paymentOptions)->map(function ($option) {
            PaymentOption::firstOrCreate([
                'name' => $option
            ]);
        });
    }
}
