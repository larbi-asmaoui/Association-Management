<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Revenues/Index');
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

        $revenue = $request->validate([
            'name' => 'required',
        ]);
        $revenue['user_id'] = auth()->id();
        Revenue::create($revenue);
        return redirect()->back()->with('success', 'Revenue created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Revenue $revenue)
    {
        $revenue->update(
            $request->validate([
                'name' => 'required',
            ])
        );

        return redirect()->back()->with('success', 'Revenue updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revenue $revenue)
    {
        $revenue->delete();

        return redirect()->back()->with('success', 'Revenue deleted.');
    }
}
