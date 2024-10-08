<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\AcademicBgController;
use App\Http\Controllers\JobBgController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobRequirementController;

//テスト用
Route::get('/test', function () {
    return Inertia::render('Test');
})->name('top');

//ダッシュボード
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// })->middleware(['auth'])->name('dashboard');

//このサイトについて
Route::get('/site-details', function () {
    return Inertia::render('JobMatch');
})->name('site-details');
//利用規約ページ
Route::get('/rules', function () {
    return Inertia::render('RulesPage');
})->name('rules');
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
//求人掲載を考えている方へ
Route::get('/jobpostings', function () {
    return Inertia::render('JobPostings');
})->name('jobpostings');

//default
Route::middleware(['auth', 'verified'])->group(function () {

    //利用登録・個人情報
    Route::get('/personal/create', function () { return Inertia::render('Profile/Registers/Personal'); })->name('personal.register');
    //利用登録・経歴
    // URL /academicbg/create
    //利用登録・資格
    // URL /jobbg/create
    //こだわり条件
    Route::get('/requirements', [JobRequirementController::class, 'create'])->name('requirements.create');
    Route::post('/requirements', [JobRequirementController::class, 'store'])->name('requirements.store');
    //内容確認
    // Route::get('/confirmation', function () { return Inertia::render('Profile/Registers/Confirmation'); })->name('confirmation');
    Route::get('/confirmation', [ProfileController::class, 'edit'])->name('profile.edit');
    
    //プロフィール
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //資格
    Route::resource('skill', SkillController::class);
    //学歴
    Route::resource('academic', AcademicBgController::class);
    //職務履歴
    Route::resource('jobbg', JobBgController::class);

    //検索ページ
    Route::get('/search', [JobController::class,'index'])->name('search');
    Route::get('/jobs-choose', function () {
        return Inertia::render('Search/Jobs');
    })->name('jobs.choose');
    Route::get('/area-choose', function () {
        return Inertia::render('Search/Area');
    })->name('area.choose');

    //Company
    Route::get('/', [JobController::class,'index'])->name('company.index');
    Route::get('/jobs/{inertiaJob}', [JobController::class,'show'])->name('company.show');

    //登録処理
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('job.apply');
    //完了画面
    Route::get('/apply-comp', function () {
        return Inertia::render('Applications/AppliedComp');
    })->name('apply.comp');
    //完了画面
    Route::get('/applied-list', [ApplicationController::class,'show'])->name('apply.list');

    //News
    Route::get('/news', [NewsController::class,'index'])->name('news.index');

    //ブックマークページ
    Route::get('/bookmarked', [BookmarkController::class, 'show'])->name('bookmarked.jobs');
    //bookmarks登録
    Route::post('/bookmark/{id}', [BookmarkController::class, 'store'])->name('bookmark.store');
    //bookmarks削除
    Route::delete('/bookmark/{jobId}', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');
});

require __DIR__.'/auth.php';

//管理者ページ
Route::prefix('admin')->name('admin.')->group(function(){
    require __DIR__.'/admin.php';
});

//企業管理者ページ
Route::prefix('manager')->name('manager.')->group(function(){
    require __DIR__.'/manager.php';
});