<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupeRequest;
use App\Http\Requests\UpdateGroupeRequest;
use App\Models\Adherant;
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
        $userId = auth()->id();
        $adherants = Adherant::where('user_id', $userId)->get();
        return Inertia::render('Groupes/Index', [
            // 'groupes' => $groupes,
            'adherants' => $adherants,
            'groupes' => Groupe::query()
                ->with('adherants')
                ->withCount('adherants')
                ->where('user_id', $userId)
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->OrWhere('description', 'like', '%' . $search . '%');
                })->paginate(5)
                ->appends(Request::all()),
            // 'filters' => Request::only(['search'])
        ]);
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
                'adherants' => 'nullable|array',
                'adherants.*' => 'exists:adherants,id',
            ]
        );

        $groupeData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'user_id' => auth()->id(),
        ];

        $newGroupe = Groupe::create($groupeData);

        if (isset($validatedData['adherants'])) {
            $newGroupe->adherants()->sync($validatedData['adherants']);
        }

        return redirect()->back()->with('success', 'Groupe created.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Groupe $groupe)
    {
        $groupe->load('adherants');
        return Inertia::render('Groupes/Show', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Groupe $groupe)
    {
        $groupe->load('adherants');
        return Inertia::render('Groupes/Edit', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupeRequest $request, Groupe $groupe)
    {
        $groupe->load('adherants');
        $formFields = $request->validate(
            [
                'name' => 'required',
                'description' => 'nullable',
                'adherants' => 'nullable|array',
                'adherants.*' => 'exists:adherants,id',
            ]
        );

        $adherants = $formFields['adherants']; // Save adherants
        unset($formFields['adherants']); // Remove adherants from form fields

        $groupe->update($formFields);

        if (isset($adherants)) {
            $groupe->adherants()->sync($adherants);
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
