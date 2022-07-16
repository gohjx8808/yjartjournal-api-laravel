<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\AddAddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressService
{
    public static function getAddressModalOptionData()
    {
        $countries = UserRepository::getAllCountries();

        $countryCodes = $countries->map(function ($country) {
            return ['id' => $country->id, 'iso2' => $country->iso2, 'phoneCode' => $country->phone_code];
        });

        $statesMalaysia = collect([
            'Johor',
            'Kedah',
            'Kelantan',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Perak',
            'Perlis',
            'Pulau Pinang',
            'Sabah',
            'Sarawak',
            'Selangor',
            'Terengganu',
            'Kuala Lumpur',
            'Labuan',
            'Putrajaya',
            'Outside Malaysia'
        ]);

        $statesOptions = $statesMalaysia->map(function ($state) {
            return ['value' => $state, 'label' => $state];
        });

        $countryOptions = $countries->map(function ($country) {
            return ['value' => $country->id, 'label' => $country->name];
        });

        $defaultOptions = [
            ['value' => 0, 'label' => 'No'],
            ['value' => 1, 'label' => 'Yes'],
        ];

        $addressTags = AddressRepository::getAllAddressTags();

        return [
            'countryCodes' => $countryCodes,
            'states' => $statesOptions,
            'countries' => $countryOptions,
            'default' => $defaultOptions,
            'addressTags' => $addressTags
        ];
    }

    public static function addAddress(AddAddressRequest $request)
    {
        $receiverName = $request->receiverName;
        $receiverEmail = $request->receiverEmail;
        $receiverCountryCode = $request->receiverCountryCode;
        $receiverPhoneNumber = $request->receiverPhoneNumber;
        $addressLine1 = $request->addressLine1;
        $addressLine2 = $request->addressLine2;
        $postcode = $request->postcode;
        $city = $request->city;
        $state = $request->state;
        $countryId = $request->countryId;
        $default = $request->default;
        $tagId = $request->tagId;

        $userId = Auth::id();

        DB::beginTransaction();

        self::checkDefaultAddress($userId, $default);

        $address = AddressRepository::addAddress(
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
        );

        DB::commit();

        return ['address' => $address];
    }

    public static function checkDefaultAddress($userId, $default)
    {
        if ($default) {
            $existingAddress = AddressRepository::getExistingAddress($userId);
            $existingAddress->map(function ($address) {
                $address->_default = false;
                $address->save();
            });
        }
    }
}
