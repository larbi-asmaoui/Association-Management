<?php

namespace App\Http\Controllers;

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
        // $startYear = $yearParts[0];
        // $endYear = isset($yearParts[1]) ? $yearParts[1] : null;
        $userId = auth()->id();
        $rapports = Rapport::where('user_id', $userId)->get();


        $latestReunion = null;
        $depenses = null;
        $reunionsCount = Reunion::where('user_id', $userId)->count();
        if ($reunionsCount == 0) {
            $evenements = [];
            $depenses = null;
        } else if ($reunionsCount == 1) {
            $latestReunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->first();
            $evenements = Evenement::where('user_id', $userId)
                ->where('start', '<=', $latestReunion->date)
                ->with('evenement_type')
                ->get();
            $depenses = Depense::where('user_id', $userId)
                ->where('depense_date', '<=', $latestReunion->date)
                ->get();
            // ->sum('montant');
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
            $depenses = Depense::where('user_id', $userId)
                ->where('depense_date', '<=', $newestReunion->date)
                ->where('depense_date', '>=', $previousReunion->date)
                ->get();
            // ->sum('montant');
        }

        // create a associative array that contains the total revenue and name of the event type
        $evenements = $evenements->groupBy('evenement_type.name')
            ->map(function ($groupedEvents) {
                return [
                    'totalRevenue' => $groupedEvents->sum('revenue'),
                    'totalDepense' => $groupedEvents->sum('depense'),
                ];
            });

        // dd($evenements);



        $totalRevenue = $evenements->sum('revenue');
        $totalDepense = $evenements->sum('depense');
        $totalBenefice = $totalRevenue - $totalDepense;

        // dd($depenses);
        return Inertia::render('Documents/Index', [
            'evenements' => $evenements,
            'rapports' => $rapports,
            'latestReunion' => $latestReunion,
            'totalRevenue' => $totalRevenue,
            'totalDepense' => $totalDepense,
            'totalBenefice' => $totalBenefice,
            'depenses' => $depenses,
        ]);
    }


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

    public function generateRapportFinancierPdf()
    {
        $userId = auth()->id();

        $count = Rapport::where('user_id', $userId)->count();

        if ($count == 0) {
            $newIncrementPart = 1;
        } else {
            $newIncrementPart = $count + 1;
        }

        $currentYear = date('Y');
        $nextYear = intval($currentYear) + 1;
        $newReference =  "$currentYear-$nextYear-$newIncrementPart";

        $depenses = null;
        $revenues = null;
        $reunionsCount = Reunion::where('user_id', $userId)->count();
        if ($reunionsCount == 0) {
            $evenements = [];
            $depenses = null;
            $revenues = null;
        } else if ($reunionsCount == 1) {
            $latestReunion = Reunion::whereHas('reunion_type', function ($query) {
                $query->where('name', 'normal');
            })->orderBy('date', 'desc')->first();
            $evenements = Evenement::where('user_id', $userId)
                ->where('start', '<=', $latestReunion->date)
                ->with('evenement_type')
                ->get();
            $depenses = Depense::where('user_id', $userId)
                ->where('depense_date', '<=', $latestReunion->date)
                ->get();
            // ->sum('montant');
            $revenues = Revenue::where('user_id', $userId)
                ->where('revenue_date', '<=', $latestReunion->date)
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
            $depenses = Depense::where('user_id', $userId)
                ->where('depense_date', '<=', $newestReunion->date)
                ->where('depense_date', '>=', $previousReunion->date)
                ->get();

            $revenues = Revenue::where('user_id', $userId)
                ->where('revenue_date', '<=', $newestReunion->date)
                ->where('revenue_date', '>=', $previousReunion->date)
                ->get();
        }

        // create a associative array that contains the total revenue and name of the event type
        $evenements = $evenements->groupBy('evenement_type.name')
            ->map(function ($groupedEvents) {
                return [
                    'totalRevenue' => $groupedEvents->sum('revenue'),
                    'totalDepense' => $groupedEvents->sum('depense'),
                ];
            });

        $depenses = $depenses->groupBy('depense_type.name')
            ->map(function ($groupedDepenses) {
                return [
                    'total' => $groupedDepenses->sum('montant'),
                ];
            });

        $revenues = $revenues->groupBy('revenue_type.name')
            ->map(function ($groupedRevenues) {
                return [
                    'total' => $groupedRevenues->sum('montant'),
                ];
            });

        $data = [
            'revenues' => $revenues,
            'depenses' => $depenses,
            'evenements' => $evenements,
            'association' => Association::where('user_id', $userId)->get()
        ];

        $mpdf = new mPDF();
        $view = view('documents.rapport_financier', $data);
        $html = $view->render();
        $mpdf->WriteHTML($html);

        $directoryPath = 'documents/rapports/';
        $fileName = 'rapport_financier_' . $newReference . '.pdf';
        $filePath = $directoryPath . $fileName;
        Rapport::create([
            'user_id' => $userId,
            'file_path' => $filePath,
            'title' => "financier-" . $newReference,
        ]);
        // Save the PDF to a file
        Storage::disk('public')->put($filePath, $mpdf->output());
        // Save the Rapport

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->output();
        }, $fileName, ['Content-Type' => 'application/pdf']);
    }
}



// <?php

// namespace App\Http\Controllers;

// use App\Models\{Association, Depense, Evenement, Rapport, Reunion};
// use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Illuminate\Support\Facades\Storage;
// use Inertia\Inertia;
// use Mpdf\Mpdf;

// class DocumentsController extends Controller
// {
//     public function index(Request $request)
//     {
//         $year = $request->get('year');
//         $yearParts = explode('/', $year);
//         $userId = auth()->id();
//         $rapports = Rapport::where('user_id', $userId)->get();

//         [$evenements, $depenses, $latestReunion] = $this->getEventData($userId);

//         $evenements = $this->mapEvents($evenements);

//         $totalRevenue = $evenements->sum('revenue');
//         $totalDepense = $evenements->sum('depense');
//         $totalBenefice = $totalRevenue - $totalDepense;

//         return Inertia::render('Documents/Index', [
//             'evenements' => $evenements,
//             'rapports' => $rapports,
//             'latestReunion' => $latestReunion,
//             'totalRevenue' => $totalRevenue,
//             'totalDepense' => $totalDepense,
//             'totalBenefice' => $totalBenefice,
//             'depenses' => $depenses,
//         ]);
//     }

//     private function getEventData($userId)
//     {
//         $reunionsCount = Reunion::where('user_id', $userId)->count();
//         $latestReunion = null;
//         $evenements = [];
//         $depenses = null;

//         if ($reunionsCount > 0) {
//             $latestReunion = Reunion::whereHas('reunion_type', fn ($query) => $query->where('name', 'normal'))
//                 ->orderBy('date', 'desc')
//                 ->first();

//             $evenements = Evenement::where('user_id', $userId)
//                 ->where('start', '<=', $latestReunion->date)
//                 ->with('evenement_type')
//                 ->get();

//             $depenses = Depense::where('user_id', $userId)
//                 ->where('depense_date', '<=', $latestReunion->date)
//                 ->get();
//         }

//         if ($reunionsCount > 1) {
//             $reunions = Reunion::whereHas('reunion_type', fn ($query) => $query->where('name', 'normal'))
//                 ->orderBy('date', 'desc')
//                 ->take(2)
//                 ->get();

//             $newestReunion = $reunions->first();
//             $previousReunion = $reunions->last();

//             $evenements = Evenement::where('user_id', $userId)
//                 ->whereBetween('start', [$previousReunion->date, $newestReunion->date])
//                 ->with('evenement_type')
//                 ->get();

//             $depenses = Depense::where('user_id', $userId)
//                 ->whereBetween('depense_date', [$previousReunion->date, $newestReunion->date])
//                 ->get();
//         }

//         return [$evenements, $depenses, $latestReunion];
//     }

//     private function mapEvents($evenements)
//     {
//         return $evenements->groupBy('evenement_type.name')
//             ->map(fn ($groupedEvents) => [
//                 'totalRevenue' => $groupedEvents->sum('revenue'),
//                 'totalDepense' => $groupedEvents->sum('depense'),
//             ]);
//     }

//     public function generateRapportLitterairePdf()
//     {
//         $userId = auth()->id();
//         $newReference = $this->getReference($userId);

//         [$evenements,, $latestReunion] = $this->getEventData($userId);
//         $association = Association::where('user_id', $userId)->get();

//         $data = [
//             'evenements' => $evenements,
//             'association' => $association
//         ];

//         $filePath = $this->generatePdf($data, 'documents.rapport_litteraire', $newReference, 'littéraire');

//         return $this->streamDownload($filePath, 'rapport_litteraire_' . $newReference . '.pdf');
//     }

//     public function generateRapportFinancierPdf()
//     {
//         $userId = auth()->id();
//         $newReference = $this->getReference($userId);

//         $data = [
//             'evenements' => Evenement::where('user_id', $userId)->with('evenement_type')->get(),
//             'association' => Association::where('user_id', $userId)->get()
//         ];

//         $filePath = $this->generatePdf($data, 'documents.rapport_financier', $newReference, 'financier');

//         return $this->streamDownload($filePath, 'rapport_financier_' . $newReference . '.pdf');
//     }

//     private function getReference($userId)
//     {
//         $count = Rapport::where('user_id', $userId)->count();

//         $newIncrementPart = $count ? $count + 1 : 1;

//         $currentYear = date('Y');
//         $nextYear = intval($currentYear) + 1;

//         return "$currentYear-$nextYear-$newIncrementPart";
//     }

//     private function generatePdf($data, $viewName, $newReference, $title)
//     {
//         $mpdf = new mPDF();
//         $html = view($viewName, $data)->render();
//         $mpdf->WriteHTML($html);

//         $filePath = 'documents/rapports/rapport_' . $title . '_' . $newReference . '.pdf';

//         Rapport::create([
//             'user_id' => auth()->id(),
//             'file_path' => $filePath,
//             'title' => $title . "-" . $newReference,
//         ]);

//         Storage::disk('public')->put($filePath, $mpdf->output());

//         return $filePath;
//     }

//     private function streamDownload($filePath, $fileName)
//     {
//         return response()->streamDownload(function () use ($filePath) {
//             echo Storage::disk('public')->get($filePath);
//         }, $fileName, ['Content-Type' => 'application/pdf']);
//     }
// }
