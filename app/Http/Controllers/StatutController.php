<?php

namespace App\Http\Controllers;

use App\Models\Statut;
use Inertia\Inertia;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;

class StatutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $Status = Statut::where('user_id', $userId)->get();
        return Inertia::render('Status/Index', [
            'status' => Statut::all()
            // ->appends(Request::all()),
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

        $statut = $request->validate([
            'name' => 'required',
        ]);
        Statut::create($statut);
        return redirect()->back()->with('success', 'Statut created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Statut $statut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statut $statut)
    {
        //
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

    public function associatePosteWithAdherent(Request $request, Statut $statut)
    {

        dd($statut);
        $formFields = $request->validate([
            'adherent_id' => 'required|exists:adherent,id',
        ]);

        $statut->update($formFields);

        return redirect()->back()->with('message', 'associate poste with membre is success');
    }
}
