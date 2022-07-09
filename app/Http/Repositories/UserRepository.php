<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    public static function getUserById(int $userId)
    {
        return User::with('country')->find($userId);
    }
}
