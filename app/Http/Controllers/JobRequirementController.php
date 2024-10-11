<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobRequirement;
use Inertia\Inertia;
use App\Models\JobBg;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class JobRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Profile/Requirements/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'user_id' => 'required|integer',
            'job_category' => 'nullable|string',
            'prefecture' => 'nullable|string',
            'dutyStation' => 'nullable|string',
            'relocation' => 'nullable|boolean',
            'job_join' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'salary_type' => 'nullable|string',
            'salary_amount' => 'nullable|integer',
            'particular_type' => 'nullable|string',
        ]);

        // データベースに保存
        JobRequirement::create($validated);

        return to_route('profile.edit');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Profile/Registers/Confirmation');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $user = $request->user();
        $job_requirements = $user->jobRequirements()->get();

        return Inertia::render('Profile/Requirements/Edit', [
            'job_requirements' => $job_requirements,
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'job_category' => 'nullable|array',
            'prefecture' => 'nullable|string',
            'dutyStation' => 'nullable|string',
            'relocation' => 'nullable|boolean',
            'job_join' => 'nullable|string',
            'employment_type' => 'nullable|array',
            'salary_type' => 'nullable|string',
            'salary_amount' => 'nullable|integer',
            'particular_type' => 'nullable|array',
        ]);

        $validated['job_category'] = implode(',', $request->input('job_category', []));
        $validated['employment_type'] = implode(',', $request->input('employment_type', []));
        $validated['particular_type'] = implode(',', $request->input('particular_type', []));

        $jobRequirement = JobRequirement::findOrFail($id);

        $jobRequirement->update($validated);

        return to_route('profile.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
