<?php

namespace App\Http\Controllers;


use App\Models\Adherent;
use App\Models\Abonnement;
use App\Models\Reunion;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        $abonnements = Abonnement::with('adherent')->paginate(5);
        $adherents = Adherent::paginate(10);
        $last_reunion = Reunion::orderBy('date', 'desc')->first();
        return Inertia::render('Abonnements/Index', [
            'abonnements' => $abonnements,
            'adherents' => $adherents,
            "last_reunion" => $last_reunion
            // 'filters' => Request::only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Abonnements/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'montant' => 'required',
                'type' => 'required',
                'adherent_id' => 'required|exists:adherents,id'
            ]
        );
        Abonnement::create($formFields);
        return redirect()->back()->with('success', 'Abonnement created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Abonnement $abonnement)
    {
        return Inertia::render('Abonnements/Show', [
            'abonnement' => $abonnement,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Abonnement $abonnement)
    {
        return Inertia::render('Abonnements/Edit', [
            'abonnement' => $abonnement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Abonnement $abonnement)
    {
        $formFields = $request->validated();
        $abonnement->update($formFields);
        return redirect()->back()->with('success', 'Abonnement updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Abonnement $abonnement)
    {
        $abonnement->delete();
        return redirect()->back()->with('success', 'Abonnement deleted.');
    }
}
