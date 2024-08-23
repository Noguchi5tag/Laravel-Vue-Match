<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\JobController;

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

//プロフィール
Route::middleware('auth')->group(function () {
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
    Route::get('/jobs/{inertiaJob}', [JobController::class,'view'])->name('company.view');
    });
require __DIR__.'/auth.php';


Route::get('/company/create', [JobController::class,'create'])->name('company.create');
Route::post('/company/job', [JobController::class,'store'])->name('company.store'); //登録
Route::get('/jobs/{inertiaJob}/edit', [JobController::class,'edit'])->name('company.edit');
Route::get('/jobs/{inertiaJob}', [JobController::class,'show'])->name('company.show'); //管理者
// Route::get('/jobs/{inertiaJob}', [JobController::class,'view'])->name('company.view'); //一般ユーザー
Route::put('/company/update/{inertiaJob}', [JobController::class, 'update'])->name('company.update');
Route::delete('/company/delete/{inertiaJob}', [JobController::class,'delete'])->name('company.delete');


//管理者ページ
Route::prefix('admin')->name('admin.')->group(function(){

    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->middleware(['auth:admin', 'verified'])->name('dashboard');

    require __DIR__.'/admin.php';
});