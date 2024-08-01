<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\JobController;

//エンドユーザー向け
Route::get('/top', function () {
    return Inertia::render('TopPage');
});
Route::get('/search', function () {
    return Inertia::render('SearchPage');
});
Route::get('/job-detail', function () {
    return Inertia::render('JobDetailPage');
});

//企業向け
Route::get('/company/index', [JobController::class,'index'])->name('company.index');

Route::get('/company/show/{InertiaJob}', [JobController::class,'show'])->name('company.show');



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
