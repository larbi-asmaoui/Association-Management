<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Depenses/Index');
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
        $depense = $request->validate([
            'name' => 'required',
        ]);
        $depense['user_id'] = auth()->id();
        Depense::create($depense);
        return redirect()->back()->with('success', 'Depense created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Depense $depense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depense $depense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Depense $depense)
    {
        $depense->update(
            $request->validate([
                'name' => 'required',
            ])
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depense $depense)
    {
        $depense->delete();
        return redirect()->back()->with('success', 'Depense deleted.');
    }
}
