<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function loginUser(string $email, string $password)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                Session::put('userId', $user->id_user);
                return true;
            } else {
                return 'Invalid password';

            }
        } else {
            return 'User not found';
        }

    }

    public function logoutUser()
    {
        Session::forget('userId');
        return true;
    }


}
