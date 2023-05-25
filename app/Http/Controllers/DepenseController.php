<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\DepenseType;
use Illuminate\Http\Request;
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

        $depensesQuery = Depense::with('depense_type')
            ->where('user_id', $userId);
        // ->when(\Illuminate\Support\Facades\Request::input('search'), function ($query, $search) {
        //     $query->where('type', 'like', '%' . $search . '%');
        // });

        $depenses = $depensesQuery->paginate(5)
            ->appends(\Illuminate\Support\Facades\Request::all());


        return Inertia::render('Depenses/Index', [
            'depenseTypes' => $depenseTypes,
            'depenses' => $depenses,
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
        $validatedData = $request->validate([
            'montant' => 'required',
            'depense_date' => 'required',
            'reference_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'depense_type_id' => 'required|exists:depense_types,id',
        ]);

        $fileToUpload = $request->file('reference_file');

        if ($fileToUpload) {
            $filename = $fileToUpload->store('image', 'public');
            $validatedData['reference_file'] = $filename;
        }

        $validatedData['user_id'] = auth()->id();

        Depense::create($validatedData);

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
    public function update(Request $request, Depense $depense)
    {
        $depense->update(
            $request->validate([
                'montant' => 'required',
                'depense_date' => 'required',
                'reference_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
                'depense_type_id' => 'required|exists:depense_types,id',
            ])
        );

        if ($request->hasFile('reference_file')) {
            $formFields['reference_file']  = $request->file('reference_file')->store('image', 'public');
        }

        return redirect()->back()->with('success', 'Depense updated.');
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
