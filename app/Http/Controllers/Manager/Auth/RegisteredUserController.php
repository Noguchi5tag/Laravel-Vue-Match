<?php

namespace App\Http\Controllers\Manager\Auth;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Manager/Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'login_name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.Manager::class,
            'manager_url' => 'string|max:255',
            'tel_manager' => 'required|string|max:12',
            'manager_address_number' => 'required', 'regex:/^\d{3}-?\d{4}$/',
            'manager_address' => 'required|string|max:255',
            'business' => 'required|string|max:255',
            'recruit_manager' => 'required|string|max:255',
            'other_manager' => 'nullable|string|max:1000',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image_manager' => ['nullable', 'image', 'max:5120'],
        ]);

        $user = Manager::create([
            'name' => $validatedData['name'],
            'login_name' => $validatedData['login_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'manager_url' => $validatedData['manager_url'] ?? null,
            'tel_manager' => $validatedData['tel_manager'],
            'manager_address_number' => $validatedData['manager_address_number'],
            'manager_address' => $validatedData['manager_address'],
            'business' => $validatedData['business'],
            'recruit_manager' => $validatedData['recruit_manager'],
            'other_manager' => $validatedData['other_manager'] ?? null,
        ]);

        if ($request->hasFile('image_manager')) {
            $image = $request->file('image_manager');
            $originalName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/storages', $originalName);
            $image->move(public_path('images'), $originalName);
    
            // データベースに画像パスを保存
            $user->update(['image_manager' => $originalName]);
        }

        event(new Registered($user));

        Auth::guard('manager')->login($user);
        Log::info('マネージャー登録成功');

        return redirect(route('manager.dashboard')); //登録後のリダイレクト先
    }
}
