<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const TO_PAY = 1;
    const TO_SHIP = 2;
    const TO_RECEIVE = 3;
    const COMPLETED = 4;
}
