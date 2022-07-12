<?php

namespace App\Http\Repositories;

use App\Models\AddressTag;

class AddressRepository
{
    public static function getAllAddressTags()
    {
        return AddressTag::get();
    }
}
