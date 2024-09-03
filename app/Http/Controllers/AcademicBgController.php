<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcademic_BgRequest;
use App\Http\Requests\UpdateAcademic_BgRequest;
use App\Models\Academic_Bg;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

class AcademicBgController extends Controller
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
    public function create()
    {
        $userId = Auth::id();
        $user = User::with('academic_bg')->findOrFail($userId);

        return Inertia::render('Profile/Academic/Create',[
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademic_BgRequest $request)
    {
        // dd($request->all());
        $validated = $request->validated();

        Academic_Bg::create([
            'user_id' => $validated['user_id'],
            'school_classification' => $validated['school_classification'],
            'school_name' => $validated['school_name'],
            'department' => $validated['department'],
            'matriculation' => $validated['matriculation'],
            'graduation' => $validated['graduation'],
            'undergraduate' => $validated['undergraduate'],
        ]);

        // dd($validated);

        return redirect()->route('profile.edit')->with('success', '学歴を登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Academic_Bg $academic_Bg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Academic_Bg $academic_Bg)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademic_BgRequest $request, Academic_Bg $academic_Bg)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Academic_Bg $academic_Bg)
    {
        //
    }
}
