<?php

namespace App\Http\Controllers;

use App\Http\Services\AddressService;

class AddressController extends Controller
{
    public static function getAddressModalOptions()
    {
        $response = AddressService::getAddressModalOptionData();

        return response($response);
    }
}
