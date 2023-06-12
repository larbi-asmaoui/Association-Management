<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Adherent;
use App\Models\Cotisation;
use App\Models\Depense;
use App\Models\Evenement;
use App\Models\EvenementType;
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

        $userId = auth()->id();

        $groupes_count = Groupe::where('user_id', $userId)->count();
        $adherents_count = Adherent::where('user_id', $userId)->count();
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

        $autreDepenseQuery = Depense::where('user_id', $userId);
        $stockQuery = Stock::where('user_id', $userId);

        if ($startYear !== null) {
            $autreDepenseQuery = $autreDepenseQuery->whereYear('created_at', '>=', $startYear);
            $stockQuery = $stockQuery->whereYear('created_at', '>=', $startYear);
        }

        if ($endYear !== null) {
            $autreDepenseQuery = $autreDepenseQuery->whereYear('created_at', '<', $endYear);
            $stockQuery = $stockQuery->whereYear('created_at', '<', $endYear);
        }

        $autreDepense = $autreDepenseQuery->sum('montant')
            + $stockQuery->sum(DB::raw('price_per_unit * quantity'));

        $autreRevenue = Revenue::where('user_id', $userId)->sum('montant');
        $eventsDepense = Evenement::where('user_id', $userId)->sum('depense');
        $eventsRevenue = Evenement::where('user_id', $userId)->sum('revenue');

        // Group Depense by Month for the selected year
        $depenseGroupedByMonth = Depense::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(montant) as total'))
            ->where('user_id', $userId)
            ->whereYear('created_at', '>=', $startYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month')
            ->toArray();

        // Group Revenue by Month for the selected year
        $revenueGroupedByMonth = Revenue::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(montant) as total'))
            ->where('user_id', $userId)
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
}
