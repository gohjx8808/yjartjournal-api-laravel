<?php

namespace App\Http\Services;

use App\Http\Repositories\AuthRepository;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public static function signUp(SignUpRequest $request)
    {
        $user = AuthRepository::createUser($request);
        $token = AuthRepository::createAccessToken($user);

        AuthRepository::createUserRole($user->id);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public static function signIn(SignInRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = AuthRepository::getUserByEmail($email);

        if (!isset($user)) {
            return [
                'success' => false,
                'msg' => 'Incorrect username or password'
            ];
        }

        $isPasswordCorrect = Hash::check($password, $user->password);
        if (!$isPasswordCorrect) {
            return [
                'success' => false,
                'msg' => 'Incorrect username or password'
            ];
        }

        $token = AuthRepository::createAccessToken($user);

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
