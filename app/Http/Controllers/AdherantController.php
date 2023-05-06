<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdherantRequest;
use App\Http\Requests\UpdateAdherantRequest;
use App\Models\Adherant;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class AdherantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Adherants/Index', [
            'adherants' => Adherant::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->OrWhere('last_name', 'like', '%' . $search . '%')
                        ->OrWhere('cin', 'like', '%' . $search . '%')
                        ->OrWhere('tel', 'like', '%' . $search . '%')
                        ->OrWhere('email', 'like', '%' . $search . '%');
                })->paginate(10)
                ->appends(Request::all()),
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
    public function store(StoreAdherantRequest $request)
    {
        $request->validated(
            [
                'image' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'cin' => 'required',
                'tel' => 'required',
                'sexe' => 'required',
                'date_of_birth' => 'required',
                'address' => 'required',
            ]
        );
        Adherant::create($request->all());
        return redirect()->back()->with('success', 'Adherant created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Adherant $adherant)
    {
        return Inertia::render('Adherants/Show', ['adherant' => $adherant]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adherant $adherant)
    {
        return Inertia::render('Adherants/Edit', ['adherant' => $adherant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdherantRequest $request, Adherant $adherant)
    {
        $request->validated(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'cin' => 'required',
                'tel' => 'required',
                'sexe' => 'required',
                'date_of_birth' => 'required',
                'address' => 'required',
            ]
        );
        $adherant->update($request->all());
        return redirect()->route('adherants.index')->with('success', 'Adherant updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adherant $adherant)
    {
        $adherant->delete();

        return redirect()->route('adherants.index')->with('message', 'adherant est supprimé avec succès');
    }
}
