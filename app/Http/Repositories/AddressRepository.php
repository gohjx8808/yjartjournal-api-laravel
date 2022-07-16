<?php

namespace App\Http\Repositories;

use App\Models\AddressTag;
use App\Models\Receiver;
use App\Models\ReceiverAddress;

class AddressRepository
{
    public static function getAllAddressTags()
    {
        return AddressTag::get();
    }

    public static function addReceiver($name, $email, $countryCode, $phoneNum)
    {
        return Receiver::updateOrCreate([
            'name' => $name,
            'email' => $email,
            'country_id' => $countryCode,
            'phone_number' => $phoneNum
        ]);
    }

    public static function getExistingAddress($userId, $receiverId)
    {
        return ReceiverAddress::query()
            ->where('user_id', $userId)
            ->where('receiver_id', $receiverId)
            ->get();
    }

    public static function addAddress(
        $userId,
        $receiverId,
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
            'receiver_id' => $receiverId,
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
