<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupeRequest;
use App\Http\Requests\UpdateGroupeRequest;
use App\Models\Adherent;
use Illuminate\Support\Facades\Request;
use App\Models\Groupe;
use Inertia\Inertia;

class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adherents = Adherent::all();
        return Inertia::render('Groupes/Index', [
            // 'groupes' => $groupes,
            'adherents' => $adherents,
            'groupes' => Groupe::query()
                ->with('adherents')
                ->withCount('adherents')
                ->get()
            // 'filters' => Request::only(['search'])
        ],);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Groupes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupeRequest $request)
    {

        $validatedData = $request->validate(
            [
                'name' => 'required',
                'description' => 'nullable',
                'adherents' => 'nullable|array',
                'adherents.*' => 'exists:adherents,id',
            ]
        );

        $groupeData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],

        ];

        $newGroupe = Groupe::create($groupeData);

        if (isset($validatedData['adherents'])) {
            $newGroupe->adherents()->sync($validatedData['adherents']);
        }

        return redirect()->back()->with('success', 'Groupe created.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Groupe $groupe)
    {
        $groupe->load('adherents');
        return Inertia::render('Groupes/Show', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Groupe $groupe)
    {
        $groupe->load('adherents');
        return Inertia::render('Groupes/Edit', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupeRequest $request, Groupe $groupe)
    {
        $groupe->load('adherents');
        $formFields = $request->validate(
            [
                'name' => 'required',
                'description' => 'nullable',
                'adherents' => 'nullable|array',
                'adherents.*' => 'exists:adherents,id',
            ]
        );

        $adherents = $formFields['adherents']; // Save adherents
        unset($formFields['adherents']); // Remove adherents from form fields

        $groupe->update($formFields);

        if (isset($adherents)) {
            $groupe->adherents()->sync($adherents);
        }

        return redirect()->route('groupes.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Groupe $groupe)
    {
        $groupe->delete();

        return redirect()->route('groupes.index')->with('message', 'Groupe est supprimé avec succès');
    }
}
