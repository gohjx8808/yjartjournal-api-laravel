<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public static function getOrderHistory()
    {
        $authenticatedUser = Auth::user();
        $orderHistories = OrderRepository::getOrderByEmail($authenticatedUser->email);

        return $orderHistories;
    }

    public static function checkout(CheckoutRequest $request)
    {
        dd($request);
        $authenticatedUser = Auth::user();
        $orderHistories = OrderRepository::getOrderByEmail($authenticatedUser->email);

        return $orderHistories;
    }
}
