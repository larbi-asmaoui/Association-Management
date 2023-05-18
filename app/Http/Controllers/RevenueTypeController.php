<?php

namespace App\Http\Controllers;

use App\Models\RevenueType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RevenueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('RevenueTypes/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $revenueType = $request->validate([
            'name' => 'required',
        ]);
        $revenueType['user_id'] = auth()->id();
        RevenueType::create($revenueType);
        return redirect()->back()->with('success', 'RevenueType created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RevenueType $revenueType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RevenueType $revenueType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RevenueType $revenueType)
    {
        $revenueType->update(
            $request->validate([
                'name' => 'required',
            ])
        );
        return redirect()->back()->with('success', 'RevenueType updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RevenueType $revenueType)
    {
        $revenueType->delete();
        return redirect()->back()->with('success', 'RevenueType deleted.');
    }
}
