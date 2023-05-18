<?php

namespace App\Http\Controllers;

use App\Models\DepenseType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('DepenseTypes/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),
            'depenseTypes' => DepenseType::orderBy('name')
                ->filter(\Illuminate\Support\Facades\Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(fn ($depenseType) => [
                    'id' => $depenseType->id,
                    'name' => $depenseType->name,
                    'deleted_at' => $depenseType->deleted_at,
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
        //
        $depenseType = $request->validate([
            'name' => 'required',
        ]);
        $depenseType['user_id'] = auth()->id();
        DepenseType::create($depenseType);
        return redirect()->back()->with('success', 'DepenseType created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DepenseType $depenseType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepenseType $depenseType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepenseType $depenseType)
    {
        $depenseType->update(
            $request->validate([
                'name' => 'required',
            ])
        );

        return redirect()->back()->with('success', 'DepenseType updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepenseType $depenseType)
    {
        $depenseType->delete();
        return redirect()->back()->with('success', 'DepenseType deleted.');
    }
}
