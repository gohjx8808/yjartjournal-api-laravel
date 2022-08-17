<?php

namespace App\Http\Repositories;

use App\Http\Requests\CheckoutRequest;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\UserOrder;

class OrderRepository
{
    public static function getOrderByEmail(string $userEmail, int $promoCodeId = null)
    {
        return UserOrder::query()
            ->with('hasManyOrderDetails', 'receiverAddress', 'promoCode', 'paymentOption', 'orderStatus')
            ->where('email', $userEmail)
            ->when($promoCodeId !== null, function ($query) use ($promoCodeId) {
                return $query->where('promo_code_id', $promoCodeId);
            })
            ->get();
    }

    public static function addUserOrder(
        string $email,
        int $shippingFee,
        float $totalPrice,
        int $addressId,
        int|null $promoCodeId,
        CheckoutRequest $request
    ) {
        return UserOrder::create([
            'email' => $email,
            'receiver_address_id' => $addressId,
            'shipping_fee' => $shippingFee,
            'notes' => $request->notes,
            'promo_code_id' => $promoCodeId,
            'payment_option_id' => $request->paymentOptionId,
            'order_status_id' => OrderStatus::TO_PAY,
            'total_price' => $totalPrice,
        ]);
    }

    public static function addOrderDetails($userOrderId, $product)
    {
        OrderDetail::create([
            'user_order_id' => $userOrderId,
            'quantity' => $product['quantity'],
            'product_id' => $product['id'],
            'total_price' => $product['totalPrice'],
        ]);
    }
}
