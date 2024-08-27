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
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard === 'admin') {
                $currentPath = trim($request->path(), '/');

                // /admin/login または /admin/register にアクセスした場合のみリダイレクト
                if ($currentPath === 'admin/login' || $currentPath === 'admin/register') {
                    return redirect()->route('admin.dashboard');
                }
            }
        }

        return $next($request);
    }
}