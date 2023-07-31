<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\Classe;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adherents = Adherent::all();
        // $classes = Classe::query()
        //     ->with('adherents')
        //     ->withCount('adherents')
        //     ->get();
        $classes = Classe::query()
            ->with('adherents')
            ->withCount('adherents')
            ->with('supervisor')
            ->get();
        $supervisors = Supervisor::all();
        return Inertia::render(
            'Classes/Index',
            [
                'adherents' => $adherents,
                'classes' => $classes,
                'supervisors' => $supervisors,
            ]
        );
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
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'supervisor_id' => 'required|exists:supervisors,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
        ]);

        $classeData = [
            'name' => $formFields['name'],
            'description' => $formFields['description'],
            'supervisor_id' => $formFields['supervisor_id'],
        ];

        $classe = Classe::create($classeData);
        if (isset($formFields['adherents'])) {
            // $adherentIds = $request->input('adherents');
            Adherent::whereIn('id', $formFields['adherents'])->update(['classe_id' => $classe->id]);
        }


        return redirect()->back()->with('success', 'reunion created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classe $classe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classe $classe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classe $classe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classe $classe)
    {
        $classe->delete();
        return  redirect()->route('classes.index')->with('message', 'classe est supprimé avec succès');
    }
}
