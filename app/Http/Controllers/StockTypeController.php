<?php

namespace App\Http\Controllers;

use App\Models\StockType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('StockTypes/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),
            'stockTypes' => StockType::orderBy('name')
                ->filter(\Illuminate\Support\Facades\Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(fn ($stockType) => [
                    'id' => $stockType->id,
                    'name' => $stockType->name,
                    'deleted_at' => $stockType->deleted_at,
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

        $stockType = $request->validate([
            'name' => 'required',
        ]);
        $stockType['user_id'] = auth()->id();
        StockType::create($stockType);
        return redirect()->back()->with('success', 'StockType created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockType $stockType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockType $stockType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockType $stockType)
    {
        $stockType->update(
            $request->validate([
                'name' => 'required',
            ])
        );

        return redirect()->back()->with('success', 'StockType updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockType $stockType)
    {
        $stockType->delete();

        return redirect()->back()->with('success', 'StockType deleted.');
    }
}
