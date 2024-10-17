<?php

namespace App\Http\Controllers;

use App\Models\InertiaJob;
use App\Models\Manager;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());

        $user = $request->user();

        //検索条件
        $companySearch = $request->input('companySearch');
        $Occupation = $request->input('Occupation', []); // 配列として取得
        $dutyStation = $request->input('dutyStation'); // 市町村
        $prefecture = $request->input('prefecture'); // 都道府県
        $search = $request->input('search'); // キーワード検索
        $salaryType = $request->input('salaryType'); // 給与タイプ
        $selectedAmount = $request->input('selectedAmount'); // 選択した金額
        $particulars = $request->input('particulars', []); // 配列として取得
        // dd($Occupation, $dutyStation, $prefecture, $search, $salaryType, $selectedAmount, $particulars);

        if ($request->is('admin/new/companylist')) {
            // 管理者の新着求人の表示 //

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
             // 管理者の求人の表示 //
            
            $inertiaJobs = InertiaJob::searchInertiaJobs($search, $companySearch)
            ->orderBy('updated_at', 'desc')
            ->paginate(3);
            $totalJobs = InertiaJob::all()->count();
            return Inertia::render('Admin/CompanyList', [
                'inertiaJobs' => $inertiaJobs,
                'totalJobs' => $totalJobs
            ]);
        } elseif ($request->is('manager/*')) {
            // マネージャーの求人の表示 //

            $manager = Auth::user();

            $inertiaJobs = InertiaJob::where('companyName', $manager->name)
            ->searchInertiaJobs($search, $companySearch)
            ->orderBy('updated_at', 'desc')
            ->paginate(3);
            return Inertia::render('Manager/CompanyList', [
                'inertiaJobs' => $inertiaJobs,
            ]);
        } elseif ($request->is('search')) {
            // 検索結果の処理 //

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
            ->searchInertiaJobs(
                $companySearch,
                $Occupation, 
                $dutyStation, 
                $prefecture, 
                $search,
                $salaryType, 
                $selectedAmount, 
                $particulars
            )
            ->orderBy('updated_at', 'desc')
            ->paginate(3);

            $managers = Manager::all();
            
            return Inertia::render('SearchPage', [
                'inertiaJobs' => $inertiaJobs,
                'managers' => $managers,
            ]);

        } else {

            // ホームでの表示 //

            // ユーザーのこだわり条件を取得 //
            // ユーザーの `job_requirements` テーブルから条件を取得（例：カンマ区切りの文字列）
            $userRequirements = DB::table('job_requirements')
            ->where('user_id', $user->id)
            ->pluck('job_category')
            ->toArray();
            // dd($userRequirements);

            // カンマ区切りの要素を個々の条件に分解して、全てを配列にまとめる
            $allRequirements = [];
            foreach ($userRequirements as $requirement) {
                // 各要素をカンマで分割し、全体の配列にマージする
                $splitRequirements = array_map('trim', explode(',', $requirement));
                $allRequirements = array_merge($allRequirements, $splitRequirements);
            }
            // ユーザーのこだわり条件 ここまで //

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
            //  ユーザーのこだわり条件に一致する求人データのみを取得
            ->when(!empty($allRequirements), function ($query) use ($allRequirements) {
                $query->where(function ($query) use ($allRequirements) {
                    foreach ($allRequirements as $requirement) {
                        $query->orWhere('Occupation', 'LIKE', '%' . $requirement . '%');
                    }
                });
            })
            // こだわり条件がない場合は全ての求人を更新日時順で表示
            ->when(empty($allRequirements), function ($query) {
                $query->orderBy('updated_at', 'desc');
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

        // dd($request->all());

        // 検索キーワードを配列に変換
        if (!empty($request->input('search_keywords'))) {
            if ($request->has('search_keywords') && is_string($request->input('search_keywords')))  {
                $request->merge([
                    'search_keywords' => explode(',', $request->search_keywords),
                ]);
            }
        }
        
        $request->merge([
            'is_checked' => filter_var($request->input('is_checked'), FILTER_VALIDATE_BOOLEAN),
        ]);

        try {

            $validatedData = $request->validate([
                'companyName' => ['string', 'max:100'], // 会社名
                'WantedTitles' => ['string'],           // 募集タイトル
                'Occupation' => ['string'],             // 職種
                'companyAddress' => ['string'],         // 会社の住所
                'prefecture' => ['string'],             // 勤務地 都道府県
                'dutyStation' => ['string'],            // 勤務地 市町村
                'relocation' => ['in:0,1'],            // 転勤の有無
                'workDescription' => ['string'],        // 仕事内容
                'employment_type' => ['string'], // 雇用形態
                'job_join' => ['string'],               // 入社時期
                'salary_type' => ['string'],            // 月収か年収か
                'salary_amount' => ['integer'],         // 給与
                'travelExpenses' => [ 'nullable', 'integer'],        // 交通費
                'particular_type' => ['nullable', 'string'], // こだわり条件
                'Welfare' => ['nullable', 'string'],                // 福利厚生
                'startWork' => ['date_format:H:i'],     // 勤務開始時間
                'endWork' => ['date_format:H:i'],       // 勤務終了時間
                'workDays' => ['string'],               // 出勤日
                'freeDays' => ['string'],               // 休日
                'NearestStation' => ['string'],         // 最寄り駅
                'workOther' => ['nullable', 'string'],              // その他
                'search_keywords' => ['nullable', 'array'],         // 検索キーワード
                'status' => ['nullable', 'integer'],                // ステータス
                'registrant' => ['nullable', 'string'],             // 登録者名
                'is_checked' => ['nullable', 'boolean'],            // 確認フラグ
                'image1' => ['image', 'max:5120'],      // 画像1
                'image2' => ['nullable', 'image', 'max:5120'],      // 画像2
                'image3' => ['nullable', 'image', 'max:5120'],      // 画像3
                'image4' => ['nullable', 'image', 'max:5120'],      // 画像4
                'image5' => ['nullable', 'image', 'max:5120'],      // 画像5
            ], [
                'image1.max' => '画像ファイルのサイズは5MB以下にしてください。',
                'image2.max' => '画像ファイルのサイズは5MB以下にしてください。',
                'image3.max' => '画像ファイルのサイズは5MB以下にしてください。',
                'image4.max' => '画像ファイルのサイズは5MB以下にしてください。',
                'image5.max' => '画像ファイルのサイズは5MB以下にしてください。',
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

        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
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

        if ($request->has('search_keywords') && is_string($request->search_keywords)) {
            $request->merge([
                'search_keywords' => explode(',', $request->search_keywords),
            ]);
        }
        $request->merge([
            'is_checked' => filter_var($request->input('is_checked'), FILTER_VALIDATE_BOOLEAN),
        ]);

        try {

            $validatedData = $request->validate([
                'companyName' => ['nullable', 'string', 'max:100'], // 会社名
                'WantedTitles' => ['nullable', 'string'],           // 募集タイトル
                'Occupation' => ['nullable', 'string'],             // 職種
                'companyAddress' => ['nullable', 'string'],         // 会社の住所
                'prefecture' => ['nullable', 'string'],             // 勤務地 都道府県
                'dutyStation' => ['nullable', 'string'],            // 勤務地 市町村
                'relocation' => ['nullable', 'in:0,1'],            // 転勤の有無
                'workDescription' => ['nullable', 'string'],        // 仕事内容
                'employment_type' => ['nullable', 'string'], // 雇用形態
                'job_join' => ['nullable', 'string'],               // 入社時期
                'salary_type' => ['nullable', 'string'],            // 月収か年収か
                'salary_amount' => ['nullable', 'integer'],         // 給与
                'travelExpenses' => ['nullable', 'integer'],        // 交通費
                'particular_type' => ['nullable', 'string'], // こだわり条件
                'Welfare' => ['nullable', 'string'],                // 福利厚生
                'startWork' => ['nullable'],     // 勤務開始時間
                'endWork' => ['nullable'],       // 勤務終了時間
                'workDays' => ['nullable', 'string'],               // 出勤日
                'freeDays' => ['nullable', 'string'],               // 休日
                'NearestStation' => ['nullable', 'string'],         // 最寄り駅
                'workOther' => ['nullable', 'string'],              // その他
                'search_keywords' => ['nullable', 'array'],         // 検索キーワード
                'status' => ['nullable', 'integer'],                // ステータス
                'registrant' => ['nullable', 'string'],             // 登録者名
                'is_checked' => ['nullable', 'boolean'],            // 確認フラグ
                'image1' => ['nullable', 'image', 'max:5120'],      // 画像1
                'image2' => ['nullable', 'image', 'max:5120'],      // 画像2
                'image3' => ['nullable', 'image', 'max:5120'],      // 画像3
                'image4' => ['nullable', 'image', 'max:5120'],      // 画像4
                'image5' => ['nullable', 'image', 'max:5120'],      // 画像5
            ], [
                'image1.max' => '画像ファイルのサイズは5MB以下にしてください。',
                'image2.max' => '画像ファイルのサイズは5MB以下にしてください。',
                'image3.max' => '画像ファイルのサイズは5MB以下にしてください。',
                'image4.max' => '画像ファイルのサイズは5MB以下にしてください。',
                'image5.max' => '画像ファイルのサイズは5MB以下にしてください。',
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

        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
        
        
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
