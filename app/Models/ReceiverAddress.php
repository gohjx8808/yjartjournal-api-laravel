<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiverAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'country_code_id',
        'phone_number',
        'address_line_one',
        'address_line_two',
        'postcode',
        'city',
        'state',
        'country_id',
        '_default',
        'address_tag_id',
    ];

    public function countryCode()
    {
        return $this->belongsTo(Country::class, 'country_code_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function addressTag()
    {
        return $this->belongsTo(AddressTag::class);
    }
}
