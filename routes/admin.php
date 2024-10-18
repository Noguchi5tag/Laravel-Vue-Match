<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use Inertia\Inertia;

Route::middleware('guest:admin')->group(function () {
    
    Route::get('register', [RegisteredUserController::class, 'create'])
    ->middleware(['guest:admin', RedirectIfAuthenticated::class])
    ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->middleware(['guest:admin', RedirectIfAuthenticated::class])
        ->name('register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->middleware(['guest:admin', RedirectIfAuthenticated::class])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(['guest:admin', RedirectIfAuthenticated::class])
        ->name('login.adminSubmit');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest:admin')
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest:admin')
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest:admin')
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest:admin')
                ->name('password.store');
});

Route::middleware('auth:admin')->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');

    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');

    //Company
    Route::get('/companylist', [JobController::class,'index'])->name('companylist.index');
    Route::get('/new/companylist', [JobController::class,'index'])->name('new.companylist.index');
    Route::get('/company/create', [JobController::class,'create'])->name('company.create');
    Route::post('/company/job', [JobController::class,'store'])->name('company.store'); //登録
    Route::get('/jobs/{inertiaJob}/edit', [JobController::class,'edit'])->name('company.edit');
    Route::get('/jobs/{inertiaJob}', [JobController::class,'show'])->name('company.show');
    Route::put('/company/update/{inertiaJob}', [JobController::class, 'update'])->name('company.update');
    Route::delete('/company/delete/{inertiaJob}', [JobController::class,'delete'])->name('company.delete');

    //News
    Route::get('/news', [NewsController::class, 'index'])->name('newslist.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});