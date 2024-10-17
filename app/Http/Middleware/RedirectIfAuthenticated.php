<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //管理者
        if ($request->is('admin/*') && Auth::guard('admin')->check()) {
            if ($request->route()->getName() === 'admin.login' || $request->route()->getName() === 'admin.register') {
                return redirect()->route('admin.dashboard');
            }
        }
        // マネージャー用のリダイレクト処理
        elseif ($request->is('manager/*') && Auth::guard('manager')->check()) {
            if ($request->route()->getName() === 'manager.login' || $request->route()->getName() === 'manager.register') {
                return redirect()->route('manager.dashboard');
            }
        }
        // 一般ユーザー用のリダイレクト処理
        elseif (($request->is('login') || $request->is('register')) && Auth::guard('web')->check()) {
            return redirect()->route('company.index');
        }

        return $next($request);
    }
}