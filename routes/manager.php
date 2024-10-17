<?php

use App\Http\Controllers\Manager\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Manager\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Manager\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Manager\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Manager\Auth\NewPasswordController;
use App\Http\Controllers\Manager\Auth\PasswordController;
use App\Http\Controllers\Manager\Auth\PasswordResetLinkController;
use App\Http\Controllers\Manager\Auth\RegisteredUserController;
use App\Http\Controllers\Manager\Auth\VerifyEmailController;

use App\Http\Controllers\ManagerProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest:manager')->group(function () {
    
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->middleware('guest:manager')
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
                ->middleware('guest:manager');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest:manager')
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest:manager')
                ->name('login.managerSubmit');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest:manager')
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest:manager')
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest:manager')
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest:manager')
                ->name('password.store');
});

Route::middleware('auth:manager')->group(function () {

    Route::get('/', function () {
        return Inertia::render('TopPage');
    })->middleware(['auth:manager', 'verified'])->name('top');

    Route::get('/dashboard', function () {
        return Inertia::render('Manager/Dashboard');
    })->middleware(['auth:manager', 'verified'])->name('dashboard');

    Route::get('/profile', [ManagerProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ManagerProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ManagerProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update', [ManagerProfileController::class, 'update'])->name('profile.update');

    //Company
    Route::get('/companylist', [JobController::class,'index'])->middleware('auth:manager')->name('companylist.index');
    Route::get('/company/create', [JobController::class,'create'])->middleware('auth:manager')->name('company.create');
    Route::post('/company/job', [JobController::class,'store'])->name('company.store');
    Route::get('/jobs/{inertiaJob}/edit', [JobController::class,'edit'])->middleware('auth:manager')->name('company.edit');
    Route::get('/jobs/{inertiaJob}', [JobController::class,'show'])->middleware('auth:manager')->name('company.show');
    Route::put('/company/update/{inertiaJob}', [JobController::class, 'update'])->name('company.update');

    //いいね！があった応募者リスト
    Route::get('/applied', [ApplicationController::class, 'show'])->name('applied.show');
    //企業側がいいね！
    Route::post('/applicants/{id}/like', [ApplicationController::class, 'update']);

    //会員リスト
    Route::get('/members', [MemberController::class, 'index'])->name('member.index');

    Route::get('verify-email', EmailVerificationPromptController::class)
                ->middleware('auth:manager')
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth:manager')
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth:manager');

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth:manager')
                ->name('logout');
});