<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Evenement;
use App\Models\Rapport;
use App\Models\Reunion;
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
        $startYear = $yearParts[0];
        $endYear = isset($yearParts[1]) ? $yearParts[1] : null;
        $userId = auth()->id();
        $rapports = Rapport::where('user_id', $userId)->get();

        // get the latest reunion where reunion_type is normal



        // $latestReunion = Reunion::where('user_id', $userId)->latest()->first();
        $latestReunion = null;
        $reunionsCount = Reunion::where('user_id', $userId)->count();
        if ($reunionsCount == 0) {
            $evenements = [];
        } else if ($reunionsCount == 1) {
            $latestReunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->first();
            $evenements = Evenement::where('user_id', $userId)
                ->where('end', '<=', $latestReunion->date)
                ->with('evenement_type')
                ->get();
        } else {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->take(2)->get();

            $newestReunion = $reunions->first();
            $previousReunion = $reunions->last();

            $evenements = Evenement::where('user_id', $userId)
                ->where('end', '<=', $newestReunion->date)
                ->where('end', '>=', $previousReunion->date)
                ->with('evenement_type')
                ->get();
        }


        // dd($evenements);
        return Inertia::render('Documents/Index', [
            'evenements' => $evenements,
            'rapports' => $rapports,
            'latestReunion' => $latestReunion,
        ]);

        //         $reunionsCount = Reunion::count();

        // if ($reunionsCount == 1) {
        //     echo 'The table contains exactly one record.';
        // } elseif ($reunionsCount > 1) {
        //     echo 'The table contains more than one record.';
        // } else {
        //     echo 'The table contains no records.';
        // }



    }



    // public function getEvenementsGroupedByType()
    // {
    //     $userId = auth()->id();

    //     $evenements = Evenement::where('user_id', $userId)
    //         ->with('evenement_type')
    //         ->get()
    //         ->groupBy('evenement_type.name')
    //         ->map(function ($groupedEvents) {
    //             return [
    //                 'totalRevenue' => $groupedEvents->sum('revenue'),
    //                 'startDates' => $groupedEvents->pluck('start')
    //             ];
    //         });

    //     return $evenements;
    // }


    // public function generateRapportFinancierPdf()
    // {
    //     // generer rapport financier pdf pour l'association
    //     $userId = auth()->id();
    //     $association = Association::where('user_id', $userId)->get();
    //     $evenements = Evenement::where('user_id', $userId)->with('evenement_type')
    //         ->get();
    //     $data = [
    //         'evenements' => $evenements,
    //         'association' => $association
    //     ];
    //     $pdf = PDF::loadView('documents.rapport_financier', $data);
    //     $filePath = 'rapport_financier.pdf';
    //     Storage::disk('public')->put($filePath, $pdf->output());
    //     // Save the Rapport
    //     Rapport::create([
    //         'file_path' => $filePath,
    //         'title' => 'Rapport financier'
    //     ]);
    //     return response()->streamDownload(function () use ($pdf) {
    //         echo $pdf->output();
    //     }, $filePath, ['Content-Type' => 'application/pdf']);
    // }

    public function  generateRapportLitterairePdf()
    {

        $userId = auth()->id();

        $count = Rapport::where('user_id', $userId)->count();

        if ($count == 0) {
            $newIncrementPart = 1;
        } else {
            $newIncrementPart = $count + 1;
        }

        // Generate the new reference
        $currentYear = date('Y');
        $nextYear = intval($currentYear) + 1;
        $newReference =  "$currentYear-$nextYear-$newIncrementPart";


        // $evenements = Evenement::where('user_id', $userId)->with('evenement_type')
        //     ->get();
        $latestReunion = null;
        $reunionsCount = Reunion::where('user_id', $userId)->count();
        if ($reunionsCount == 0) {
            $evenements = [];
        } else if ($reunionsCount == 1) {
            $latestReunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->first();
            $evenements = Evenement::where('user_id', $userId)
                ->where('start', '<=', $latestReunion->date)
                ->with('evenement_type')
                ->get();
        } else {
            $reunions = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->take(2)->get();

            $newestReunion = $reunions->first();
            $previousReunion = $reunions->last();

            $evenements = Evenement::where('user_id', $userId)
                ->where('start', '<=', $newestReunion->date)
                ->where('start', '>=', $previousReunion->date)
                ->with('evenement_type')
                ->get();
        }
        $association = Association::where('user_id', $userId)->get();

        $data = [
            'evenements' => $evenements,
            'association' => $association
        ];
        $mpdf = new mPDF();
        $view = view('documents.rapport_litteraire', $data);
        $html = $view->render();
        $mpdf->WriteHTML($html);

        $directoryPath = 'documents/rapports/';
        $fileName = 'rapport_litteraire_' . $newReference . '.pdf';
        $filePath = $directoryPath . $fileName;
        Rapport::create([
            'user_id' => $userId,
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
}
