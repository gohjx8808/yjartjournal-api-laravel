<?php

namespace App\Http\Repositories;

use App\Models\AddressTag;
use App\Models\ReceiverAddress;

class AddressRepository
{
    public static function getAllAddressTags()
    {
        return AddressTag::get();
    }

    public static function getExistingAddress($userId)
    {
        return ReceiverAddress::query()
            ->where('user_id', $userId)
            ->get();
    }

    public static function addAddress(
        $userId,
        $receiverName,
        $receiverEmail,
        $receiverCountryCode,
        $receiverPhoneNumber,
        $addressLine1,
        $addressLine2,
        $postcode,
        $city,
        $state,
        $countryId,
        $default,
        $tagId
    ) {
        return ReceiverAddress::updateOrCreate([
            'user_id' => $userId,
            'name' => $receiverName,
            'email' => $receiverEmail,
            'country_code_id' => $receiverCountryCode,
            'phone_number' => $receiverPhoneNumber,
            'address_line_one' => $addressLine1,
            'postcode' => $postcode,
            'city' => $city,
            'state' => $state,
            'country_id' => $countryId
        ], [
            'address_line_two' => $addressLine2,
            '_default' => $default,
            'address_tag_id' => $tagId
        ]);
    }
}
