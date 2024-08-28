<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NewsController;

//テスト用
Route::get('/test', function () {
    return Inertia::render('Test');
})->name('top');

//エンドユーザー向け
Route::get('/', function () {
    return Inertia::render('TopPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//ダッシュボード
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
})->middleware(['auth'])->name('dashboard');

//default
Route::middleware('auth')->group(function () {
    
    //プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //検索ページ
    Route::get('/search', function () {
        return Inertia::render('SearchPage');
    })->name('search');
    //利用規約ページ
    Route::get('/rules', function () {
        return Inertia::render('RulesPage');
    })->name('RulesPage');
    //プライバシーポリシーページ
    Route::get('/privacy', function () {
        return Inertia::render('PrivacyPage');
    })->name('Privacy');
    //お問い合わせページ
    Route::get('/contact', function () {
        return Inertia::render('ContactPage');
    })->name('Contact');
    //よくある質問ページ
    Route::get('/questions', function () {
        return Inertia::render('QuestionsPage');
    })->name('Questions');
    //お知らせページ
    Route::get('/news', function () {
        return Inertia::render('NewsPage');
    })->name('News');
    //ブックマークページ
    Route::get('/bookmark', function () {
        return Inertia::render('BookmarkPage');
    })->name('Bookmark');

    //Company
    Route::get('/jobs', [JobController::class,'index'])->name('company.index');
    Route::get('/jobs/{inertiaJob}', [JobController::class,'show'])->name('company.show');

    //News
    Route::get('/news', [NewsController::class,'index'])->name('news.index');
});

require __DIR__.'/auth.php';

//管理者ページ
Route::prefix('admin')->name('admin.')->group(function(){
    
    Route::get('/', function () {
        return Inertia::render('TopPage');
    })->middleware(['auth:admin', 'verified'])->name('top');

    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->middleware(['auth:admin', 'verified'])->name('dashboard');

    Route::get('/profile', [AdminProfileController::class, 'edit'])->middleware(['auth:admin', 'verified'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');

    //Company
    Route::get('/companylist', [JobController::class,'index'])->middleware(['auth:admin', 'verified'])->name('companylist.index');
    Route::get('/company/create', [JobController::class,'create'])->middleware(['auth:admin', 'verified'])->name('company.create');
    Route::post('/company/job', [JobController::class,'store'])->name('company.store'); //登録
    Route::get('/jobs/{inertiaJob}/edit', [JobController::class,'edit'])->middleware(['auth:admin', 'verified'])->name('company.edit');
    Route::get('/jobs/{inertiaJob}', [JobController::class,'show'])->middleware(['auth:admin', 'verified'])->name('company.show');
    Route::put('/company/update/{inertiaJob}', [JobController::class, 'update'])->name('company.update');
    Route::delete('/company/delete/{inertiaJob}', [JobController::class,'delete'])->name('company.delete');

    //News
    Route::get('/news', [NewsController::class, 'index'])->middleware('auth:admin')->name('newslist.index');
    Route::get('/news/create', [NewsController::class, 'create'])->middleware('auth:admin')->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    require __DIR__.'/admin.php';
});