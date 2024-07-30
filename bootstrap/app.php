<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'loggedIn' => \App\Http\Middleware\LoggedIn::class,
            'authCheck' => \App\Http\Middleware\AuthCheck::class,
            'adminCheck' => \App\Http\Middleware\AdminCheck::class,
            'verifySession'=>\App\Http\Middleware\EnsureVerificationSession::class,
            'rememberMe' => \App\Http\Middleware\RememberMe::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
