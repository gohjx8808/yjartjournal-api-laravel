<?php

namespace App\Http\Repositories;

use App\Models\UserOrder;

class OrderRepository
{
    public static function getOrderByEmail(string $userEmail)
    {
        return UserOrder::query()
            ->with('hasManyOrderDetails', 'receiverAddress', 'promoCode', 'paymentOption', 'orderStatus')
            ->where('email', $userEmail)
            ->get();
    }
}
