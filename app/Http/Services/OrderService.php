<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $products = collect($request->products);
        $addressId = $request->addressId;
        $promoCode = $request->promoCode;
        $addAddress = $request->addAddress;

        $productsTotalPrice = $products->sum('totalPrice');

        if (isset($$addressId)) {
            $addressDetails = AddressRepository::getAddressById($addressId);
            $state = $addressDetails->state;
        } else {
            $state = $request->state;
        }

        $westMalaysia = ['Sarawak', 'Labuan', 'Sabah'];

        if (in_array($state, $westMalaysia)) {
            $shippingFee = 15;
        } else {
            $shippingFee = 8;
        }

        if ($productsTotalPrice > 150) {
            $shippingFee = 0;
        } else if ($productsTotalPrice > 80) {
            if (!in_array($state, $westMalaysia)) {
                $shippingFee = 0;
            }
        }

        $authenticatedUser = Auth('sanctum')->user();
        $email = $authenticatedUser->email;

        DB::beginTransaction();

        $userOrder = OrderRepository::addUserOrder($email, $shippingFee, $productsTotalPrice, $request);

        dd($userOrder);

        return;
    }
}
