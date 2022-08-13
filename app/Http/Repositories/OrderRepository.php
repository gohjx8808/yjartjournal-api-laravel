<?php

namespace App\Http\Repositories;

use App\Http\Requests\CheckoutRequest;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
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

    public static function addUserOrder(string $email, int $shippingFee, float $totalPrice, CheckoutRequest $request)
    {
        return UserOrder::create([
            'email' => $email,
            'receiver_address_id' => $request->addressId,
            'shipping_fee' => $shippingFee,
            'notes' => $request->notes,
            'promo_code_id' => $request->promoCode,
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
