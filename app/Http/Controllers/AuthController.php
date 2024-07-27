<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Mail\SendEmail;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }


    public function login(AuthRequest $request)
    {
        $data = $request->validated();

        $result = $this->authService->loginUser($data['email'], $data['password']);

        if ($result === true) {
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors(['fail' => $result]);
        }
    }


    public function logout()
    {
        $result = $this->authService->logoutUser();

        return redirect()->route('login');
    }

    public function sendEmail(Request $request)
    {
        $verificationCode = random_int(1000, 9999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'verification_code' => $verificationCode,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addMinute(15),

            ]);
        Session::put('email', $request->email);

        Mail::to('ayxan.alizade89@gmail.com')->send(new SendEmail($verificationCode));

        return redirect()->route('verification');
    }


    public function verify(Request $request)
    {
        $email = Session::get('email');

        $data = DB::table('password_resets')->where('email', $email)
            ->where('verification_code', $request->verification_code)
            ->first();

        if ($data) {
            return redirect()->route('reset-password');
        }
        return back()->withErrors(['fail' => 'Verification code does not correct']);
    }

    public function reset(Request $request)
    {
        $user = User::where('email', Session::get('email'))->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('login');
    }
}
