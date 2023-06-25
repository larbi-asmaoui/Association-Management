<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Groupe;
use App\Models\Adherent;
use App\Models\Cotisation;
use App\Models\Depense;
use App\Models\ActivityType;
use App\Models\Revenue;
use App\Models\Stock;
use App\Models\StockType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{



    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $year = $request->get('year');
        $yearParts = explode('/', $year);
        $startYear = $yearParts[0];
        $endYear = isset($yearParts[1]) ? $yearParts[1] : null;



        $groupes_count = Groupe::count();
        $adherents_count = Adherent::count();
        $stock_count = Stock::count();

        $events_count = Activity::whereDate('end', '>=', Carbon::today())
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

        // $autreDepenseQuery = Depense::all();
        // $stockQuery = Stock::all();

        if ($startYear !== null) {
            $autreDepenseQuery = Depense::whereYear('created_at', '>=', $startYear);
            $stockQuery = Stock::whereYear('created_at', '>=', $startYear);
        }

        if ($endYear !== null) {
            $autreDepenseQuery = Depense::whereYear('created_at', '<', $endYear);
            $stockQuery = Stock::whereYear('created_at', '<', $endYear);
        }

        $autreDepense = $autreDepenseQuery->sum('montant')
            + $stockQuery->sum(DB::raw('price_per_unit * quantity'));

        $autreRevenue = Revenue::all()->sum('montant');
        $eventsDepense = Activity::all()->sum('depense');
        $eventsRevenue = Activity::all()->sum('revenue');

        // Group Depense by Month for the selected year
        $depenseGroupedByMonth = Depense::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(montant) as total'))
            ->whereYear('created_at', '>=', $startYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month')
            ->toArray();

        // Group Revenue by Month for the selected year
        $revenueGroupedByMonth = Revenue::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(montant) as total'))
            ->whereYear('created_at', '>=', $startYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month')
            ->toArray();

        return Inertia::render('Dashboard', [
            'groupes_count' => $groupes_count,
            'adherents_count' => $adherents_count,
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
            'yearsList' => $this->getYearsList(),
            'depenseGroupedByMonth' => $depenseGroupedByMonth,
            'revenueGroupedByMonth' => $revenueGroupedByMonth,
        ]);
    }

    public function calculateStockTotal()
    {


        // Get all stocks for the current user
        $stocks = Stock::all();

        // Calculate the total
        $total = 0;
        foreach ($stocks as $stock) {
            $total += $stock->quantity * $stock->pricePerUnit;
        }

        return $total;
    }

    public function getStocksGroupedByType()
    {


        $stockTypes = StockType::with('stocks')
            ->get();

        $stocksGroupedByType = $stockTypes->mapWithKeys(function ($stockType) {
            return [$stockType->name => $stockType->stocks];
        });

        return $stocksGroupedByType;
    }

    public function getEvenementsGroupedByType()
    {


        $evenementsTypes = ActivityType::with('activities')
            ->get();

        $evenementsGroupedByType = $evenementsTypes->mapWithKeys(function ($evenementType) {
            return [$evenementType->name => $evenementType->evenements];
        });

        return $evenementsGroupedByType;
    }

    public function getYearsList()
    {
        $userId = auth()->id();
        $user = User::find($userId);

        $startYear = $user->created_at->year;
        $currentYear = Carbon::now()->year;

        $yearsList = [];

        for ($year = $startYear; $year <= $currentYear; $year++) {
            $yearsList[] = $year . '/' . ($year + 1);
        }

        return $yearsList;
    }

    public function getGroupesData()
    {
        $groupes = Groupe::select('created_at')
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
}
