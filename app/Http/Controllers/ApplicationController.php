<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InertiaJob;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function store(Request $request, $jobId)
    {

        $job = InertiaJob::findOrFail($jobId);

        // 応募データを保存
        Application::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id, // 求人ID
            'company_name' => $request->input('company_name'),
        ]);

        return redirect('/')->with('success', '応募が完了しました！');
    }

    public function show()
    {
        $managerCompanyName = Auth::user()->name; //managerの会社名
        $applicants = Application::with(['user', 'job', 'user.skills', 'user.academic_bg', 'user.job_bg'])
        //managerの会社名と応募があった会社名が一致するものだけ表示
        ->whereHas('job', function ($query) use ($managerCompanyName) {
            $query->where('companyName', $managerCompanyName);
        })
        ->get();

        // 応募者情報を管理画面に渡して表示
        return Inertia::render('AppliedPage', [
            'applicants' => $applicants,
        ]);
    }
}
