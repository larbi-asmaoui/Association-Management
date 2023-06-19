<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Stock;
use App\Models\StockType;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\Debugbar\Facades\Debugbar;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        $stockTypes = StockType::where('user_id', $userId)->get();

        return Inertia::render('Stocks/Index', [
            'stockTypes' => $stockTypes,
            'stocks' => Stock::query()
                ->with('stock_type')
                ->get()
            // 'filters' => Request::only(['search'])
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Stocks/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $stock = $request->validate([
            'name' => 'required',
            'purchase_date' => 'required',
            'quantity' => 'required',
            'price_per_unit' => 'required',
            'stock_type_id' => 'required|exists:stock_types,id'
        ]);

        // $stock = $request->all()

        $stock['user_id'] = auth()->id();

        Stock::create($stock);


        return redirect()->back()->with('message', 'stock est crée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return Inertia::render('Stocks/Show', [
            'stock' => $stock,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        return Inertia::render('Stocks/Edit', [
            'stock' => $stock,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'name' => 'required',
            'purchase_date' => 'required',
            'quantity' => 'required',
            'price_per_unit' => 'required',
            'stock_type_id' => 'required|exists:stock_types,id'
        ]);
        $stock->update($request->all());

        return redirect()->back()->with('message', 'stock est modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('message', 'stock est supprimé avec succès');
    }
}
