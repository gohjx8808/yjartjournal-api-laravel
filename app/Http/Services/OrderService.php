<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\PromoCodeRepository;
use App\Http\Requests\CheckoutRequest;
use App\Models\PromoType;
use Carbon\Carbon;
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

        if (isset($authenticatedUser)) {
            $email = $authenticatedUser->email;
        }

        $productsTotalPrice = $products->sum('totalPrice');

        DB::beginTransaction();

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

        if (isset($promoCode)) {
            $codeDetails = PromoCodeRepository::getPromoCodeByCode($promoCode);

            if (!isset($codeDetails)) {
                return ['success' => false, 'msg' => 'Invalid promo code!'];
            }

            if (Carbon::now()->lt($codeDetails->start_at) || Carbon::now()->gt($codeDetails->expired_at)) {
                return ['success' => false, 'msg' => 'Promo code expired!'];
            }

            $usageLimit = $codeDetails->usage_limit;
            $codeId = $codeDetails->id;

            $userOrders = OrderRepository::getOrderByEmail($email, $codeId);

            $promoCodeUsedCount = $userOrders->reduce(function ($carry) {
                return $carry += 1;
            }, 1); // start from 1 to include current promo code usage

            if ($promoCodeUsedCount > $usageLimit) {
                return ['success' => false, 'msg' => 'Promo code usage limit exceeded!'];
            }

            $promoType = $codeDetails['promoType']->name;

            if ($promoType === PromoType::NUMBER_TEXT) {
                $productsTotalPrice -= $codeDetails->amount;
            } else if ($promoType === PromoType::PERCENTAGE_TEXT) {
                $remainingPercentage = 1 - ($codeDetails->amount / 100);
                $productsTotalPrice = $productsTotalPrice * $remainingPercentage;
            }
        }

        $userOrder = OrderRepository::addUserOrder(
            $email,
            $shippingFee,
            $productsTotalPrice,
            $addressId,
            $codeId,
            $request
        );

        $userOrderId = $userOrder->id;

        $products->map(function ($product) use ($userOrderId) {
            OrderRepository::addOrderDetails($userOrderId, $product);
        });

        DB::commit();

        return ['success' => true, 'msg' => 'Checkout success!'];
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
