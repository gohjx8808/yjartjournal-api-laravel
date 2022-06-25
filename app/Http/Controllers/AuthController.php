<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    public static function signUp(SignUpRequest $request)
    {
        $response = AuthService::signUp($request);

        return response($response);
    }
}
