<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(News $news, Request $request)
    {
        $news = News::orderBy('created_at', 'desc')->get(); //新しく登録した順
        // dd($news);

        // URLやリクエストパラメータに基づいてビューを切り替える
        if ($request->is('admin/*')) {
            return Inertia::render('Admin/News/Index', [
                'news' => $news,
            ]);
        }

        return Inertia::render('NewsPage', [
            'news' => $news,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/News/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $news = new News();
        $news->title = $validatedData['title'];
        $news->content = $validatedData['content'];
        $news->save();

        return to_route('admin.dashboard')->with('success', 'ニュースを作成しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return to_route('admin.newslist.index')->with(['message' => '削除しました。']);
    }
}
