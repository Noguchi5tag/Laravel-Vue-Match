<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SkillController extends Controller
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
    public function create(Request $request)
    {
        $userId = Auth::id();
        $user = User::with('skills')->findOrFail($userId);

        // ユーザーがスキルを持っているかどうかを判定
        $hasSkill = $user->skills->isNotEmpty();
        // dd($hasSkill);

        return Inertia::render('Profile/Skill/Create',[
            'user' => $user,
            'hasSkill' => $hasSkill,
        ]);

        // if ($request->path() === 'profile') {
        //     return Inertia::render('Profile/Edit', [
        //         'user' => $user,
        //         'hasSkill' => $hasSkill,
        //     ]);
        // } else {
        //     return Inertia::render('Profile/Skill/Create',[
        //         'user' => $user,
        //     ]);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {
        // dd($request->all());
        $validated = $request->validated();

        Skill::create([
            'skill_name' => $validated['skill_name'],
            'skill_experience' => $validated['skill_experience'],
            'user_id' => $validated['user_id'],
        ]);

        return redirect()->route('profile.edit')->with('success', 'スキルを登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return Inertia::render('Profile/Skill/Update', [
            'skill' => $skill,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        // dd($request->all());
        $validated = $request->validated();
        $skill->update($validated);
        return redirect()->route('profile.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
