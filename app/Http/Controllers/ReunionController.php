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
        return Inertia::render('Reunions/Index', [
            'reunionTypes' => $reunion_types,
            'reunions' => Reunion::query()
                ->with('reunion_type')
                ->orderBy('date', 'desc')
                ->get(),
        ]);
    }

    // store
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'reunion_type_id' => 'required|exists:reunion_types,id',
        ]);
        $reunion = Reunion::create($formFields);
        if (strtolower($reunion->reunion_type->name) === 'normal') {
            Adherent::query()->update([
                'is_actif' => 0
            ]);
        };
        return redirect()->back()->with('success', 'reunion created.');
    }

    // update
    public function update(Request $request, Reunion $reunion)
    {
        $reunion->update($request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'reunion_type_id' => 'required|exists:reunion_types,id',
        ]));
        return redirect()->route('reunions.index')->with('success', 'reunion updated.');
    }

    // destroy
    public function destroy(Reunion $reunion)
    {
        $reunion->delete();
        return redirect()->route('reunions.index')->with('success', 'reunion deleted.');
    }
}
