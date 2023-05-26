<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvenementRequest;
use App\Http\Requests\UpdateEvenementRequest;
use App\Models\Evenement;
use App\Models\EvenementType;
use App\Models\Groupe;
use Inertia\Inertia;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        $evenements = Evenement::paginate(10);
        $groupes = Groupe::all();
        $lastEvenement = Evenement::latest()->first();
        $evenementTypes = EvenementType::where('user_id', $userId)->get();

        return Inertia::render('Evenements/Index', [
            'evenements' => $evenements,
            'groupes' => $groupes,
            'lastEvenement' => $lastEvenement,
            'evenementTypes' => $evenementTypes
            // 'filters' => Request::only(['search'])
        ]);
    }
    public function calender()
    {
        $userId = auth()->id();
        $evenements = Evenement::all();
        $groupes = Groupe::all();

        return Inertia::render('Evenements/Calender', [
            'evenements' => $evenements,
            'groupes' => $groupes
            // 'filters' => Request::only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Evenements/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvenementRequest $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'start' => 'required',
            'end' => 'required',
            'location' => 'required',
            'city' => 'required',
            'region' => 'required',
            'evenement_type_id' => 'required|exists:evenement_types,id',
        ]);

        // Fetch the last created event's reference number
        $lastEvenement = Evenement::latest()->first();

        if ($lastEvenement) {
            // Extract the increment part and increment it
            // $lastIncrementPart = intval(explode('-', $lastEvenement->reference)[1]);
            $lastIncrementPart = $lastEvenement ? substr($lastEvenement->reference, -3) : 0;
            $newIncrementPart = str_pad((int)$lastIncrementPart + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // If there is no event yet, start the increment part from 1
            $newIncrementPart = 1;
        }

        // Generate the new reference
        $currentYear = date('Y');
        $nextYear = intval($currentYear) + 1;
        $newReference = "$currentYear/$nextYear-$newIncrementPart";

        // Add the reference to the data
        $validatedData['reference'] = $newReference;
        $validatedData['user_id'] = auth()->id();
        // Create the event
        Evenement::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Evenement $evenement)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evenement $evenement)
    {
        $userId = auth()->id();
        $evenementTypes = EvenementType::where('user_id', $userId)->get();
        return Inertia::render('Evenements/Show', [
            'evenement' => $evenement,
            'evenementTypes' => $evenementTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(UpdateEvenementRequest $request, Evenement $evenement)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'start' => 'required',
            'end' => 'required',
            'location' => 'required',
            'city' => 'required',
            'region' => 'required',
            'evenement_type_id' => 'required|exists:evenement_types,id',
        ]);

        $evenement->update($formFields);

        return redirect()->back()->with('success', 'Evenement updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evenement $evenement)
    {
        $evenement->delete();
        return redirect()->back()->with('success', 'Evenement deleted.');
    }
}
