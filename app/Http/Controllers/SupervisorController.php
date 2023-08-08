<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Classe;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Supervisors/Index', [
            'supervisors' => Supervisor::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Supervisors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'cin' => 'required',
                'address' => 'required',
                'date_of_birth' => 'required',
                'tel' => 'required',
            ]
        );

        if ($request->hasFile('image')) {
            $formFields['image']  = $request->file('image')->store('supervisors', 'public');
        }


        $newSupervisor = Supervisor::create($formFields);

        return redirect()->route('supervisors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supervisor $supervisor)
    {
        $supervisor = Supervisor::with(['classes.category', 'classes.adherents'])
            ->where('id', $supervisor->id)
            ->first();



        return Inertia::render('Supervisors/Show', [
            'supervisor' => $supervisor,
            'categories' => Category::with('classes')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supervisor $supervisor)
    {
        return Inertia::render('Supervisors/Edit', [
            'supervisor' => $supervisor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supervisor $supervisor)
    {

        $validatedData = $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'cin' => 'required',
                'address' => 'required',
                'date_of_birth' => 'required',
                'tel' => 'required',
            ]
        );

        $supervisorData = [
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'cin' => $validatedData['cin'],
            'address' => $validatedData['address'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'tel' => $validatedData['tel'],
        ];

        $supervisor->update($supervisorData);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supervisor $supervisor)
    {
        $supervisor->delete();

        return redirect()->route('supervisors.index');
    }

    // update only image
    public function updateImage(Request $request, $id)
    {

        if (!$request->hasFile('image')) {
            return;
        }

        $supervisor = Supervisor::find($id);
        $validatedData = $request->validate(
            [
                'image' => 'required',
            ]
        );
        if ($supervisor->image) {
            Storage::disk('public')->delete($supervisor->image);
        }

        // Store the new image
        $formFields['image'] = $request->file('image')->store('supervisors', 'public');

        $supervisor->update($formFields);

        return redirect()->back();
    }

    public function detachClasse(Supervisor $supervisor, $classeId)
    {
        // dd($classeId);
        $supervisor->classes()->detach($classeId);

        return redirect()->back();
    }

    public function attachClasse(Request $request, Supervisor $supervisor)
    {
        $data = $request->validate([
            'classes' => 'required|array',
            'classes.*' => 'exists:classes,id',
        ]);

        $supervisor->classes()->attach($data['classes']);
        return redirect()->back();
    }
}
