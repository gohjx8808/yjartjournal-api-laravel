<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public static function getOrderHistory()
    {
        $authenticatedUser = Auth::user();
        $orderHistories = OrderRepository::getOrderByEmail($authenticatedUser->email);

        return $orderHistories;
    }
}
