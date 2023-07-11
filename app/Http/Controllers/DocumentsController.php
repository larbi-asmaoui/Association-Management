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
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Mpdf\Mpdf;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $year = $request->get('year');
        $yearParts = explode('/', $year);


        $rapports = Rapport::orderBy('created_at', 'desc')->get();


        $currentYear = date('Y');
        $prevYear = intval($currentYear) - 1;
        $newReference =  "$prevYear-$currentYear";


        $reunionsCount = Reunion::count();
        if ($reunionsCount == 0) {
            return abort(403);
        } else if ($reunionsCount == 1) {
            $latestReunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->first();
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
        } else {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->take(2)->get();

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
        }



        $totalRevenus = $evenements->sum('revenue') + $frais_adhesions + $revenues->sum('montant');
        $totalDepenses = $evenements->sum('depense') + $depenses->sum('montant');
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
        ];
        return Inertia::render('Documents/Index', [
            'rapports' => $rapports,
            'data' => $data,
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
            $evenements = [];
        } else if ($reunionsCount == 1) {
            $latestReunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->first();
            $evenements = Activity::where('start', '<=', $latestReunion->date)
                ->with('activity_type')
                ->get();
        } else {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->take(2)->get();

            $newestReunion = $reunions->first();
            $previousReunion = $reunions->last();

            $evenements = Activity::where('start', '<=', $newestReunion->date)
                ->where('start', '>=', $previousReunion->date)
                ->with('activity_type')
                ->get();
        }
        $association = Association::all();

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
        Rapport::create([
            'file_path' => $filePath,
            'title' => "littéraire-" . $newReference,
        ]);
        // Save the PDF to a file
        Storage::disk('public')->put($filePath, $mpdf->output());
        // Save the Rapport

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->output();
        }, $fileName, ['Content-Type' => 'application/pdf']);
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
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->first();
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
        } else {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->take(2)->get();

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
        }



        $totalRevenus = $evenements->sum('revenue') + $frais_adhesions + $revenues->sum('montant');
        $totalDepenses = $evenements->sum('depense') + $depenses->sum('montant');
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
        ];


        $mpdf = new mPDF();
        $view = view('documents.rapport_financier', $data);
        $html = $view->render();
        $mpdf->WriteHTML($html);

        $directoryPath = 'documents/rapports/';
        $fileName = 'rapport_financier_' . $newReference . '.pdf';
        $filePath = $directoryPath . $fileName;

        Rapport::updateOrCreate([
            'file_path' => $filePath,
            'title' => "financier-" . $newReference,
        ]);
        Storage::disk('public')->put($filePath, $mpdf->output());

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->output();
        }, $fileName, ['Content-Type' => 'application/pdf']);
    }
}
