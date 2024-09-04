<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobBgRequest;
use App\Http\Requests\UpdateJobBgRequest;
use App\Models\JobBg;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobBgRequest $request)
    {
        //
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
    public function edit(JobBg $jobBg)
    {
        //
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
