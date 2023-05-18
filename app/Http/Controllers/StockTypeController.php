<?php

namespace App\Http\Controllers;

use App\Models\StockType;
use Inertia\Inertia;
use Illuminate\Http\Request;

class StockTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        return Inertia::render('StockTypes/Index', [
            'stockTypes' => StockType::query()
                ->where('user_id', $userId)
                ->when(\Illuminate\Support\Facades\Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })->paginate(5)
                ->appends(\Illuminate\Support\Facades\Request::all()),
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
