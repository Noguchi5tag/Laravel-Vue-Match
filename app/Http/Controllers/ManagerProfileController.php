<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

class ManagerProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('Manager/Profile/Edit', [
            'mustVerifyEmail' => $request->user('manager') instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {

        // dd($request->all());

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'login_name' => ['string', 'max:255'],
            'manager_url' => ['string', 'max:255'],
            'tel_manager' => ['nullable', 'string', 'max:15'],
            'manager_address_number' => ['required', 'string'],
            'manager_address' => ['required', 'string', 'max:255'],
            'business' => ['required', 'string'],
            'recruit_manager' => ['required', 'string', 'max:255'],
            'other_manager' => ['nullable', 'string'],
            'image_manager' => ['nullable', 'image', 'max:5120'],
        ]);
        
        $user = $request->user('manager');
        $user->fill($validatedData);

        $image = 'image_manager';

    if ($request->hasFile($image)) {
        $originalName = $request->file($image)->getClientOriginalName();

        // 古い画像が存在する場合は削除
        if ($user->{$image}) {
            Storage::delete('public/storages/' . $originalName);
        }

        // 画像のオリジナル名を取得し、ストレージと公開ディレクトリに保存
        $originalName = $request->file($image)->getClientOriginalName();
        // 画像を保存し、パスを取得
        $path = $request->file($image)->storeAs('public/storages', $originalName);
        $validatedData[$image] = basename($path); // データベースに保存するパスを設定
    } else {
        // 既存の画像パスを保持
        $validatedData[$image] = $user->{$image};
    }
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->update($validatedData);

        return Redirect::route('manager.profile.edit')->with('status', 'プロフィールを更新しました');
        
    }

    public function destroy(Request $request): RedirectResponse
    {
        // 管理者アカウント削除処理
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user('manager');

        Auth::guard('manager')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/manager/login');
    }
}
