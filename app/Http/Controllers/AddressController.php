<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAddressRequest;
use App\Http\Services\AddressService;

class AddressController extends Controller
{
    public static function getAddressModalOptions()
    {
        $response = AddressService::getAddressModalOptionData();

        return response($response);
    }

    public static function addAddress(AddAddressRequest $request)
    {
        $response = AddressService::addAddress($request);

        return response($response);
    }
}
