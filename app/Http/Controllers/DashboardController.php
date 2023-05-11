<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Adherant;
use App\Models\Stock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        $groupes_count = Groupe::where('user_id', $userId)->count();
        $adherants_count = Adherant::where('user_id', $userId)->count();
        $stock_count = Stock::where('user_id', $userId)->count();


        return Inertia::render('Dashboard', [
            'groupes_count' => $groupes_count,
            'adherants_count' => $adherants_count,
            'stock_count' => $stock_count,
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
    // public function show(User $user)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, User $user)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(User $user)
    // {
    //     //
    // }
}
