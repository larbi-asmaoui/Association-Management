<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\Association;
use App\Models\Statut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $association = Association::first() ?? new Association();
        return Inertia::render('Association/Index', [
            'association' => $association,

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



        $formData = $request->validate([
            'name' => 'nullable',
            'objectifs' => 'nullable',
            'date_creation' => 'nullable',
            'address' => 'nullable',
            'region' => 'nullable',
            'city' => 'nullable'
        ]);
        if (isset($request->image)) {
            if ($request->file('image')) {
                // Storage::disk('public')->delete($association->image);
                $formData['image']  = $request->file('image')->store('uploads/logos', 'public');
            }
        }

        $association = Association::first();

        if (!$association) {
            Association::create($formData);
            return redirect()->back()
                ->with('message', 'Association created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Association $association)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Association $association)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Association $association)
    {
        $formData = $request->validate([
            'name' => 'nullable',
            'objectifs' => 'nullable',
            'date_creation' => 'nullable',
            'address' => 'nullable',
            'region' => 'nullable',
            'city' => 'nullable'
        ]);
        if (isset($request->image)) {
            if ($request->file('image')) {
                // Storage::disk('public')->delete($association->image);
                $formData['image']  = $request->file('image')->store('uploads/logos', 'public');
            }
        }
        // dd($formData);
        $association->update($formData);
        return redirect()->back()
            ->with('message', 'association updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Association $association)
    {
        //
    }
}
