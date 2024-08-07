<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\JobController;

//エンドユーザー向け
Route::get('/search', function () {
    return Inertia::render('SearchPage');
});
Route::get('/job-detail', function () {
    return Inertia::render('JobDetailPage');
});


Route::get('/jobs', [JobController::class,'index'])->name('company.index');
Route::get('/company/create', [JobController::class,'create'])->name('company.create');
Route::post('/company/job', [JobController::class,'store'])->name('company.store');
Route::get('/jobs/{inertiaJob}/edit', [JobController::class,'edit'])->name('company.edit');
Route::get('/jobs/{inertiaJob}', [JobController::class,'show'])->name('company.show'); //管理者
Route::get('/jobs/{inertiaJob}', [JobController::class,'view'])->name('company.view'); //一般ユーザー
Route::put('/company/update/{inertiaJob}', [JobController::class, 'update'])->name('inertiaJob.update');
Route::delete('/company/delete/{inertiaJob}', [JobController::class,'delete'])->name('company.delete');

Route::get('/', function () {
    return Inertia::render('TopPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/top', function () {
    return Inertia::render('TopPage');
})->name('top');

//default部分
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
