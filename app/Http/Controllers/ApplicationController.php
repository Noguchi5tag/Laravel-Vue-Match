<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InertiaJob;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Manager;

class ApplicationController extends Controller
{
    public function store(Request $request, $jobId)
    {

        $job = InertiaJob::findOrFail($jobId);

        // 応募データを保存
        Application::create([
            'user_id' => Auth::id(),
            'inertia_job_id' => $job->id, // 求人ID
            'company_name' => $request->input('company_name'),
        ]);
    }

    public function show(Request $request)
    {
        //managerでしか表示できない
        if ($request->is('manager/*')) {
            $managerCompanyName = Auth::user()->name; //managerの会社名
            $applicants = Application::with(['user', 'job', 'user.skills', 'user.academic_bg', 'user.job_bg'])
            //managerの会社名と応募があった会社名が一致するものだけ表示
            ->whereHas('job', function ($query) use ($managerCompanyName) {
                $query->where('companyName', $managerCompanyName);
            })
            ->get();

            // 応募者情報を管理画面に渡して表示
            return Inertia::render('Applications/AppliedPage', [
                'applicants' => $applicants,
            ]);
        } else {
            $userId = Auth::id(); // ログインしているユーザーID
            // ログインユーザーが応募した求人情報を取得
            $applications = Application::with(['job'])
                ->where('user_id', $userId)
                ->get();
            
            $user = $request->user();
            $bookmarkedJobs = $user->bookmarks()
                ->withCount('bookmarkedByUsers')
                ->get();
            
            $managers = Manager::all();

            // ユーザーの応募情報を渡して表示
            return Inertia::render('Applications/AppliedList', [
                'applications' => $applications,
                'bookmarkedJobs' => $bookmarkedJobs,
                'managers' => $managers,
            ]);
        }
    }
}
