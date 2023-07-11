<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Reunion;
use App\Models\ReunionType;
use Illuminate\Support\Facades\DB;

class ReunionController extends Controller
{
    // index
    public function index()
    {
        $reunion_types = ReunionType::all();
        $adherents = Adherent::all();
        return Inertia::render('Reunions/Index', [
            'reunionTypes' => $reunion_types,
            'reunions' => Reunion::query()
                ->with('reunion_type')
                ->with('adherents')
                ->orderBy('date', 'desc')
                ->get(),
            'adherents' => $adherents,
        ]);
    }

    public function edit(Reunion $reunion)
    {

        $reunion->load('adherents');
        $adherents = Adherent::all();
        $reunionTypes = ReunionType::all();
        return Inertia::render('Activities/Show', [
            'reunion' => $reunion,
            'reunionTypes' => $reunionTypes,
            'adherents' => $adherents
        ]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'reunion_type_id' => 'required|exists:reunion_types,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
        ]);
        $reunion = Reunion::create($formFields);
        if (isset($validatedData['adherents'])) {
            $reunion->adherents()->sync($validatedData['adherents']);
        }


        return redirect()->back()->with('success', 'reunion created.');
    }

    // update
    public function update(Request $request, Reunion $reunion)
    {
        $reunion->load('adherents');
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'reunion_type_id' => 'required|exists:reunion_types,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
        ]);

        $adherents = $formFields['adherents'];
        unset($formFields['adherents']);

        $reunion->update($formFields);

        if (isset($adherents)) {
            $reunion->adherents()->sync($adherents);
        }
        return redirect()->route('reunions.index')->with('success', 'reunion updated.');
    }

    // destroy
    public function destroy(Reunion $reunion)
    {
        $reunion->delete();
        return redirect()->route('reunions.index')->with('success', 'reunion deleted.');
    }
}
