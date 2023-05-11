<?php

namespace App\Http\Controllers;

use App\Models\Stock;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        return Inertia::render('Stocks/Index', [
            'stocks' => Stock::query()
                ->where('user_id', $userId)
                ->when(\Illuminate\Support\Facades\Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->OrWhere('type', 'like', '%' . $search . '%');
                })->paginate(5)
                ->appends(\Illuminate\Support\Facades\Request::all()),
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
            'type' => 'required',
            'purchaseDate' => 'required',
            'quantity' => 'required',
            'pricePerUnit' => 'required',
        ]);

        // $stock = $request->all()

        $stock['user_id'] = auth()->id();

        Stock::create($stock);

        return redirect()->route('stocks.index')->with('message', 'stock est crée avec succès');
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
        $stock->update($request->all());

        return redirect()->route('stocks.index')->with('message', 'stock est modifié avec succès');
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
