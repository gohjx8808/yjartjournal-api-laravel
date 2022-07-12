<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\UserRepository;

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
}
