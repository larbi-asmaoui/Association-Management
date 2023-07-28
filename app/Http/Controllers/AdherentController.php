<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdherentRequest;
use App\Http\Requests\UpdateAdherentRequest;
use App\Models\Abonnement;
use App\Models\Adherent;
use App\Models\Reunion;
use App\Models\Statut;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

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
            $adherents = DB::table('adherents')
                ->whereExists(function ($query) use ($previousReunion) {
                    $query->select(DB::raw(1))
                        ->from('abonnements')
                        ->whereRaw('adherents.id = abonnements.adherent_id')
                        ->where('date_payement', '>=', $previousReunion->date);
                })
                ->join('abonnements', 'adherents.id', '=', 'abonnements.adherent_id')
                ->with('statut')
                ->get();
        } else {
            $adherents = Adherent::with('abonnements')->with('statut')->get();
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
                'cin' => 'nullable',
                'tel' => 'required',
                'date_of_birth' => 'required',
                'date_of_membership' => 'required',
                'profession' => 'required',
                'situation_familiale' => 'required',
                'address' => 'required',
                'city' => 'required',
                'region' => 'required',
                'statut_id' => 'nullable|exists:statuts,id',
                'email' => 'nullable|email',
            ]
        );

        if ($request->hasFile('image')) {
            $formFields['image']  = $request->file('image')->store('adherents', 'public');
        } else {
            $formFields['image']  = 'adherents/default_user.jpg';
        }

        $num_adhesion = $this->generateNumAdhesion();

        $formFields['num_adhesion'] = $num_adhesion;
        $adherent = Adherent::create($formFields);
        $adherent->abonnements()->create([

            'adherent_id' => $adherent->id,
            'montant' => $request->montant,
        ]);

        $adherent->subscription_expiry = Carbon::parse($adherent->subscription_expiry)->addYear();
        // $adherent->num_adhesion = $this->generateNumAdhesion();
        $adherent->save();
        return redirect()->back()->with('success', 'Adherent created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Adherent $adherent)
    {

        $adherent = Adherent::with('abonnements', 'activities')->find($adherent->id);
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
        $formFields = $request->only([
            'first_name',
            'last_name',
            'sexe',
            'cin',
            'tel',
            'date_of_birth',
            'date_of_membership',
            'profession',
            'situation_familiale',
            'address',
            'city',
            'region',
            'email'
        ]);


        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($adherent->image);

            $formFields['image']  = $request->file('image')->store('adherents', 'public');
        }

        $adherent->update($formFields);
        return redirect()->back()->with('message', 'Adherent updated.');
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

        $reunionsCount = Reunion::count();
        if ($reunionsCount == 0) {
            return;
        }

        // check passed successfully
        if ($reunionsCount == 1) {
            $reunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('id', '1');
            })->orderBy('date', 'desc')->first();
            $adherents = DB::table('adherents')
                ->whereExists(function ($query) use ($reunion) {
                    $query->select(DB::raw(1))
                        ->from('abonnements')
                        ->whereRaw('adherents.id = abonnements.adherent_id')
                        ->whereDate('date_payement', '<', $reunion->date);
                })
                ->orderBy('adherents.id')
                ->join('abonnements', 'adherents.id', '=', 'abonnements.adherent_id')
                ->each(function ($adherent) {
                    DB::table('adherents')->where('id', $adherent->id)->update(['is_actif' => false]);
                });

            return redirect()->back()->with('message', 'All adherents are deactivated.');
        } else {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('id', '1');
            })->orderBy('date', 'desc')->take(2)->get();
            $newestReunion = $reunions->first();
            $previousReunion = $reunions->last();

            $adherents = DB::table('adherents')
                ->whereExists(function ($query) use ($newestReunion, $previousReunion) {
                    $query->select(DB::raw(1))
                        ->from('abonnements')
                        ->whereRaw('adherents.id = abonnements.adherent_id')
                        ->whereBetween('date_payement', [$previousReunion->date, $newestReunion->date]);
                })
                ->orderBy('adherents.id')
                ->join('abonnements', 'adherents.id', '=', 'abonnements.adherent_id')
                ->each(function ($adherent) {
                    DB::table('adherents')->where('id', $adherent->id)->update(['is_actif' => false]);
                });

            return redirect()->back()->with('message', 'All adherents are deactivated.');
        }
    }

    // for one adherent
    public function deactivate(Adherent $adherent)
    {
        $adherent->is_actif = false;
        $adherent->save();
        return redirect()->back()->with('message', 'Adherent deactivated.');
    }

    public function generateNumAdhesion()
    {
        $prefix = 'ASSO-';
        $num_adhesion = $prefix . rand(100000, 999999);

        // Check if the generated ID already exists in the database
        $existing_num_adhesion = DB::table('adherents')->where('num_adhesion', $num_adhesion)->exists();

        if ($existing_num_adhesion) {
            // If the ID already exists, generate a new one recursively
            return $this->generateId();
        }

        return $num_adhesion;
    }
}
