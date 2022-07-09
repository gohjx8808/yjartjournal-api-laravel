<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UpdateAccountDetailsRequest;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function getAccountDetails()
    {
        $userId = Auth::id();
        $userDetails = UserRepository::getUserById($userId);

        return [
            'id' => $userDetails->id,
            'name' => $userDetails->name,
            'dob' => $userDetails->date_of_birth,
            'email' => $userDetails->email,
            'gender' => $userDetails->gender,
            'phoneNo' => $userDetails['country']->phone_code . $userDetails->phone_number,
        ];
    }

    public static function updateAccountDetails(UpdateAccountDetailsRequest $request)
    {
        $userId = Auth::id();

        UserRepository::updateUserDetails($userId, $request);

        return [
            'msg' => 'ok'
        ];
    }
}
