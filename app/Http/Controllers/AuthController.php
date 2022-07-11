<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public static function getSignUpOptions()
    {
        $response = AuthService::signUpOptions();

        return response($response);
    }

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

    public static function signOut(Request $request){
        $response = AuthService::signOut($request);

        return response($response);
    }
}
