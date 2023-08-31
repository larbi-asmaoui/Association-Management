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

    public function show(Reunion $reunion)
    {

        $reunion = Reunion::query()
            ->with('reunion_type')
            ->with('adherents')
            ->where('id', $reunion->id)
            ->first();


        // $reunion->load('adherents');
        // $adherents = Adherent::where('is_actif', true)->get();
        $adherents = Adherent::all();
        $reunionTypes = ReunionType::all();
        return Inertia::render('Reunions/Show', [
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
            'reunion_type_id' => 'nullable|exists:reunion_types,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
        ]);

        $reunionData = [
            'name' => $formFields['name'],
            'description' => $formFields['description'],
            'date' => $formFields['date'],
            'reunion_type_id' => $formFields['reunion_type_id'],
        ];

        $reunion = Reunion::create($reunionData);
        if (isset($formFields['adherents'])) {
            $reunion->adherents()->sync($formFields['adherents']);
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
            'reunion_type_id' => 'nullable|exists:reunion_types,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
        ]);

        $adherents = $formFields['adherents'];
        unset($formFields['adherents']);

        $reunion->update($formFields);

        if (isset($adherents)) {
            $reunion->adherents()->sync($adherents);
        }
        return redirect()->back()->with('success', 'reunion updated.');
    }

    // destroy
    public function destroy(Reunion $reunion)
    {
        $reunion->delete();
        return redirect()->route('reunions.index')->with('success', 'reunion deleted.');
    }
}
