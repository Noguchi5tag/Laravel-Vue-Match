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
use Illuminate\Support\Facades\Storage;
use App\Models\JobRequirement;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $userAuth = Auth::user();
        $userId = Auth::id();

        // $user = User::with('skills')->findOrFail($userId);
        $user = User::with(['academic_bg', 'job_bg', 'jobRequirements'])->findOrFail($userId);

        // ユーザーが資格を持っているかどうかを判定
        // $hasSkill = $user->skills->isNotEmpty();
        $hasAcademicBg = $user->academic_bg !== null;
        $hasJobBg = $user->job_bg !== null;

        return Inertia::render('Profile/Registers/Confirmation', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'userAuth' => $userAuth,
            'academic_bg' => $user->academic_bg,
            'job_bg' => $user->job_bg,
            'hasAcademicBg' => $hasAcademicBg,
            'hasJobBg' => $hasJobBg,
            'job_requirements' => $user->jobRequirements,
        ]);

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // バリデーションされたデータを取得
        $validatedData = $request->validated();

        $referer = $request->header('referer');
    
        // ファイルがアップロードされた場合の処理
        if ($request->hasFile('profile_image')) {
            $image = 'profile_image';
            // 画像のオリジナル名を取得し、ストレージと公開ディレクトリに保存
            $originalName = $request->file($image)->getClientOriginalName();

            $oldImage = $request->user()->profile_image;
    
            // 古い画像が存在する場合は削除
            if ($oldImage && Storage::exists('public/storages/user/profile/' . $oldImage)) {
                Storage::delete('public/storages/user/profile/' . $oldImage);
            }
    
            // 新しい画像を保存し、保存パスを取得
            $path = $request->file($image)->storeAs('public/storages/user/profile/', $originalName);
            $validatedData['profile_image'] = basename($path); // データベースに保存するパスを設定
        } else {
            unset($validatedData['profile_image']);
        }
    
        // ユーザー情報の更新
        $user = $request->user();
        $user->fill($validatedData);
    
        // メールアドレスが変更された場合は認証をリセット
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        // ユーザー情報を保存
        $user->save();

        if (Str::contains($referer, '/personal/create')) {
            return to_route('academic.create');
        }
    
        return to_route('profile.edit')->with('message', '更新しました');
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
