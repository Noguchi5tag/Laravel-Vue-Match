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
        $validatedData = $request->validate([
            'companyName' => ['nullable', 'max:100'],
            'WantedTitles' => ['nullable',],
            'Occupation' => ['nullable',],
            'companyAddress' => ['nullable',],
            'companyPay' => ['nullable',],
            'dutyStation' => ['nullable',],
            'workDescription' => ['nullable',],
            'payDescription' => ['nullable',],
            'travelExpenses' => ['nullable',],
            'Welfare' => ['nullable',],
            'startWork' => ['nullable',],
            'endWork' => ['nullable',],
            'workDays' => ['nullable',],
            'freeDays' => ['nullable',],
            'NearestStation' => ['nullable',],
            'workOther' => ['nullable',],
            'image1' => ['nullable', 'image', 'max:5120'],
        ],[
            'image1.max' => '画像ファイルのサイズは5MB以下にしてください。',
        ]);

        $images = ['image1', 'image2', 'image3', 'image4', 'image5'];
        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                $originalName = $request->file($image)->getClientOriginalName();
                $path = $request->file($image)->storeAs('public/storages', $originalName);
                $request->file($image)->move(public_path('images'), $originalName);
                $validatedData[$image] = basename($path); // データベースに保存するパスを設定
            }
        }
        
        InertiaJob::create($validatedData);

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
