<?php

namespace App\Http\Controllers;

use App\Models\Statut;
use Inertia\Inertia;

use Illuminate\Support\Facades\Request;

class StatutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //  ->withCount('adherants')
        $userId = auth()->id();
        // $Status = Statut::where('user_id', $userId)->get();
        return Inertia::render('Status/Index', [
            'status' => Statut::query()
                ->with('adherants')
                ->withCount('adherants')
                ->where('user_id', $userId)
                ->get()
            // ->appends(Request::all()),
        ]);
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

        $statut = $request->validate([
            'name' => 'required',
        ]);
        $statut['user_id'] = auth()->id();
        Statut::create($statut);
        return redirect()->back()->with('success', 'Statut created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Statut $statut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statut $statut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statut $statut)
    {
        $statut->load('adherants');
        $statut->update(
            $request->validate([
                'name' => 'required',
            ])
        );
        return redirect()->back()->with('success', 'Statut updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statut $statut)
    {
        $statut->delete();
        return redirect()->back()->with('success', 'Statut deleted.');
    }
}
