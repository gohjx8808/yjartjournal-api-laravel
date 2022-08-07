<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'receiver_address_id',
        'shipping_fee',
        'notes',
        'promo_code_id',
        'payment_option_id',
        'order_status_id',
        'total_price',
        'completed_at',
        'cancelled_at'
    ];

    public function hasManyOrderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function receiverAddress()
    {
        return $this->belongsTo(ReceiverAddress::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function paymentOption()
    {
        return $this->belongsTo(PaymentOption::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
