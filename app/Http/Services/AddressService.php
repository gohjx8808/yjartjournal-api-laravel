<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\AddAddressRequest;
use App\Http\Requests\DeleteAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressService
{
    public static function getAddressList()
    {
        $userId = Auth::id();

        $addresses = AddressRepository::getAddressByUserId($userId);

        return $addresses->map(function ($address) {
            return [
                'id' => $address->id,
                'name' => $address->name,
                'formattedPhoneNumber' => $address['countryCode']->phone_code . $address->phone_number,
                'addressLine1' => $address->address_line_one,
                'addressLine2' => $address->address_line_two,
                'postcode' => $address->postcode,
                'city' => $address->city,
                'state' => $address->state,
                'country' => $address['country']->name,
                'default' => $address->_default,
                'addressTag' => $address['addressTag']?->name
            ];
        });
    }

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
        $default = $request->default;

        $userId = Auth::id();

        DB::beginTransaction();

        self::checkDefaultAddress($userId, $default);

        $address = AddressRepository::addAddress($request, $userId);

        DB::commit();

        return ['address' => $address];
    }

    public static function checkDefaultAddress(int $userId, bool $default)
    {
        if ($default) {
            $existingAddress = AddressRepository::getAddressByUserId($userId);
            $existingAddress->map(function ($address) {
                $address->_default = false;
                $address->save();
            });
        }
    }

    public static function updateAddress(UpdateAddressRequest $request)
    {
        $default = $request->default;

        $userId = Auth::id();

        DB::beginTransaction();

        self::checkDefaultAddress($userId, $default);

        AddressRepository::updateAddress($request);

        DB::commit();

        return ['success' => true, 'msg' => 'ok'];
    }

    public static function deleteAddress(DeleteAddressRequest $request)
    {
        $addressId = $request->addressId;

        AddressRepository::deleteAddressById($addressId);

        return ['success' => true, 'msg' => 'ok'];
    }
}
