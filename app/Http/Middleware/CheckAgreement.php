<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAgreement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ユーザーがログインしているかチェックし、プライバシーポリシーに同意しているかを確認
        if (Auth::check() && Auth::user()->privacy == 0) {
            // 同意していない場合は同意ページにリダイレクト
            return redirect()->route('profile.edit');
        }

        return $next($request);
    }
}
