<?php

namespace App\Http\Services;

use App\Contentful\ContentfulAPI;
use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\PromoCodeRepository;
use App\Http\Requests\CheckoutRequest;
use App\Mail\PaymentEmail;
use App\Models\PromoType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
                $discountAmount = $codeDetails->amount;
                $productsTotalPrice -= $discountAmount;
            } else if ($promoType === PromoType::PERCENTAGE_TEXT) {
                $discountAmount = $productsTotalPrice * ($codeDetails->amount / 100);
                $productsTotalPrice = $productsTotalPrice - $discountAmount;
            }
        }

        $userOrder = OrderRepository::addUserOrder(
            $email,
            $shippingFee,
            $productsTotalPrice,
            $addressId,
            $codeId ?? null,
            $request
        );

        $userOrderId = $userOrder->id;

        $contentful = new ContentfulAPI();

        $formattedProducts = $products->reduce(function ($carry, $product) use ($userOrderId, $contentful) {
            OrderRepository::addOrderDetails($userOrderId, $product);
            $productDetails = $contentful->getSingleProduct($product['id']);

            return $carry->push([...$product, 'name' => $productDetails->name]);
        }, collect());

        DB::commit();

        $receiverAddress = $userOrder['receiverAddress'];

        Mail::to('jingxuan.goh@capbay.com')->send(new PaymentEmail(
            $authenticatedUser->name ?? $userOrder->email,
            $userOrder['paymentOption']->name,
            $formattedProducts,
            $userOrder->total_price + ($discountAmount ?? 0),
            $discountAmount ?? null,
            $shippingFee,
            $userOrder->total_price + $shippingFee,
            $userOrder->notes,
            $receiverAddress->name,
            $receiverAddress['countryCode']->phone_code . ' ' . $receiverAddress->phone_number,
            $receiverAddress->address_line_one,
            $receiverAddress->address_line_two,
            $receiverAddress->postcode,
            $receiverAddress->city,
            $receiverAddress->state,
            $receiverAddress['country']->name
        ));

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
