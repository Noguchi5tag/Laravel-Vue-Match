<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        var_dump($guards);

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // 管理者用のリダイレクト
                if ($guard === 'admin') {
                    if ($request->is('admin/login') || $request->is('admin/register')) {
                        return redirect()->route('admin.dashboard');
                    }
                }

                // 通常ユーザー用のリダイレクト
                return redirect()->route('top');
            }
        }

        return $next($request);
    }
}