<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Reunion;

class ReunionController extends Controller
{
    // index
    public function index()
    {
        $reunions = Reunion::all();
        return Inertia::render('Reunions/Index', [
            'reunions' => $reunions
        ]);
    }

    // store
    public function store(Request $request)
    {
        $reunion = $request->validate([
            'reference' => 'required',
            'date' => 'required',
            'reunion_type_id' => 'required|exists:reunion_types,id',
        ]);
        $reunion['user_id'] = auth()->id();
        Reunion::create($reunion);
        return redirect()->back()->with('success', 'reunion created.');
    }

    // update
    public function update(Request $request, Reunion $reunion)
    {
        $reunion->update($request->validate([
            'reference' => 'required',
            'date' => 'required',
            'reunion_type_id' => 'required|exists:reunion_types,id',
        ]));
        return redirect()->back()->with('success', 'reunion updated.');
    }

    // destroy
    public function destroy(Reunion $reunion)
    {
        $reunion->delete();
        return redirect()->back()->with('success', 'reunion deleted.');
    }
}
