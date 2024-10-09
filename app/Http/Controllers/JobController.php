<?php

namespace App\Http\Controllers;

use App\Models\InertiaJob;
use App\Models\Manager;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        //検索条件
        $search = $request->input('search');
        $companySearch = $request->input('companySearch');
        $dutyStation = $request->input('dutyStation');
        $Occupation = $request->input('Occupation');
        $companyPay = $request->input('companyPay');

        $user = $request->user();

        if ($request->is('admin/new/companylist')) {
            $inertiaJobs = InertiaJob::where([
                ['is_checked', '=', 0], 
            ])
            ->paginate(3);
            // 新着求人の総数を取得
            $totalNewJobs = InertiaJob::where('is_checked', 0)->count();
            return Inertia::render('Admin/Company/NewCompany', [
                'inertiaJobs' => $inertiaJobs,
                'totalNewJobs' => $totalNewJobs,
            ]);
        } elseif ($request->is('admin/*')) {
            $inertiaJobs = InertiaJob::searchInertiaJobs($search, $companySearch)
            ->orderBy('updated_at', 'desc')
            ->paginate(3);
            $totalJobs = InertiaJob::all()->count();
            return Inertia::render('Admin/CompanyList', [
                'inertiaJobs' => $inertiaJobs,
                'totalJobs' => $totalJobs
            ]);
        } elseif ($request->is('manager/*')) {
            $manager = Auth::user();

            $inertiaJobs = InertiaJob::where('companyName', $manager->name)
            ->searchInertiaJobs($search, $companySearch)
            ->orderBy('updated_at', 'desc')
            ->paginate(3);
            return Inertia::render('Manager/CompanyList', [
                'inertiaJobs' => $inertiaJobs,
            ]);
        } elseif ($request->is('search')) {
            $inertiaJobs = InertiaJob::where([
                ['status', '=', 1],
                ['is_checked', '=', 1], 
            ]) // 公開中のみ表示
            // 応募済みの求人は非表示
            ->whereDoesntHave('applications', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            // ログインしている場合、ブックマークしていない求人のみ表示
            ->when($user, function ($query) use ($user) {
                return $query->whereDoesntHave('bookmarkedByUsers', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->withCount('bookmarkedByUsers')
            ->searchInertiaJobs($search, $companySearch, $dutyStation, $Occupation, $companyPay)
            ->orderBy('updated_at', 'desc')
            ->paginate(3);

            $managers = Manager::all();
            
            return Inertia::render('SearchPage', [
                'inertiaJobs' => $inertiaJobs,
                'managers' => $managers,
            ]);
        } else {
            $inertiaJobs = InertiaJob::where([
                ['status', '=', 1],
                ['is_checked', '=', 1], 
            ]) // 公開中のみ表示
            // 応募済みの求人は非表示
            ->whereDoesntHave('applications', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            // ログインしている場合、ブックマークしていない求人のみ表示
            ->when($user, function ($query) use ($user) {
                return $query->whereDoesntHave('bookmarkedByUsers', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->withCount('bookmarkedByUsers')
            ->orderBy('updated_at', 'desc')
            ->paginate(3);

            // inertiaJobsの中の全てのcompanyNameを取得
            $companyNames = $inertiaJobs->pluck('companyName')->toArray();
            // companyName が inertiaJobs のいずれかに一致する Manager データのみを取得
            $managers = Manager::whereIn('name', $companyNames)->get();
            
            return Inertia::render('Company/Index', [
                'inertiaJobs' => $inertiaJobs,
                'managers' => $managers,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $manager = Auth::user(); // ログイン中のManagerユーザーを取得

        if ($request->is('manager/*')) {
            return Inertia::render('Manager/CompanyCreate', [
                'manager' => $manager,
            ]);
        }
        return Inertia::render('Admin/Company/CompanyCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 検索キーワードを配列に変換
        if ($request->has('search_keywords') && is_string($request->search_keywords)) {
            $request->merge([
                'search_keywords' => explode(',', $request->search_keywords),
            ]);
        }
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
            'search_keywords' => ['nullable','array'],
            'status' => ['nullable',],
            'registrant' => ['nullable'],
            'is_checked' => ['nullable'],
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
                $path = $request->file($image)->storeAs('public/storages/jobs', $originalName);
                $validatedData[$image] = basename($path); // データベースに保存するパスを設定
            }
        }
        
        InertiaJob::create($validatedData);

        if ($request->is('manager/*')) {
            return to_route('manager.dashboard')->with(['message' => '登録しました。']);
        }
        return to_route('admin.dashboard')->with(['message' => '登録しました。']);
    }

    /**
     * Display the specified resource.
     */
    public function show(InertiaJob $inertiaJob, Request $request)
    {
        // URLやリクエストパラメータに基づいてビューを切り替える
        if ($request->is('admin/*')) {
            return Inertia::render('Admin/Company/Company', [
                'inertiaJob' => $inertiaJob,
            ]);
        } elseif ($request->is('manager/*')) {
            return Inertia::render('Manager/Company', [
                'inertiaJob' => $inertiaJob,
            ]);
        } 

        return Inertia::render('Company/Index', [
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
            return Inertia::render('Admin/Company/CompanyEdit', [
                'inertiaJob' => $inertiaJob,
            ]);
        } elseif ($request->is('manager/*')) {
            return Inertia::render('Manager/CompanyEdit', [
                'inertiaJob' => $inertiaJob,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InertiaJob $inertiaJob)
    {
        // dd($request->all());

        // 検索キーワードを配列に変換
        if ($request->has('search_keywords') && is_string($request->search_keywords)) {
            $request->merge([
                'search_keywords' => explode(',', $request->search_keywords),
            ]);
        }
        
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
            'search_keywords' => ['nullable','array'],
            'status' => ['nullable'],
            'is_checked' => ['nullable'],
            'image1' => ['nullable', 'image', 'max:5120'],
            'image2' => ['nullable', 'image', 'max:5120'],
            'image3' => ['nullable', 'image', 'max:5120'],
            'image4' => ['nullable', 'image', 'max:5120'],
            'image5' => ['nullable', 'image', 'max:5120'],
        ]);
        // dd($validatedData);
    
        $images = ['image1', 'image2', 'image3', 'image4', 'image5'];
        $imageDeleted = false; // 画像が削除されたかどうかを追跡するフラグ
        foreach ($images as $image) {
            // 画像が削除フラグされているかチェック
            if ($request->input("imageDeleteFlag.$image") === true) {
                // 古い画像が存在する場合は削除
                if ($inertiaJob->{$image}) {
                    Storage::delete('public/storages/jobs/' . $inertiaJob->{$image});
                }
                $validatedData[$image] = null;// データベースからも画像パスを削除
                $imageDeleted = true; // 画像が削除されたことを記録

            } elseif ($request->hasFile($image)) {
                // 古い画像が存在する場合は削除
                if ($inertiaJob->{$image}) {
                    Storage::delete('public/storages/jobs/' . $inertiaJob->{$image});
                    // 公開ディレクトリからも削除
                    if (file_exists(public_path('images/' . $inertiaJob->{$image}))) {
                        unlink(public_path('images/' . $inertiaJob->{$image}));
                    }
                }

                // 画像の名前を取得ししのまま保存
                $originalName = $request->file($image)->getClientOriginalName();
                // 画像を保存し、パスを取得
                $path = $request->file($image)->storeAs('public/storages/jobs', $originalName);
                $validatedData[$image] = basename($path); // データベースに保存するパスを設定
            } else {
                // 現在の画像パスを保持
                $validatedData[$image] = $inertiaJob->{$image};
            }
        }

        // dd($validatedData);

        $inertiaJob->update($validatedData);

        $message = $imageDeleted ? '画像を削除しました。' : '更新しました。';

        if ($request->is('manager/*')) {
            return to_route('manager.company.show', ['inertiaJob' => $inertiaJob->id])->with(['message' => $message]);
        }
        return to_route('admin.new.companylist.index', ['inertiaJob' => $inertiaJob->id])->with(['message' => $message]);
    }

    public function delete(Request $request, $id)
    {
        $job = InertiaJob::findOrFail($id);
        $job->delete();

        if ($request->is('manager/*')) {
            return to_route('manager.companylist.index')->with(['message' => '削除しました。']);
        }
        return to_route('admin.companylist.index')->with(['message' => '削除しました。']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InertiaJob $inertiaJob)
    {
        
    }
}
