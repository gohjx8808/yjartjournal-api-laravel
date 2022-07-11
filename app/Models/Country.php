<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'iso2',
        'iso3',
        'name',
        'phone_code',
    ];

    /**
     * Get the phone code.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function phoneCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => '+' . $value,
        );
    }
}
