<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RememberMe
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('userId') && Cookie::has('remember_token')) {

            $rememberToken = Cookie::get('remember_token');
            $user = User::where('remember_token', $rememberToken)->first();

            if ($user) {
                Session::put('userId', $user->id_user);

            }
        }

        return $next($request);
    }
}
