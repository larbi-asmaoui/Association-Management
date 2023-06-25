<?php

namespace App\Http\Controllers;

use App\Models\ReunionType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReunionTypeController extends Controller
{
    public function index()
    {

        $reunionTypes = ReunionType::all();

        return Inertia::render('ReunionTypes/Index', [
            'reunionTypes' => $reunionTypes
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
        $reunionType = $request->validate([
            'name' => 'required',
        ]);
        ReunionType::create($reunionType);
        return redirect()->back()->with('success', 'reunionType created.');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReunionType $reunionType)
    {
        $reunionType->update(
            $request->validate([
                'name' => 'required',
            ])
        );

        return redirect()->back()->with('success', 'reunionType updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reunionType $reunionType)
    {
        $reunionType->delete();
        return redirect()->back()->with('success', 'reunionType deleted.');
    }
}
