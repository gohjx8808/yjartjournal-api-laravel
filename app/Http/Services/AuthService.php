<?php

namespace App\Http\Services;

use App\Http\Repositories\AuthRepository;
use App\Http\Requests\SignUpRequest;

class AuthService
{
    public static function signUp(SignUpRequest $request)
    {
        $user = AuthRepository::createUser($request);
        $token = $user->createToken('apiToken')->plainTextToken;

        AuthRepository::createUserRole($user->id);

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
