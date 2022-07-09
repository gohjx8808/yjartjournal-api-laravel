<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAccountDetailsRequest;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public static function getAccountDetails(GetAccountDetailsRequest $request)
    {
        $response = UserService::getAccountDetails($request);

        return response($response);
    }
}
