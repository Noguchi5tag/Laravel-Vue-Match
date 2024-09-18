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

        // dd($request->all());

        $job = InertiaJob::findOrFail($jobId);

        // 応募データを保存
        Application::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id, // 求人ID
            'company_name' => $request->input('company_name'),
        ]);

        return redirect()->back()->with('success', '応募が完了しました！');
    }

    public function show()
    {
        $applicants = Application::with(['user', 'job','user.skills', 'user.academic_bg','user.job_bg'])->get();

        // 応募者情報を管理画面に渡して表示
        return Inertia::render('AppliedPage', [
            'applicants' => $applicants,
        ]);
    }
}
