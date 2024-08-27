<?php

namespace App\Http\Controllers;

use App\Models\InertiaJob;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $dutyStation = $request->input('dutyStation');
        $Occupation = $request->input('Occupation');
        $companyPay = $request->input('companyPay');

        // dd($search, $dutyStation, $Occupation, $companyPay);

        $inertiaJobs = InertiaJob::where('status', 1) // 公開中のみ表示
        ->searchInertiaJobs($search, $dutyStation, $Occupation, $companyPay)
        ->paginate(1);
        // dd($inertiaJobs);

        // URLやリクエストパラメータに基づいてビューを切り替える
        if ($request->is('admin/*')) {
            return Inertia::render('Admin/CompanyList', [
                'inertiaJobs' => $inertiaJobs,
            ]);
        }
        
        return Inertia::render('Company/Index', [
            'inertiaJobs' => $inertiaJobs,
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
            'status' => ['nullable',],
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

        return to_route('admin.dashboard')->with(['message' => '登録しました。']);
    }

    /**
     * Display the specified resource.
     */
    public function show(InertiaJob $inertiaJob, Request $request)
    {
        // URLやリクエストパラメータに基づいてビューを切り替える
        if ($request->is('admin/*')) {
            return Inertia::render('Admin/Company', [
                'inertiaJob' => $inertiaJob,
            ]);
        }

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
    public function edit(InertiaJob $inertiaJob, Request $request)
    {
        // URLやリクエストパラメータに基づいてビューを切り替える
        if ($request->is('admin/*')) {
            return Inertia::render('Admin/CompanyEdit', [
                'inertiaJob' => $inertiaJob,
            ]);
        }

        return Inertia::render('Company/Edit', [
            'inertiaJob' => $inertiaJob,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InertiaJob $inertiaJob)
    {
        // dd($request->all());
        
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
            'status' => ['nullable'],
            'image1' => ['nullable', 'image', 'max:5120'],
            'image2' => ['nullable', 'image', 'max:5120'],
            'image3' => ['nullable', 'image', 'max:5120'],
            'image4' => ['nullable', 'image', 'max:5120'],
            'image5' => ['nullable', 'image', 'max:5120'],
        ]);
    
        $images = ['image1', 'image2', 'image3', 'image4', 'image5'];
        $imageDeleted = false; // 画像が削除されたかどうかを追跡するフラグ
        foreach ($images as $image) {
            // 画像が削除フラグされているかチェック
            if ($request->input("imageDeleteFlag.$image") === true) {
                // 古い画像が存在する場合は削除
                if ($inertiaJob->{$image}) {
                    Storage::delete('public/storages/' . $inertiaJob->{$image});
                    if (file_exists(public_path('images/' . $inertiaJob->{$image}))) {
                        unlink(public_path('images/' . $inertiaJob->{$image}));
                    }
                }
                $validatedData[$image] = null;// データベースからも画像パスを削除
                $imageDeleted = true; // 画像が削除されたことを記録

            } elseif ($request->hasFile($image)) {
                // 古い画像が存在する場合は削除
                if ($inertiaJob->{$image}) {
                    Storage::delete('public/storages/' . $inertiaJob->{$image});
                    // 公開ディレクトリからも削除
                    if (file_exists(public_path('images/' . $inertiaJob->{$image}))) {
                        unlink(public_path('images/' . $inertiaJob->{$image}));
                    }
                }

                // 画像の名前を取得ししのまま保存
                $originalName = $request->file($image)->getClientOriginalName();
                // 画像を保存し、パスを取得
                $path = $request->file($image)->storeAs('public/storages', $originalName);
                $request->file($image)->move(public_path('images'), $originalName);
                $validatedData[$image] = basename($path); // データベースに保存するパスを設定
            } else {
                // 現在の画像パスを保持
                $validatedData[$image] = $inertiaJob->{$image};
            }
        }

        $inertiaJob->update($validatedData);

        $message = $imageDeleted ? '画像を削除しました。' : '更新しました。';
        return to_route('admin.company.show', ['inertiaJob' => $inertiaJob->id])->with(['message' => $message]);
    }

    public function delete($id)
    {
        $book = InertiaJob::findOrFail($id);
        $book->delete();

        return to_route('admin.companylist.index')->with(['message' => '削除しました。']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InertiaJob $inertiaJob)
    {
        
    }
}
