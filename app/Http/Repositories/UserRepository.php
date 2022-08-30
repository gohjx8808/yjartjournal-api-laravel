<?php

namespace App\Http\Repositories;

use App\Http\Requests\UpdateAccountDetailsRequest;
use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;

class UserRepository
{
    public static function getUserById(int $userId)
    {
        return User::with('country')->find($userId);
    }

    public static function updateUserDetails(int $userId, UpdateAccountDetailsRequest $request)
    {
        User::find($userId)->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'country_id' => $request->countryCodeId,
            'phone_number' => $request->phoneNo,
            'date_of_birth' => Carbon::parse($request->dob),
        ]);
    }

    public static function getAllCountries()
    {
        return Country::get();
    }
}
