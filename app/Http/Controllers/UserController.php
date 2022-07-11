<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountDetailsRequest;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public static function getAccountDetails()
    {
        $response = UserService::getAccountDetails();

        return response($response);
    }

    public static function updateAccountDetails(UpdateAccountDetailsRequest $request)
    {
        $response = UserService::updateAccountDetails($request);

        return response($response);
    }

    public static function getAccountOptions()
    {
        $response = UserService::accountOptions();

        return response($response);
    }
}
