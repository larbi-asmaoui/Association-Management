<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdherentRequest;
use App\Http\Requests\UpdateAdherentRequest;
use App\Models\Abonnement;
use App\Models\Adherent;
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
        $userId = auth()->id();
        $status  = Statut::where('user_id', $userId)->get();

        // $depensesQuery = Depense::with('depense_type')
        //     ->where('user_id', $userId);
        return Inertia::render('Adherents/Index', [
            'status' => $status,
            'all_adherents' => Adherent::all(),
            'adherents' => Adherent::query()
                ->with('statut')
                ->where('user_id', $userId)
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->OrWhere('last_name', 'like', '%' . $search . '%')
                        ->OrWhere('cin', 'like', '%' . $search . '%')
                        ->OrWhere('tel', 'like', '%' . $search . '%')
                        ->OrWhere('email', 'like', '%' . $search . '%');
                })->paginate(10)
                ->appends(Request::all()),
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
                'address' => 'required',
                'city' => 'required',
                'region' => 'required',
                'statut_id' => 'nullable|exists:statuts,id',
            ]
        );
        $formFields['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $formFields['image']  = $request->file('image')->store('image', 'public');
        }

        $adherent = Adherent::create($formFields);
        $adherent->abonnements()->create([
            'user_id' => auth()->id(),
            'adherent_id' => $adherent->id,
            'date_debut' => $adherent->date_of_membership,
            'date_fin' => (new Carbon($adherent->date_of_membership))->addYear(),
            'montant' => $request->montant,
        ]);
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
                'is_actif' => 'nullable',
                'sexe' => 'required',
                'tel' => 'required',
                'date_of_birth' => 'required',
                'date_of_membership' => 'nullable',
                'address' => 'required',
                'city' => 'required',
                'region' => 'required',
                'status_id' => 'nullable',
            ]
        );

        if ($request->hasFile('image')) {
            $formFields['image']  = $request->file('image')->store('image', 'public');
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
}
