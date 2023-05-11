<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvenementRequest;
use App\Http\Requests\UpdateEvenementRequest;
use App\Models\Evenement;
use App\Models\Groupe;
use Inertia\Inertia;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evenements = Evenement::all();
        $groupes = Groupe::all();
        return Inertia::render('Evenements/Index', [
            'evenements' => $evenements,
            'groupes' => $groupes
            // 'filters' => Request::only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Evenements/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvenementRequest $request)
    {
        $request->validated(
            [
                'title' => 'required',
                'description' => 'required',
                'start' => 'required',
                'end' => 'required',
                'location' => 'required',
            ]
        );
        Evenement::create($request->all());
        return redirect()->back()->with('success', 'Evenement created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evenement $evenement)
    {
        return Inertia::render('Evenements/Show', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evenement $evenement)
    {
        return Inertia::render('Evenements/Edit', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvenementRequest $request, Evenement $evenement)
    {
        $request->validated(
            [
                'title' => 'required',
                'description' => 'required',
                'start' => 'required',
                'end' => 'required',
                'location' => 'required',
            ]
        );
        $evenement->update($request->all());
        return redirect()->back()->with('success', 'Evenement updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evenement $evenement)
    {
        $evenement->delete();
        return redirect()->back()->with('success', 'Evenement deleted.');
    }
}
