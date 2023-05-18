<?php

namespace App\Http\Controllers;

use App\Models\CotisationType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CotisationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('CotisationTypes/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),
            'cotisationTypes' => CotisationType::orderBy('name')
                ->filter(\Illuminate\Support\Facades\Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(fn ($cotisationType) => [
                    'id' => $cotisationType->id,
                    'name' => $cotisationType->name,
                    'deleted_at' => $cotisationType->deleted_at,
                ]),
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
        $cotisationType = $request->validate([
            'name' => 'required',
        ]);
        $cotisationType['user_id'] = auth()->id();
        CotisationType::create($cotisationType);
        return redirect()->back()->with('success', 'CotisationType created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CotisationType $cotisationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotisationType $cotisationType)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CotisationType $cotisationType)
    {
        $cotisationType->update(
            $request->validate([
                'name' => 'required',
            ])
        );
        return redirect()->back()->with('success', 'CotisationType updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotisationType $cotisationType)
    {
        $cotisationType->delete();
        return redirect()->back()->with('success', 'CotisationType deleted.');
    }
}
