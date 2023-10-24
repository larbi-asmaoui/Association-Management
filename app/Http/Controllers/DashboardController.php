<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Activity;
use App\Models\Groupe;
use App\Models\Adherent;
use App\Models\Depense;
use App\Models\ActivityType;
use App\Models\Association;
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
        $startYear = $request->get('year') ?? Carbon::now()->year;

        $groupes_count = Groupe::count();
        $adherents_count = Adherent::count();
        $stock_count = Stock::count();

        $events_count = Activity::whereDate('end', '>=', Carbon::today())
            ->count();

        $groupesData = $this->getGroupesData();
        $calculateStockTotal = $this->calculateStockTotal();


        $cotisation_count = Abonnement::all()->count();
        $stocksGroupedByType = $this->getStocksGroupedByType();
        $evenementsGroupedByType = $this->getEvenementsGroupedByType($startYear);

        // ------------------------------------------------ //
        $totalAbonnementsSum = Abonnement::whereBetween('created_at', [$startYear . '-01-01', $startYear . '-12-31'])
            ->sum('montant');


        $autreDepenseQuery = Depense::whereBetween('depense_date', [$startYear . '-01-01', $startYear . '-12-31']);
        $stockQuery = Stock::whereBetween('purchase_date', [$startYear . '-01-01', $startYear . '-12-31']);



        $autreDepense = $autreDepenseQuery->sum('montant')
            + $stockQuery->sum(DB::raw('price_per_unit * quantity'));

        $autreRevenue = Revenue::whereBetween('revenue_date', [$startYear . '-01-01', $startYear . '-12-31'])->sum('montant');
        $activityDepenses = Activity::whereBetween('start', [$startYear . '-01-01', $startYear . '-12-31'])
            ->sum('depense');
        $activityRevenue = Activity::whereBetween('start', [$startYear . '-01-01', $startYear . '-12-31'])->sum('revenue');

        $depenseGroupedByMonth = DB::table(DB::raw("(
            SELECT depense_date as date, montant
            FROM depenses
            WHERE depense_date BETWEEN '{$startYear}-01-01' AND '{$startYear}-12-31'
            UNION ALL
            SELECT start as date, depense as montant
            FROM activities
            WHERE start BETWEEN '{$startYear}-01-01' AND '{$startYear}-12-31'
            UNION ALL
            SELECT purchase_date as date, (price_per_unit * quantity) as montant
            FROM stocks
            WHERE purchase_date BETWEEN '{$startYear}-01-01' AND '{$startYear}-12-31'
            ) AS combined"))
            ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(montant) as total'))
            ->groupBy(DB::raw('MONTH(date)'))
            ->pluck('total', 'month')
            ->toArray();

        for ($i = 1; $i <= 12; $i++) {
            if (!isset($depenseGroupedByMonth[$i])) {
                $depenseGroupedByMonth[$i] = 0;
            }
        }

        // dd($depenseGroupedByMonth);


        $revenueGroupedByMonth = DB::table(DB::raw("(
            SELECT revenue_date as date, montant
            FROM revenues
            WHERE revenue_date BETWEEN '{$startYear}-01-01' AND '{$startYear}-12-31'
            UNION ALL
            SELECT start as date, revenue as montant
            FROM activities
            WHERE start BETWEEN '{$startYear}-01-01' AND '{$startYear}-12-31'
            UNION ALL
            SELECT created_at as date, montant
            FROM abonnements
            WHERE created_at BETWEEN '{$startYear}-01-01' AND '{$startYear}-12-31'
        ) AS combined"))
            ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(montant) as total'))
            ->groupBy(DB::raw('MONTH(date)'))
            ->pluck('total', 'month')
            ->toArray();


        for ($i = 1; $i <= 12; $i++) {
            if (!isset($revenueGroupedByMonth[$i])) {
                $revenueGroupedByMonth[$i] = 0;
            }
        }

        return Inertia::render('Dashboard', [
            'groupes_count' => $groupes_count,
            'adherents_count' => $adherents_count,
            'stock_count' => $stock_count,
            'events_count' => $events_count,
            'groupesData' => $groupesData,
            'calculateStockTotal' => $calculateStockTotal,
            'cotisation_count' => $cotisation_count,
            'stocksGroupedByType' => $stocksGroupedByType,
            'totalAbonnementsSum' => $totalAbonnementsSum,
            'autreDepense' => $autreDepense,
            'autreRevenue' => $autreRevenue,
            'activityDepenses' => $activityDepenses,
            'activityRevenue' => $activityRevenue,
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

    public function getEvenementsGroupedByType($input_year = null)
    {
        $year = $input_year ?? Carbon::now()->year;
        // get evenements types and their evenements length in the current year and group them by type
        $evenementsTypes = ActivityType::with(['activities' => function ($query) use ($year) {

            $query->whereBetween('start', [$year . '-01-01', $year . '-12-31']);
        }])
            ->get();


        $evenementsGroupedByType = $evenementsTypes->mapWithKeys(function ($evenementType) {
            return [$evenementType->name => $evenementType->activities];
        });

        return $evenementsGroupedByType;
    }

    public function getYearsList()
    {

        $association = Association::first();
        $startYear = $association && isset($association->date_creation) ? Carbon::parse($association->date_creation)->year : Carbon::now()->year;
        $currentYear = Carbon::now()->year;
        $yearsList = [];

        for ($year = $startYear; $year <= $currentYear; $year++) {
            array_push($yearsList, $year);
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
