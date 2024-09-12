<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InertiaJob;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class BookmarkController extends Controller
{
    public function store($jobId, Request $request)
    {
        $user = $request->user();

        // 既にブックマークされているか確認
        if (!$user->bookmarks()->where('inertia_job_id', $jobId)->exists()) {
            $user->bookmarks()->attach($jobId);
            return to_route('company.index')->with(['message' => 'ブックマークしました。']);
        }

        return response()->json(['message' => '既に保存されています'], 400);
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $bookmarkedJobs = $user->bookmarks()->get();

        return Inertia::render('BookmarkPage', [
            'bookmarkedJobs' => $bookmarkedJobs,
        ]);
    }

    public function destroy($jobId, Request $request)
    {
        $user = $request->user();

        // ブックマークが存在するか確認して削除
        if ($user->bookmarks()->where('inertia_job_id', $jobId)->exists()) {
            $user->bookmarks()->detach($jobId); // ブックマークの解除
            return to_route('bookmarked.jobs')->with(['message' => 'ブックマークを取り消しました']);
        }

        return response()->json(['message' => 'ブックマークが存在しません'], 400);
    }
}
