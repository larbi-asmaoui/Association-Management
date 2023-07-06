<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdherentRequest;
use App\Http\Requests\UpdateAdherentRequest;
use App\Models\Abonnement;
use App\Models\Adherent;
use App\Models\Reunion;
use App\Models\Statut;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;


class AdherentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reunionsCount = Reunion::count();
        if ($reunionsCount > 1) {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->take(2)->get();
            $newestReunion = $reunions->first();
            $previousReunion = $reunions->last();
            $adherents = Adherent::whereDoesntHave('abonnements', function ($query) use ($newestReunion, $previousReunion) {
                $query->whereDate('date_payement', '<=', $previousReunion->date);
                // $query->where('date_payement', '<', $newestReunion->date)
                //     ->where('date_payement', '>', $previousReunion->date);
            })->with('abonnements')->get();
        } else {
            $adherents = Adherent::with('abonnements')->get();
        }
        $status  = Statut::all();
        return Inertia::render('Adherents/Index', [
            'status' => $status,
            'adherents' => $adherents,
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
    public function store(StoreAdherentRequest $request)
    {
        $formFields = $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'sexe' => 'required',
                'cin' => 'required',
                'tel' => 'required',
                'date_of_birth' => 'required',
                'date_of_membership' => 'required',
                'profession' => 'required',
                'situation_familiale' => 'required',
                'address' => 'required',
                'city' => 'required',
                'region' => 'required',
                'statut_id' => 'nullable|exists:statuts,id',
            ]
        );

        if ($request->hasFile('image')) {
            $formFields['image']  = $request->file('image')->store('adherents', 'public');
        } else {
            $formFields['image']  = 'adherents/default_user.png';
        }

        $adherent = Adherent::create($formFields);
        $adherent->abonnements()->create([

            'adherent_id' => $adherent->id,
            'montant' => $request->montant,
        ]);

        $adherent->subscription_expiry = Carbon::parse($adherent->subscription_expiry)->addYear();
        $adherent->save();
        return redirect()->back()->with('success', 'Adherent created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Adherent $adherent)
    {
        return Inertia::render('Adherents/Show', ['adherent' => $adherent]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adherent $adherent)
    {
        return Inertia::render('Adherents/Edit', ['adherent' => $adherent]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdherentRequest $request, Adherent $adherent)
    {
        $formFields = $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'sexe' => 'required',
                'cin' => 'required',
                'tel' => 'required',
                'date_of_birth' => 'required',
                'date_of_membership' => 'required',
                'profession' => 'required',
                'situation_familiale' => 'required',
                'address' => 'required',
                'city' => 'required',
                'region' => 'required',
                'statut_id' => 'nullable|exists:statuts,id',
            ]
        );

        if ($request->hasFile('image')) {
            $formFields['image']  = $request->file('image')->store('adherents', 'public');
        }

        $adherent->update($formFields);
        return redirect()->route('adherents.index')->with('message', 'Adherent updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adherent $adherent)
    {
        $adherent->delete();

        return redirect()->route('adherents.index')->with('message', 'adherent est supprimé avec succès');
    }

    // set is_active to false for all adherents
    public function deactivateAll()
    {
        // do the same in index method but update the is_actif field if the the last abonnement is expired


        $adherents = Adherent::where('is_actif', true)->get();
        foreach ($adherents as $adherent) {
            $abonnement = $adherent->abonnements->last();
            if ($abonnement) {
                if ($abonnement->date_payement < Carbon::now()) {
                    $adherent->is_actif = false;
                    $adherent->save();
                }
            }
        }


        // Adherent::where('is_actif', true)->update(['is_actif' => false]);
        // return redirect()->back()->with('message', 'All adherents are deactivated.');
    }

    // for one adherent
    public function deactivate(Adherent $adherent)
    {
        $adherent->is_actif = false;
        $adherent->save();
        return redirect()->back()->with('message', 'Adherent deactivated.');
    }
}
