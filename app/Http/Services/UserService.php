<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\GetAccountDetailsRequest;

class UserService
{
    public static function getAccountDetails(GetAccountDetailsRequest $request)
    {
        $userId = $request->userId;

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
}
