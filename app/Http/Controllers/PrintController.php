<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
// use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;

class PrintController extends Controller
{
    public function printAdherentCard(Adherent $adherant)
    {
        $data = [
            'adherant' => $adherant,
        ];

        $pdf = PDF::loadView('adherants.card', $data);
        return response()->streamDownload(function () use ($pdf, $adherant) {
            echo $pdf->output();
        }, 'card_' . $adherant->id . '_' . $adherant->first_name . '_' . $adherant->last_name  . '.pdf', ['Content-Type' => 'application/pdf']);
    }
}
