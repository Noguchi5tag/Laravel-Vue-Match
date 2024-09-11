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
        $job = InertiaJob::findOrFail($jobId);

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
}
