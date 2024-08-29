<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Support\Facades\Route;//追加
use Illuminate\Http\Request;//追加
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;//追加
use Illuminate\Support\Facades\Auth;//追加

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')->as('admin.')
                ->group(base_path('routes/admin.php'));
        },//then:から追加
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            // \App\Http\Middleware\RedirectIfAuthenticated::class, //ミドルウェアの追加
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
