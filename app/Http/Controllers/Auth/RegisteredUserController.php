<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'tel' => 'string',
            // 'sex' => 'integer|in:0,1,2',
            // 'birth' => 'date',
            // 'postal' => 'integer',
            // 'prefectures' => 'string|max:255',
            // 'city' => 'string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'tel' => $request->tel,
            // 'sex' => $request->sex,
            // 'birth' => $request->birth,
            // 'postal' => $request->postal,
            // 'prefectures' => $request->prefectures,
            // 'city' => $request->city,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect(route('company.index', absolute: false));
        return redirect()->route('verification.notice');
    }
}
