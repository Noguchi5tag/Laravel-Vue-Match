<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Models\InertiaJob;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            // 新着求人数をカウント
            'totalNewJobs' => function () {
                return InertiaJob::where('is_checked', 0)->count(); 
            },

            //ユーザーとマッチングしたかどうか
            'applicants' => function () {
                if (Auth::check()) {
                    // ログインユーザーに関連する応募者データを取得
                    return Application::with('user', 'job')->where('user_id', Auth::id())->get();
                }
                return [];
            },
        ]);
    }
}
