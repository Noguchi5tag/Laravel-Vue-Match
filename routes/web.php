<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\CheckAgreement;
use App\Http\Middleware\RedirectConfirmation;
use App\Http\Controllers\JobController;
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
})->middleware(['auth', 'verified', RedirectConfirmation::class])->name('dashboard');

// ハンバーガーメニュー //

//サイトについて
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

// ハンバーガーメニューここまで //


Route::middleware(['auth', 'verified'])->group(function () {

    // 登録処理 //
    Route::get('/personal/create', function () { return Inertia::render('Profile/Personal/Create'); })->name('personal.register');
    // URL /academicbg/create
    // URL /jobbg/create

    //こだわり条件
    Route::get('/requirements', [JobRequirementController::class, 'create'])->name('requirements.create');
    Route::post('/requirements', [JobRequirementController::class, 'store'])->name('requirements.store');
    Route::get('/requirements/{id}/edit', [JobRequirementController::class, 'edit'])->name('requirements.edit');
    Route::put('/requirements/{id}', [JobRequirementController::class, 'update'])->name('requirements.update');

    //内容確認
    // Route::get('/confirmation', function () { return Inertia::render('Profile/Registers/Confirmation'); })->name('confirmation');
    Route::get('/confirmation', [ProfileController::class, 'edit'])->name('profile.edit');

    // 登録処理ここまで //
    
    //プロフィール
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //学歴
    Route::resource('academic', AcademicBgController::class);
    //職務履歴
    Route::resource('jobbg', JobBgController::class);

    //個人情報の取扱いの同意を促す
    Route::get('/agreement-notice', function () {
        Inertia::render('AgreePrivacy');
    })->name('agreement.notice');
    
    
    
    //privacy承認済みのみ閲覧可能
    Route::middleware([CheckAgreement::class])->group(function () {
        //ホーム
        Route::get('/', [JobController::class,'index'])->name('company.index');
        //検索
        Route::get('/search', [JobController::class,'index'])->name('search');

        //求人詳細
        Route::get('/jobs/{inertiaJob}', [JobController::class,'show'])->name('company.show');
    
        //いいね！の登録処理
        Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('job.apply');
        //いいね！リスト
        Route::get('/applied-list', [ApplicationController::class,'show'])->name('apply.list');
        //マッチした求人情報を通知から削除
        Route::post('/applicants/{id}/noticed', [ApplicationController::class,'noticedUpdate']);
        
        //ブックマークページ
        Route::get('/bookmarked', [BookmarkController::class, 'show'])->name('bookmarked.jobs');
        //bookmarks登録
        Route::post('/bookmark/{id}', [BookmarkController::class, 'store'])->name('bookmark.store');
        //bookmarks削除
        Route::delete('/bookmark/{jobId}', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');
    });
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