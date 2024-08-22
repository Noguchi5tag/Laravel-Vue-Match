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
            'image2' => ['nullable', 'image', 'max:5120'],
            'image3' => ['nullable', 'image', 'max:5120'],
            'image4' => ['nullable', 'image', 'max:5120'],
            'image5' => ['nullable', 'image', 'max:5120'],
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
            // デバッグ用に全ての入力データを取得
            $inputData = $request->all();
            $fileData = [
                'image1' => $request->file('image1'),
                'image2' => $request->file('image2'),
                'image3' => $request->file('image3'),
                'image4' => $request->file('image4'),
                'image5' => $request->file('image5'),
            ];

            // デバッグ出力
            dd([
                'inputData' => $inputData,
                'fileData' => $fileData,
            ]);
            
        try {
            $validatedData = $request->validate([
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
                'image4' => ['nullable', 'image'],
                'image1' => ['nullable', 'image'],
                'image2' => ['nullable', 'image'],
                'image3' => ['nullable', 'image'],
                'image5' => ['nullable', 'image'],
            ],[
                'image1.max' => '画像ファイルのサイズは5MB以下にしてください。',
            ]);
        
            $images = ['image1', 'image2', 'image3', 'image4', 'image5'];
            foreach ($images as $image) {
                if ($request->hasFile($image)) {
                    $originalName = $request->file($image)->getClientOriginalName();
                    //画像を保存し、パスを取得
                    $path = $request->file($image)->storeAs('public/storages', $originalName);
                    $request->file($image)->move(public_path('images'), $originalName);
                    $validatedData[$image] = basename($path); // データベースに保存するパスを設定
                }
            }
    
            $inertiaJob->update($validatedData);
        
            // return to_route('company.show')->with(['message' => '更新しました。']);
            return response()->json(['message' => '更新しました。']); //デバック用

        } catch (\Exception $e) {
            return response()->json(['message' => 'エラーが発生しました。'], 500);
        }
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
