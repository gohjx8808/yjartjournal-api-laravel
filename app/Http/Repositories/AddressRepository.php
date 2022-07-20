<?php

namespace App\Http\Repositories;

use App\Http\Requests\AddAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\AddressTag;
use App\Models\ReceiverAddress;

class AddressRepository
{
    public static function getAllAddressTags()
    {
        return AddressTag::get();
    }

    public static function getAddressByUserId(int $userId)
    {
        return ReceiverAddress::query()
            ->where('user_id', $userId)
            ->get();
    }

    public static function addAddress(
        int $userId,
        AddAddressRequest $request
    ) {
        return ReceiverAddress::updateOrCreate([
            'user_id' => $userId,
            'name' => $request->receiverName,
            'email' => $request->receiverEmail,
            'country_code_id' => $request->receiverCountryCode,
            'phone_number' => $request->receiverPhoneNumber,
            'address_line_one' => $request->addressLine1,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'state' => $request->state,
            'country_id' => $request->countryId
        ], [
            'address_line_two' => $request->addressLine2,
            '_default' => $request->default,
            'address_tag_id' => $request->tagId
        ]);
    }

    public static function updateAddress(UpdateAddressRequest $request)
    {
        ReceiverAddress::query()
            ->find($request->addressId)
            ->update([
                'name' => $request->receiverName,
                'email' => $request->receiverEmail,
                'country_code_id' => $request->receiverCountryCode,
                'phone_number' => $request->receiverPhoneNumber,
                'address_line_one' => $request->addressLine1,
                'address_line_two' => $request->addressLine2,
                'postcode' => $request->postcode,
                'city' => $request->city,
                'state' => $request->state,
                'country_id' => $request->countryId,
                '_default' => $request->default,
                'address_tag_id' => $request->tagId
            ]);
    }

    public static function deleteAddressById($addressId)
    {
        ReceiverAddress::find($addressId)->delete();
    }
}
