<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middlewares são configurados aqui
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect()->guest(route('admin.login'));
            }

            return redirect()->guest(route('login'));
        });
    })
    ->withProviders([
        App\Providers\NotificationServiceProvider::class,
    ])
    ->create();
