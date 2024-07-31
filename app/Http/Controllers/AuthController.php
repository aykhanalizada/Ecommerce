<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendMailRequest;
use App\Http\Requests\Auth\VerificationRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }


    public function login(AuthRequest $request)
    {
        $data = $request->validated();

        $result = $this->authService->loginUser($data['login'], $data['password'], $data['remember'] ?? null);

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

    public function sendEmail(SendMailRequest $request)
    {
        $data = $request->validated();

        $emailSent = $this->authService->sendVerificationEmail($data['email']);

        if ($emailSent) {
            return redirect()->route('verification');
        } else {
            return back()->withErrors([
                'fail' => 'User not found'
            ]);
        }

    }


    public function verify(VerificationRequest $request)
    {
        $data = $request->validated();
        $email = Session::get('email');

        $result = $this->authService->verifyCode($email, $data['verification_code']);


        if ($result['status']) {
            return redirect()->route('reset-password');
        } else {
            if ($result['expired']) {
                return redirect()->route('forgot-password')->withErrors(['fail' => $result['message']]);
            } else {
                return back()->withErrors(['fail' => $result['message']]);
            }
        }

    }

    public function reset(ResetPasswordRequest $request)
    {
        $data = $request->validated();

        $result = $this->authService->resetPassword($data['password']);

        if ($result) {
            return redirect()->route('login');
        } else {
            return back()->withErrors(['fail', 'Error']);
        }
    }
}
