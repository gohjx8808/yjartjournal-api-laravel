<?php

namespace App\Http\Repositories;

use App\Http\Requests\UpdateAccountDetailsRequest;
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
            'name' => $request->fullName,
            'gender' => $request->gender,
            'country_id' => $request->countryCode,
            'phone_number' => $request->phoneNumber,
            'date_of_birth' => Carbon::parse($request->dob),
        ]);
    }
}
