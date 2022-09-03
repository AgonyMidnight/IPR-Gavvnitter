<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function updateProfile($userData, $user)
    {
        $user->update([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'login' => $userData['login'],
            'gender' => User::getGender($userData['sex']),
        ]);
    }


}
