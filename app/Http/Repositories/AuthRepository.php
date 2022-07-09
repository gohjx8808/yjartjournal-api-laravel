<?php

namespace App\Http\Repositories;

use App\Http\Requests\SignUpRequest;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public static function createUser(SignUpRequest $request)
    {
        return User::create([
            'name' => $request->name,
            'date_of_birth' => $request->dob,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'country_id' => $request->countryCodeId,
            'phone_number' => $request->phoneNo,
        ]);
    }

    public static function createUserRole(int $userId, int $role)
    {
        RoleUser::firstOrCreate([
            'user_id' => $userId,
            'role_id' => $role
        ]);
    }

    public static function getUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public static function getUserRoleByUserId($userId)
    {
        return RoleUser::where('user_id', $userId)->pluck('role_id')->toArray();
    }

    public static function createAccessToken($user, $tokenPermissions)
    {
        return $user->createToken('apiToken', $tokenPermissions)->plainTextToken;
    }
}
