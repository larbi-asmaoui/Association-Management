<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdherantRequest;
use App\Http\Requests\UpdateAdherantRequest;
use App\Models\Adherant;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

class AdherantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        return Inertia::render('Adherants/Index', [
            'adherants' => Adherant::query()
                ->where('user_id', $userId)
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->OrWhere('last_name', 'like', '%' . $search . '%')
                        ->OrWhere('cin', 'like', '%' . $search . '%')
                        ->OrWhere('tel', 'like', '%' . $search . '%')
                        ->OrWhere('email', 'like', '%' . $search . '%');
                })->paginate(5)
                ->appends(Request::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdherantRequest $request)
    {
        $formFields = $request->validate(
            [
                'image' => 'required|image',
                'first_name' => 'required',
                'last_name' => 'required',
                'sexe' => 'required',
                'cin' => 'required',
                'tel' => 'required',
                'date_of_birth' => 'required',
                'date_of_membership' => 'required',
                'address' => 'required',
            ]
        );
        $formFields['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('images');
        }

        Adherant::create($formFields);
        return redirect()->back()->with('success', 'Adherant created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Adherant $adherant)
    {
        return Inertia::render('Adherants/Show', ['adherant' => $adherant]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adherant $adherant)
    {
        return Inertia::render('Adherants/Edit', ['adherant' => $adherant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdherantRequest $request, Adherant $adherant)
    {
        $formFields = $request->validate(
            [
                'image' => 'required|image',
                'first_name' => 'required',
                'last_name' => 'required',
                'sexe' => 'required',
                'cin' => 'required',
                'tel' => 'required',
                'date_of_birth' => 'required',
                'date_of_membership' => 'required',
                'address' => 'required',
            ]
        );

        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('images');
        }

        $adherant->update($formFields);
        return redirect()->route('adherants.index')->with('success', 'Adherant updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adherant $adherant)
    {
        $adherant->delete();

        return redirect()->route('adherants.index')->with('message', 'adherant est supprimé avec succès');
    }

    public function printAdherentCard(Adherant $adherant)
    {

        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'landscape');

        $data = [
            'adherant' => $adherant,
        ];
        $pdf = Pdf::loadView('adherants.card', $data);
        return $pdf->download('adherent_card_' . $adherant->id . '.pdf');
    }
}
