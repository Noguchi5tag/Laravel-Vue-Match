<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobBgRequest;
use App\Http\Requests\UpdateJobBgRequest;
use App\Models\JobBg;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobBgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(JobBg $jobBgs, Request $request)  
    {
        $userId = Auth::id();
        $jobBgs = JobBg::where('user_id', $userId)->get();

        return Inertia::render('Profile/Jobs/Index', [
            'jobBgs' => $jobBgs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Log::info('JobBgController@create called');

        $userId = Auth::id();
        $user = User::with('job_bg')->findOrFail($userId);

        return Inertia::render('Profile/Registers/JobBg',[
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobBgRequest $request)
    {
        try {
            // dd($request->all());

            $validated = $request->validated();

            JobBg::create([
                'user_id' => $validated['user_id'],
                'company_name' => $validated['company_name'],
                'company_business' => $validated['company_business'],
                'start_enrollment_year' => $validated['start_enrollment_year'],
                'start_enrollment_month' => $validated['start_enrollment_month'],
                'currently_working' => $validated['currently_working'],
                'end_enrollment_year' => $validated['end_enrollment_year'],
                'end_enrollment_month' => $validated['end_enrollment_month'],
                'business_other' => $validated['business_other'],
                'company_post' => $validated['company_post'],
                'company_pay_type' => $validated['company_pay_type'],
                'company_pay' => $validated['company_pay'],
            ]);

            return to_route('profile.edit')->with('success', '職歴を追加しました');

        } catch (\Exception $e) {
            Log::error('JobBg store error', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => '職歴の追加中にエラーが発生しました。']);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(JobBg $jobBg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobBg $jobBg, Request $request)
    {
        $user = $request->user();
        $jobBgs = $user->job_Bg()->get(); // 学歴データを取得する例

        return Inertia::render('Profile/Jobs/Edit', [
            'user' => $request->user(),
            'jobBgs' => $jobBgs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobBgRequest $request, JobBg $jobbg)
    {
        $validated = $request->validated();
        $validated['currently_working'] = $request->has('currently_working') ? $request->input('currently_working') : false;
        $jobbg->update($validated);
        return to_route('profile.edit')->with('success', '職歴を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobBg $jobBg)
    {
        //
    }
}
