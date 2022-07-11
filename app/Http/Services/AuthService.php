<?php

namespace App\Http\Services;

use App\Http\Repositories\AuthRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public static function signUpOptions()
    {
        $countries = UserRepository::getAllCountries();

        $countryCodes = $countries->map(function ($country) {
            return ['id' => $country->id, 'iso2' => $country->iso2, 'phoneCode' => $country->phone_code];
        });

        return [
            'countryCodes' => $countryCodes,
        ];
    }

    public static function signUp(SignUpRequest $request)
    {
        $user = AuthRepository::createUser($request);

        AuthRepository::createUserRole($user->id, Role::CUSTOMER);

        return [
            'user' => $user,
        ];
    }

    public static function signIn(SignInRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = AuthRepository::getUserByEmail($email);

        $isPasswordCorrect = Hash::check($password, $user->password);
        if (!isset($user) || !$isPasswordCorrect) {
            return [
                'success' => false,
                'msg' => 'Incorrect username or password'
            ];
        }

        $userRoles = AuthRepository::getUserRoleByUserId($user->id);

        $tokenPermissions = [];

        if (in_array(Role::ADMIN, $userRoles)) {
            array_push($tokenPermissions, 'role-admin');
        }
        if (in_array(Role::CUSTOMER, $userRoles)) {
            array_push($tokenPermissions, 'role-customer');
        }

        $token = AuthRepository::createAccessToken($user, $tokenPermissions);

        $data = [
            'user' => $user,
            'token' => $token
        ];

        return ['success' => true, 'data' => $data];
    }

    public static function signOut()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return ['msg' => 'User logged out'];
    }
}
