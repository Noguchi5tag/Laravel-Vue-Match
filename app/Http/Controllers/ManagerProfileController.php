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

        try{

            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'login_name' => ['string', 'max:255'],
                'manager_url' => ['nullable' ,'string', 'max:255'],
                'line_url' => ['nullable' ,'string', 'max:255'],
                'tel_manager' => ['nullable', 'string', 'max:15'],
                'manager_address_number' => ['required', 'string'],
                'manager_address' => ['required', 'string', 'max:255'],
                'business' => ['required', 'string'],
                'recruit_manager' => ['required', 'string', 'max:255'],
                'other_manager' => ['nullable', 'string'],
                'image_manager' => ['nullable', 'image', 'max:5120'],
            ]);
            
            $user = $request->user('manager');
    
            if ($request->hasFile('image_manager')) {
                $image = 'image_manager';
                // 画像のオリジナル名を取得し、ストレージと公開ディレクトリに保存
                $originalName = $request->file($image)->getClientOriginalName();
    
                // 古い画像が存在する場合は削除
                if ($user->{$image}) {
                    Storage::delete('public/storages/manager/' . $originalName);
                }
    
                // 画像を保存し、パスを取得
                $path = $request->file($image)->storeAs('public/storages/manager', $originalName);
                $validatedData[$image] = basename($path); // データベースに保存するパスを設定
            } else {
                // 画像がない場合は、validatedDataからimage_managerを削除
                unset($validatedData['image_manager']);
            }
            
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }
        
            $user->update($validatedData);
    
            return Redirect::route('manager.profile.edit')->with('message', 'プロフィールを更新しました');

        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
        
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
