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
        $request->validate([
            'name' => 'required|string|max:255',
            'login_name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.Manager::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Manager::create([
            'name' => $request->name,
            'login_name' => $request->login_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::guard('manager')->login($user);
        Log::info('マネージャー登録成功');

        return redirect(route('manager.dashboard')); //登録後のリダイレクト先
    }
}
