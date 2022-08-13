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

        $authenticatedUser = Auth('sanctum')->user();
        $email = $authenticatedUser->email;

        $productsTotalPrice = $products->sum('totalPrice');

        if (isset($$addressId)) {
            $addressDetails = AddressRepository::getAddressById($addressId);
            $state = $addressDetails->state;
        } else {
            $state = $request->state;

            $address = AddressRepository::addAddress($request);

            if ($addAddress && isset($authenticatedUser)) {
                $address->user_id = $authenticatedUser->id;
                $address->save();
            }

            $addressId = $address->id;
        }

        $shippingFee = self::calculateShippingFee($state, $productsTotalPrice);

        DB::beginTransaction();

        $userOrder = OrderRepository::addUserOrder($email, $shippingFee, $productsTotalPrice, $addressId, $request);

        $userOrderId = $userOrder->id;

        $products->map(function ($product) use ($userOrderId) {
            OrderRepository::addOrderDetails($userOrderId, $product);
        });

        DB::commit();

        return ['msg' => 'Checkout success!'];
    }

    public static function calculateShippingFee(string $state, float $productsTotalPrice)
    {
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

        return $shippingFee;
    }
}
