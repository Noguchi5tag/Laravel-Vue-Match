<?php

namespace App\Http\Controllers;

use App\Models\InertiaJob;
use Illuminate\Http\Request;

use Inertia\Inertia;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Company/Index', [
            'inertiaJobs' => InertiaJob::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Company/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        InertiaJob::create($request->validate([
            'companyName' => ['required', 'max:100'],
            'WantedTitles' => ['required',],
            'Occupation' => ['required',],
            'companyAddress' => ['required',],
            'companyPay' => ['required',],
            'dutyStation' => ['required',],
            'workDescription' => ['required',],
            'payDescription' => ['required',],
            'travelExpenses' => ['required',],
            'Welfare' => ['required',],
            'startWork' => ['required',],
            'endWork' => ['required',],
            'workDays' => ['required',],
            'freeDays' => ['required',],
            'NearestStation' => ['required',],
            'workOther' => ['nullable'],
        ]));

        return to_route('company.index')->with(['message' => '登録しました。']);
    }

    /**
     * Display the specified resource.
     */
    public function show(InertiaJob $inertiaJob)
    {
        // dd($inertiaJob);
        return Inertia::render('Company/Show', [
            'inertiaJob' => $inertiaJob,
        ]);
    }
    public function view(InertiaJob $inertiaJob)
    {
        // dd($inertiaJob);
        return Inertia::render('JobDetailPage', [
            'inertiaJob' => $inertiaJob,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InertiaJob $inertiaJob)
    {
        return Inertia::render('Company/Edit', [
            'inertiaJob' => $inertiaJob,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InertiaJob $inertiaJob)
    {
        $inertiaJob->update($request->validate([
            'companyName' => ['nullable', 'max:100'],
            'WantedTitles' => ['nullable'],
            'Occupation' => ['nullable'],
            'companyAddress' => ['nullable'],
            'companyPay' => ['nullable'],
            'dutyStation' => ['nullable'],
            'workDescription' => ['nullable'],
            'payDescription' => ['nullable'],
            'travelExpenses' => ['nullable'],
            'Welfare' => ['nullable'],
            'startWork' => ['nullable'],
            'endWork' => ['nullable'],
            'workDays' => ['nullable'],
            'freeDays' => ['nullable'],
            'NearestStation' => ['nullable'],
            'workOther' => ['nullable'],
        ]));
    
        return to_route('company.show')->with(['message' => '更新しました。']);
    }

    public function delete($id)
    {
        $book = InertiaJob::findOrFail($id);
        $book->delete();

        return to_route('company.index')->with(['message' => '削除しました。']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InertiaJob $inertiaJob)
    {
        
    }
}
