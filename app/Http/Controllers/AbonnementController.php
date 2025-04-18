<?php

namespace App\Http\Controllers;


use App\Models\Adherent;
use App\Models\Abonnement;
use App\Models\Association;
use App\Models\Reunion;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $abonnements = Abonnement::with('adherent')->get();
        $adherents = Adherent::all();
        $associaton = Association::first() ?? null;
        $last_reunion = Reunion::orderBy('date', 'desc')->first();
        return Inertia::render('Abonnements/Index', [
            'abonnements' => $abonnements,
            'adherents' => $adherents,
            "last_reunion" => $last_reunion,
            "associaton" => $associaton,
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

        // dd($request->all());
        $formFields = $request->validate(
            [
                'montant' => 'required',
                'adherent_id' => 'required|exists:adherents,id',
            ]
        );
        Abonnement::create([
            'montant' => $formFields['montant'],
            'adherent_id' => $formFields['adherent_id'],
            'date_payement' => Carbon::now(),
        ]);

        $adherent = Adherent::find($formFields['adherent_id']);
        $last_reunion = Reunion::orderBy('date', 'desc')->first();
        if ($last_reunion && $last_reunion->reunion_type->id == '1') {
            $adherent->subscription_expiry = Carbon::parse($last_reunion->date)->addYear();
        } else {
            $adherent->subscription_expiry = Carbon::now()->addYear();
        }
        $adherent->is_actif = 1;
        $adherent->save();

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
