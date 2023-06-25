<?php

namespace App\Http\Controllers;

use App\Models\EvenementType;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateEvenementTypeRequest;

class EvenementTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $evenementTypes = EvenementType::all();
        return Inertia::render('EvenementTypes/Index', [
            'evenementTypes' => $evenementTypes
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

        $evenementType = $request->validate([
            'name' => 'required',
        ]);
        EvenementType::create($evenementType);
        return redirect()->back()->with('success', 'EvenementType created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EvenementType $evenementType)
    {
        return Inertia::render('EvenementTypes/Show', [
            'evenementType' => $evenementType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EvenementType $evenementType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvenementTypeRequest $request, EvenementType $evenementType)
    {
        // Ensure the user is authorized to update this EvenementType
        if ($evenementType->user_id != auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $formFields = $request->validate([
            'name' => 'required',
        ]);

        // Update the EvenementType
        $evenementType->update($formFields);

        return redirect()->back()->with('success', 'EvenementType updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EvenementType $evenementType)
    {
        $evenementType->delete();
        return redirect()->back()->with('success', 'evenementType deleted.');
    }
}
