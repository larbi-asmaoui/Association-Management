<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDepenseRequest;
use App\Models\Depense;
use App\Models\DepenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $userId = auth()->id();
        $depenseTypes = DepenseType::where('user_id', $userId)->get();


        return Inertia::render('Depenses/Index', [
            'depenseTypes' => $depenseTypes,
            'depenses' => Depense::query()
                ->where('user_id', $userId)
                ->with('depense_type')
                ->get()
            // 'filters' => Request::only(['search'])
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
        $depense = $request->validate([
            'titre' => 'required',
            'montant' => 'required',
            'depense_date' => 'required',
            'reference_file' => 'image|mimes:jpg,jpeg,png',
            'depense_type_id' => 'required|exists:depense_types,id',
        ]);

        if ($request->hasFile('reference_file')) {
            $depense['reference_file']  = $request->file('reference_file')->store('uploads/images/depenses', 'public');
        }

        $depense['user_id'] = auth()->id();

        Depense::create($depense);

        return redirect()->back()->with('success', 'Depense created.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Depense $depense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depense $depense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepenseRequest $request, Depense $depense)
    {

        $formData = $request->validate([
            'titre' => 'required',
            'montant' => 'required',
            'depense_date' => 'required',
            'depense_type_id' => 'required|exists:depense_types,id',
        ]);

        if (isset($request->reference_file)) {
            if ($request->file('reference_file')) {
                Storage::disk('public')->delete($depense->reference_file);
                $formData['reference_file']  = $request->file('reference_file')->store('uploads/images/depenses', 'public');
            }
        }
        // dd($request);
        $depense->update($formData);

        return redirect()->back()->with('message', 'Depense updated.')->with('messageType', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depense $depense)
    {
        $depense->delete();
        return redirect()->back()->with('success', 'Depense deleted.');
    }
}
