<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $userAuth = Auth::user();
        $userId = Auth::id();
        $user = User::with('skills')->findOrFail($userId);
        $user = $request->user()->load('academic_bg', 'job_bg');

        // ユーザーが資格を持っているかどうかを判定
        $hasSkill = $user->skills->isNotEmpty();
        $hasAcademicBg = $user->academic_bg !== null;
        $hasJobBg = $user->job_bg !== null;

        // dd($user->academic_bg);

        // if (!$hasAcademicBg) {
        //     return Inertia::render('Profile/Registers/Academic');
        // } elseif (!$hasJobBg) {
        //     return Inertia::render('Profile/Registers/JobBg');
        // } else {
            return Inertia::render('Profile/Registers/Confirmation', [
                'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
                'status' => session('status'),
                'userAuth' => $userAuth,
                'academic_bg' => $user->academic_bg,
                'job_bg' => $user->job_bg,
                'hasAcademicBg' => $hasAcademicBg,
                'hasJobBg' => $hasJobBg,
            ]);
        // }

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // dd([
        //     'path' => $request->path(),
        //     'fullUrl' => $request->fullUrl(),
        //     'is_search' => $request->is('applied-list'),
        //     'is_api_search' => $request->is('api/search'),
        //     'method' => $request->method(),
        //     'all' => $request->all(),
        //     'headers' => $request->headers->all(),
        // ]);

        $user = $request->user();
        $user->fill($request->validated());

        $referer = $request->header('referer');
    
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();

        if (Str::contains($referer, '/personal/create')) {
            return Redirect::route('academic.create');
        }

        return Redirect::route('profile.edit')->with('success', '更新しました');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }
}
