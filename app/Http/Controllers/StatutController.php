<?php

namespace App\Http\Controllers;

use App\Models\Statut;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatutController extends Controller
{
    public function index()
    {

        $statuts = Statut::with('adherent')->get();

        return Inertia::render('Status/Index', [
            'statuts' => $statuts
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
        //
        $statut = $request->validate([
            'name' => 'required',
        ]);
        Statut::create($statut);
        return redirect()->back()->with('success', 'Statut created.');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statut $statut)
    {
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

    public function associatePosteWithAdherent(Request $request)
    {
        $formFields = $request->validate([
            'adherent_id' => 'nullable|exists:adherents,id',
        ]);

        $statut = Statut::find($request->id);

        $statut->update($formFields);


        return redirect()->back()->with('message', 'associate poste with membre is success');
    }
}
