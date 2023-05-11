<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Adherant;
use App\Models\Evenement;
use App\Models\Stock;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function getGroupesData()
    {
        $userId = auth()->id();
        $groupes = Groupe::select('created_at')
            ->where('user_id', $userId)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
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
        $events_count = Evenement::all()->count();
        $groupesData = $this->getGroupesData();

        return Inertia::render('Dashboard', [
            'groupes_count' => $groupes_count,
            'adherants_count' => $adherants_count,
            'stock_count' => $stock_count,
            'events_count' => $events_count,
            'groupesData' => $groupesData, // Pass groupesData to Inertia
        ]);
    }
}
