<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Adherant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupes_count = Groupe::count();
        $adherants_count = Adherant::count();

        return Inertia::render('Dashboard', [
            'groupes_count'=>$groupes_count,
            'adherants_count'=>$adherants_count,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
