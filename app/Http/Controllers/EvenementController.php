<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvenementRequest;
use App\Http\Requests\UpdateEvenementRequest;
use App\Models\Adherent;
use App\Models\Evenement;
use App\Models\EvenementType;
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
        $lastEvenement = Evenement::latest()->first();
        $evenementTypes = EvenementType::where('user_id', $userId)->get();
        $adherents = Adherent::where('user_id', $userId)->get();

        return Inertia::render('Evenements/Index', [
            'evenements' => $evenements,
            'adherents' => $adherents,
            'lastEvenement' => $lastEvenement,
            'evenementTypes' => $evenementTypes
            // 'filters' => Request::only(['search'])
        ]);
    }
    public function calender()
    {
        $userId = auth()->id();
        $evenements = Evenement::all();
        $adherents = Adherent::where('user_id', $userId)->get();

        return Inertia::render('Evenements/Calender', [
            'evenements' => $evenements,
            'adherents' => $adherents
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
            'description' => 'nullable',
            'location' => 'required',
            'city' => 'required',
            'region' => 'required',
            'evenement_type_id' => 'required|exists:evenement_types,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
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

        $evenementData = [
            'title' => $validatedData['title'],
            'start' => $validatedData['start'],
            'end' => $validatedData['end'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'region' => $validatedData['region'],
            'city' => $validatedData['city'],
            'evenement_type_id' => $validatedData['evenement_type_id'],
            'user_id' => auth()->id(),
            'reference' => $validatedData['reference']

        ];
        // Create the event
        $newEvent = Evenement::create($evenementData);

        if (isset($validatedData['adherents'])) {
            $newEvent->adherents()->sync($validatedData['adherents']);
            // dd($newEvent);
        }
        return redirect()->back()->with('success', 'Event created.');
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
        $evenement->load('adherents');
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
        $evenement->load('adherents');
        $formFields = $request->validate([
            'title' => 'required',
            'start' => 'required',
            'description' => 'nullable',
            'revenue' => 'nullable',
            'depense' => 'nullable',
            'end' => 'required',
            'location' => 'required',
            'city' => 'required',
            'region' => 'required',
            'evenement_type_id' => 'required|exists:evenement_types,id',
            // 'adherants.*' => 'exists:adherants,id',
        ]);

        // $adherents = $formFields['adherents'];
        // unset($formFields['adherents']);

        $evenement->update($formFields);

        // if (isset($adherents)) {
        //     $evenement->adherents()->sync($adherents);
        // }

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
