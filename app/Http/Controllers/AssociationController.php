<?php

namespace App\Http\Controllers;

use App\Models\Association;
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

        $association = Association::where('user_id', auth()->id())->first();
        return Inertia::render('Association/Index', [
            'association' => $association
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
    // public function store(Request $request)
    // {


    //     $association = Association::first();
    //     dd($association);
    //     if (!$association) {
    //         Validator::make($request->all(), [
    //             'name' => 'nullable',
    //             'objectifs' => 'nullable',
    //             'address' => 'nullable',
    //             'region' => 'nullable',
    //             'city' => 'nullable',

    //         ])->validate();

    //         Association::create($request->all() + ['user_id' => auth()->id()]);

    //         $this->processImage($request);

    //         return redirect()->back()
    //             ->with('message', 'Association created');
    //     } else {
    //         $association->update($request->only(['title', 'author']));

    //         $this->processImage($request, $association);

    //         return redirect()->back()
    //             ->with('message', 'Association updated');
    //     }
    // }

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
