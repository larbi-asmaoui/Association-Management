<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\Category;
use App\Models\Classe;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adherents = Adherent::all();
        $classes = Classe::query()
            ->with('adherents')
            ->withCount('adherents')
            ->with('supervisors')
            ->with('category')
            ->get();

        $categories = Category::query()->with('classes')->get();
        $supervisors = Supervisor::all();
        return Inertia::render(
            'Classes/Index',
            [
                'adherents' => $adherents,
                'classes' => $classes,
                'supervisors' => $supervisors,
                'categories' => $categories,
            ]
        );
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
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
            'supervisors' => 'nullable|array',
            'supervisors.*' => 'exists:supervisors,id',
        ]);

        $classeData = [
            'name' => $formFields['name'],
            'description' => $formFields['description'],
            'category_id' => $formFields['category_id'],
        ];

        $classe = Classe::create($classeData);
        if (isset($formFields['adherents'])) {
            // $adherentIds = $request->input('adherents');
            Adherent::whereIn('id', $formFields['adherents'])->update(['classe_id' => $classe->id]);
        }

        if (isset($formFields['supervisors'])) {
            $classe->supervisors()->sync($formFields['supervisors']);
        }


        return redirect()->back()->with('success', 'reunion created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classe $classe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classe $classe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //  update the classe
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            // 'supervisor_id' => 'required|exists:supervisors,id',
            'category_id' => 'required|exists:categories,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
            'supervisors' => 'nullable|array',
            'supervisors.*' => 'exists:supervisors,id',
        ]);

        $classeData = [
            'name' => $formFields['name'],
            'description' => $formFields['description'],
            'category_id' => $formFields['category_id'],
        ];

        // $supervisors = $formFields['supervisors'];

        // unset($formFields['supervisors']);

        $classe = Classe::find($id);

        $classe->update($classeData);

        Adherent::whereIn('id', $formFields['adherents'])->update(['classe_id' => $classe->id]);


        $classe->supervisors()->sync($formFields['supervisors']);


        return redirect()->back()->with('success', 'reunion updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $classe = Classe::find($id);
        $classe->delete();
        return  redirect()->route('classes.index')->with('message', 'classe est supprimé avec succès');
    }
}
