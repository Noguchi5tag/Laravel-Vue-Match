<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // ユーザーのメールアドレスがすでに確認済みかどうか
        // メールからのリダイレクト先
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('personal.register', absolute: false).'?verified=1');
        }

        //ユーザーのメールアドレスを認証済みにする
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        //認証が完了したことを通知してリダイレクト
        return redirect()->intended(route('personal.register', absolute: false).'?verified=1');
    }
}
