<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupeRequest;
use App\Http\Requests\UpdateGroupeRequest;
use Illuminate\Support\Facades\Request;
use App\Models\Groupe;
use Inertia\Inertia;

class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupes = Groupe::all();
        if (request()->wantsJson()) {
            return $groupes;
        }
        return Inertia::render('Groupes/Index', [
            // 'groupes' => $groupes,
            'groupes' => Groupe::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->OrWhere('description', 'like', '%' . $search . '%');
                })->paginate(5)
                ->appends(Request::all()),
            // 'filters' => Request::only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Groupes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupeRequest $request)
    {
        $groupe = Groupe::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Groupe $groupe)
    {
        return Inertia::render('Groupes/Show', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Groupe $groupe)
    {
        return Inertia::render('Groupes/Edit', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupeRequest $request, Groupe $groupe)
    {
        $groupe->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('groupes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Groupe $groupe)
    {
        $groupe->delete();

        return redirect()->route('groupes.index');
    }
}
