<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Adherant;
use App\Models\Cotisation;
use App\Models\Depense;
use App\Models\Evenement;
use App\Models\EvenementType;
use App\Models\Revenue;
use App\Models\Stock;
use App\Models\StockType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function getGroupesData()
    {
        $userId = auth()->id();
        $groupes = Groupe::select('created_at')
            ->where('user_id', $userId)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d-m-y');
            });

        $groupesCount = [];
        foreach ($groupes as $key => $value) {
            $groupesCount[$key] = count($value);
        }

        return $groupesCount;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        $groupes_count = Groupe::where('user_id', $userId)->count();
        $adherants_count = Adherant::where('user_id', $userId)->count();
        $stock_count = Stock::where('user_id', $userId)->count();
        $events_count = Evenement::where('user_id', $userId)
            ->whereDate('end', '>=', Carbon::today())
            ->count();
        $groupesData = $this->getGroupesData();
        $calculateStockTotal = $this->calculateStockTotal();
        // Calculate total montant
        $totalMontant = Cotisation::sum('montant');
        $cotisation_count = Cotisation::all()->count();
        $stocksGroupedByType = $this->getStocksGroupedByType();
        $evenementsGroupedByType = $this->getEvenementsGroupedByType();
        // ------------------------------------------------ //
        $totalCotisationValue = Cotisation::sum('montant');
        $autreDepense = Depense::where('user_id', $userId)->sum('montant') + Stock::where('user_id', $userId)->sum(DB::raw('price_per_unit * quantity'));
        $autreRevenue = Revenue::where('user_id', $userId)->sum('montant');
        $eventsDepense = Evenement::where('user_id', $userId)->sum('depense');
        $eventsRevenue = Evenement::where('user_id', $userId)->sum('revenue');

        return Inertia::render('Dashboard', [
            'groupes_count' => $groupes_count,
            'adherants_count' => $adherants_count,
            'stock_count' => $stock_count,
            'events_count' => $events_count,
            'groupesData' => $groupesData,
            'calculateStockTotal' => $calculateStockTotal,
            'totalMontant' => $totalMontant,
            'cotisation_count' => $cotisation_count,
            'stocksGroupedByType' => $stocksGroupedByType,
            'totalCotisationValue' => $totalCotisationValue,
            'autreDepense' => $autreDepense,
            'autreRevenue' => $autreRevenue,
            'eventsDepense' => $eventsDepense,
            'eventsRevenue' => $eventsRevenue,
            'evenementsGroupedByType' => $evenementsGroupedByType,
        ]);
    }

    public function calculateStockTotal()
    {
        $userId = auth()->id();

        // Get all stocks for the current user
        $stocks = Stock::where('user_id', $userId)->get();

        // Calculate the total
        $total = 0;
        foreach ($stocks as $stock) {
            $total += $stock->quantity * $stock->pricePerUnit;
        }

        return $total;
    }

    public function getStocksGroupedByType()
    {
        $userId = auth()->id();

        $stockTypes = StockType::with('stocks')
            ->where('user_id', $userId)
            ->get();

        $stocksGroupedByType = $stockTypes->mapWithKeys(function ($stockType) {
            return [$stockType->name => $stockType->stocks];
        });

        return $stocksGroupedByType;
    }

    public function getEvenementsGroupedByType()
    {
        $userId = auth()->id();

        $evenementsTypes = EvenementType::with('evenements')
            ->where('user_id', $userId)
            ->get();

        $evenementsGroupedByType = $evenementsTypes->mapWithKeys(function ($evenementType) {
            return [$evenementType->name => $evenementType->evenements];
        });

        return $evenementsGroupedByType;
    }
}
