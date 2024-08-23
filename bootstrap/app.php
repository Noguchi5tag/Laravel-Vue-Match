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
            // \App\Http\Middleware\RedirectIfAuthenticated::class, //ミドルウェアの追加
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //追記
        //MiddlewareのAuthenticate.phpは未認証の遷移先。
        //MiddlewareのRedirectIfAuthenticatedは認証後の遷移ページ。
        //MiddlewareのAuthenticate.phpに書いてたもの
        $middleware->redirectGuestsTo(function (Request $request) {
            $request->is('admin*') ? route('admin.login') : route('login');
        });

        //MiddlewareのRedirectIfAuthenticatedに書いてたもの
        // if (Auth::guard('admin')->check()) {
        //     return route('admin.dashboard');
        // }
        // return route('dashboard');

    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
