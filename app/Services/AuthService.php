<?php

namespace App\Services;

use App\Jobs\SendVerificationEmailJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function loginUser(string $login, string $password, $remember = null)
    {
        $user = User::where('email', $login)
            ->orWhere('username',$login)
            ->first();

        if ($remember == 'on') {

            $rememberToken = md5(rand(1, 10) . microtime());
            $user->remember_token = $rememberToken;
            $user->save();
            Cookie::queue(Cookie::make('remember_token', $rememberToken, 60 * 24));
        }

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
        Cookie::queue(Cookie::forget('remember_token'));
        return true;
    }

    public function sendVerificationEmail(string $email)
    {

        $user = User::where('email', $email)->first();
        if ($user) {
            $verificationCode = random_int(1000, 9999);

            DB::table('password_resets')->insert(
                [
                    'email' => $email,
                    'verification_code' => $verificationCode,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'expired_at' => Carbon::now()->addMinute(15)

                ]);
            Session::put('email', $user->email);

            SendVerificationEmailJob::dispatch($user, $verificationCode);

            return true;
        } else {
            return false;
        }
    }


    public function verifyCode(string $email, string $verificationCode)
    {

        $data = DB::table('password_resets')->where('email', $email)
            ->where('verification_code', $verificationCode)
            ->first();

        if ($data) {
            if ($data->expired_at < Carbon::now()) {
                Session::forget('email');
                return ['status' => false, 'expired' => true, 'message' => 'Session Expired'];
            }
            return ['status' => true, 'message' => 'Redirect to reset password'];
        }

        return ['status' => false, 'expired' => false, 'message' => 'Verification code does not correct'];
    }


    public function resetPassword($password)
    {

        $user = User::where('email', Session::get('email'))->first();

        if ($user) {
            $user->password = Hash::make($password);
            $user->save();

            Session::forget('email');
            return true;
        } else {
            return false;
        }
    }


}
