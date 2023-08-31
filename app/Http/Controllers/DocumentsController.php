<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Activity;
use App\Models\Association;
use App\Models\Depense;
use App\Models\Evenement;
use App\Models\Rapport;
use App\Models\Reunion;
use App\Models\Revenue;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Mpdf\Mpdf;
use PDF;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $rapports = Rapport::orderBy('id', 'desc')->get();
        return Inertia::render('Documents/Index', [
            'rapports' => $rapports,
        ]);
    }


    public function  generateRapportLitterairePdf()
    {



        $count = Rapport::count();
        if ($count == 0) {
            $newIncrementPart = 1;
        } else {
            $newIncrementPart = $count + 1;
        }

        // Generate the new reference
        $currentYear = date('Y');
        $prevYear = intval($currentYear) - 1;
        $newReference =  "$prevYear-$currentYear";

        $latestReunion = null;
        $reunionsCount = Reunion::count();
        if ($reunionsCount == 0) {
            // $evenements = [];
            return abort(403);
        } else if ($reunionsCount == 1) {
            $latestReunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('id', '1');
            })->orderBy('date', 'desc')->first();

            if ($latestReunion == null) {
                // $evenements = [];
                return abort(403);
            }

            $evenements = Activity::where('start', '<=', $latestReunion->date)
                ->with('activity_type')
                ->get();
        } else {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('id', '1');
            })->orderBy('date', 'desc')->take(2)->get();

            $newestReunion = $reunions->first();
            $previousReunion = $reunions->last();

            $evenements = Activity::where('start', '<=', $newestReunion->date)
                ->where('start', '>=', $previousReunion->date)
                ->with('activity_type')
                ->get();
        }
        $association = Association::first();

        $data = [
            'evenements' => $evenements,
            'association' => $association,
            'season'   => $newReference,
        ];


        $mpdf = new mPDF();
        $view = view('documents.rapport_litteraire', $data);
        $html = $view->render();
        $mpdf->WriteHTML($html);

        $directoryPath = 'documents/rapports/';
        $fileName = 'rapport_litteraire_' . $newReference . '.pdf';
        $filePath = $directoryPath . $fileName;

        // Create the directory if it doesn't exist
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        // Create the file if it doesn't exist
        if (!file_exists($filePath)) {
            touch($filePath);
        }

        $rapport = Rapport::updateOrCreate([
            'file_path' => $filePath,
            'title' => "litteraire-" . $newReference,
        ]);

        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
        return response()->json(['success' => true, 'message' => 'PDF generated successfully.']);
    }

    public function generateRapportFinancierPdf()
    {

        $currentYear = date('Y');
        $prevYear = intval($currentYear) - 1;
        $newReference =  "$prevYear-$currentYear";


        $reunionsCount = Reunion::count();
        if ($reunionsCount == 0) {
            return abort(403);
        } else if ($reunionsCount == 1) {
            $latestReunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('id', '1');
            })->orderBy('date', 'desc')->first();

            if ($latestReunion == null) {
                return abort(404);
            }
            $evenements = Activity::where('start', '<=', $latestReunion->date)
                ->with('activity_type')
                ->get();
            $depenses = Depense::where('depense_date', '<=', $latestReunion->date)
                ->get();
            // ->sum('montant');
            $revenues = Revenue::where('revenue_date', '<=', $latestReunion->date)
                ->get();
            $frais_adhesions = Abonnement::where('date_payement', '<=', $latestReunion->date)
                ->sum('montant');

            $stockValue = Stock::where('purchase_date', '<=', $latestReunion->date)
                ->select(DB::raw('SUM(quantity * price_per_unit) as total_value'))
                ->first();
        } else {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('id', '1');
            })->orderBy('date', 'desc')->take(2)->get();

            if ($reunions->count() < 2) {
                return abort(404);
            }

            $newestReunion = $reunions->first();
            $previousReunion = $reunions->last();

            $evenements = Activity::where('start', '<=', $newestReunion->date)
                ->where('start', '>=', $previousReunion->date)
                ->with('activity_type')
                ->get();
            $depenses = Depense::where('depense_date', '<=', $newestReunion->date)
                ->where('depense_date', '>=', $previousReunion->date)
                ->get();

            $revenues = Revenue::where('revenue_date', '<=', $newestReunion->date)
                ->where('revenue_date', '>=', $previousReunion->date)
                ->get();
            $frais_adhesions = Abonnement::where('date_payement', '<=', $newestReunion->date)
                ->where('date_payement', '>=', $previousReunion->date)
                ->sum('montant');

            $stockValue = Stock::where('purchase_date', '<=', $newestReunion->date)
                ->where('purchase_date', '>=', $previousReunion->date)
                ->select(DB::raw('SUM(quantity * price_per_unit) as total_value'))
                ->first();
        }

        $totalStock = $stockValue->total_value ?? 0;
        $totalRevenus = $evenements->sum('revenue') + $frais_adhesions + $revenues->sum('montant');
        $totalDepenses = $evenements->sum('depense') + $depenses->sum('montant') + $totalStock;
        // dd($totalRevenus);
        $data = [
            'frais_adhesions' => $frais_adhesions,
            'revenues' => $revenues,
            'depenses' => $depenses,
            'evenements' => $evenements,
            'association' => Association::all(),
            'totalRevenus' => $totalRevenus,
            'totalDepenses' => $totalDepenses,
            'season' => $newReference,
            'totalStock' => $totalStock,
        ];

        $mpdf = new mPDF();
        $view = view('documents.rapport_financier', $data);
        $html = $view->render();
        $mpdf->WriteHTML($html);

        $directoryPath = 'documents/rapports/';
        $fileName = 'rapport_financier_' . $newReference . '.pdf';
        $filePath = $directoryPath . $fileName;

        // Create the directory if it doesn't exist
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        // Create the file if it doesn't exist
        if (!file_exists($filePath)) {
            touch($filePath);
        }

        $rapport = Rapport::updateOrCreate([
            'file_path' => $filePath,
            'title' => "financier-" . $newReference,
        ]);

        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        return response()->json(['success' => true, 'message' => 'PDF generated successfully.']);
    }
}
