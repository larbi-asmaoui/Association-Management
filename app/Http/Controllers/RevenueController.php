<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRevenueRequest;
use App\Models\Revenue;
use App\Models\RevenueType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $revenueTypes = RevenueType::all();


        return Inertia::render('Revenues/Index', [
            'revenueTypes' => $revenueTypes,
            'revenues' => Revenue::query()
                ->with('revenue_type')
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
        $revenue = $request->validate([
            'titre' => 'required',
            'montant' => 'required',
            'revenue_date' => 'required',
            'revenue_type_id' => 'nullable|exists:revenue_types,id',
        ]);
        if ($request->hasFile('reference_file')) {
            $revenue['reference_file']  = $request->file('reference_file')->store('uploads/images/revenues', 'public');
        }

        revenue::create($revenue);
        return redirect()->back()->with('success', 'Revenue created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Revenue $revenue)
    {

        $formFields = $request->validate([
            'titre' => 'required',
            'montant' => 'required',
            'revenue_date' => 'required',
            'revenue_type_id' => 'nullable|exists:revenue_types,id',
        ]);

        if ($request->hasFile('reference_file')) {
            Storage::disk('public')->delete($revenue->reference_file);
            $formFields['reference_file']  = $request->file('reference_file')->store('uploads/images/revenues', 'public');
        }


        $revenue->update($formFields);
        return redirect()->back()->with('success', 'Revenue updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revenue $revenue)
    {
        $revenue->delete();
        return redirect()->back()->with('success', 'Revenue deleted.');
    }
}
