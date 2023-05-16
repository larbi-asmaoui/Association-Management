<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCotisationRequest;
use App\Http\Requests\UpdateCotisationRequest;
use App\Models\Adherant;
use App\Models\Cotisation;
use Inertia\Inertia;

class CotisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        $cotisations = Cotisation::with('adherant')->get();
        $adherants = Adherant::all();

        return Inertia::render('Cotisations/Index', [
            'cotisations' => $cotisations,
            'adherants' => $adherants
            // 'filters' => Request::only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cotisations/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCotisationRequest $request)
    {
        $formFields = $request->validate(
            [
                'montant' => 'required',
                'type' => 'required',
                'adherant_id' => 'required|exists:adherants,id'
            ]
        );
        Cotisation::create($formFields);
        return redirect()->back()->with('success', 'Cotisation created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cotisation $cotisation)
    {
        return Inertia::render('Cotisations/Show', [
            'cotisation' => $cotisation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cotisation $cotisation)
    {
        return Inertia::render('Cotisations/Edit', [
            'cotisation' => $cotisation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCotisationRequest $request, Cotisation $cotisation)
    {
        $formFields = $request->validated();
        $cotisation->update($formFields);
        return redirect()->back()->with('success', 'Cotisation updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cotisation $cotisation)
    {
        $cotisation->delete();
        return redirect()->back()->with('success', 'Cotisation deleted.');
    }
}
