<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Evenement;
use App\Models\EvenementType;
use App\Models\Rapport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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

        $evenements = Evenement::where('user_id', $userId)->with('evenement_type')
            ->get();
        return Inertia::render('Documents/Index', [
            'evenements' => $evenements,
        ]);
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

    // generate rapport litteraire pdf
    public function generateRapportLitterairePdf()
    {
        // $year = $request->get('year');
        // $yearParts = explode('/', $year);
        // $startYear = $yearParts[0];
        // $endYear = isset($yearParts[1]) ? $yearParts[1] : null;
        // $lastRapport = Rapport::latest()->first();

        // if ($lastRapport) {
        //     // Extract the increment part and increment it
        //     // $lastIncrementPart = intval(explode('-', $lastRapport->reference)[1]);
        //     $lastIncrementPart = $lastRapport ? substr($lastRapport->reference, -3) : 0;
        //     $newIncrementPart = str_pad((int)$lastIncrementPart + 1, 3, '0', STR_PAD_LEFT);
        // } else {
        //     // If there is no event yet, start the increment part from 1
        //     $newIncrementPart = 1;
        // }

        // Generate the new reference
        $currentYear = date('Y');
        $nextYear = intval($currentYear) + 1;
        $newReference = "$currentYear-$nextYear";

        $userId = auth()->id();

        $evenements = Evenement::where('user_id', $userId)->with('evenement_type')
            ->get();
        $association = Association::where('user_id', $userId)->get();

        $data = [
            'evenements' => $evenements,
            'association' => $association
        ];

        $pdf = PDF::loadView('documents.rapport_litteraire', $data);
        // $filePath = 'documents/rapports/rapport_litteraire_' . $newReference . '.pdf';
        $filePath = 'rapport_litteraire_' . $newReference . '.pdf';
        Storage::disk('public')->put($filePath, $pdf->output());
        // Save the Rapport
        Rapport::create([
            'file_path' => $filePath,
            'title' => $newReference
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filePath, ['Content-Type' => 'application/pdf']);
    }
}
