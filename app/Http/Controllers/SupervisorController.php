<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\Request;
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

        $newSupervisor = Supervisor::create($supervisorData);

        return redirect()->route('supervisors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supervisor $supervisor)
    {

        return Inertia::render('Supervisors/Show', [
            'supervisor' => $supervisor
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
            ]
        );

        $supervisorData = [
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
        ];

        $supervisor->update($supervisorData);

        return redirect()->route('supervisors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supervisor $supervisor)
    {
        $supervisor->delete();

        return redirect()->route('supervisors.index');
    }
}
