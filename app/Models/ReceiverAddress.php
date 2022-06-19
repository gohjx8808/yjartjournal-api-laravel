<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiverAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address_line_one', 'address_line_two', 'postcode', 'city', 'state', 'country_id', '_default', 'address_tag_id', 'receiver_id'
    ];
}
