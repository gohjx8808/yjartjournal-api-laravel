<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    public static function signUp(SignUpRequest $request)
    {
        $response = AuthService::signUp($request);

        return response($response);
    }

    public static function signIn(SignInRequest $request)
    {
        $response = AuthService::signIn($request);

        if (!$response['success']) {
            return response($response, 422);
        }

        return response($response);
    }
}
