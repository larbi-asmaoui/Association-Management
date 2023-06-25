<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use Inertia\Inertia;
use Illuminate\Http\Request;

class activityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $activityTypes = ActivityType::all();
        return Inertia::render('ActivityTypes/Index', [
            'activityTypes' => $activityTypes
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
    public function store(Request $request)
    {

        $activityType = $request->validate([
            'name' => 'required',
        ]);
        ActivityType::create($activityType);
        return redirect()->back()->with('success', 'ActivityType created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityType $activityType)
    {
        return Inertia::render('ActivityTypes/Show', [
            'activityType' => $activityType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityType $activityType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityType $activityType)
    {
        // Ensure the user is authorized to update this ActivityType
        if ($activityType->user_id != auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $formFields = $request->validate([
            'name' => 'required',
        ]);

        // Update the ActivityType
        $activityType->update($formFields);

        return redirect()->back()->with('success', 'ActivityType updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityType $activityType)
    {
        $activityType->delete();
        return redirect()->back()->with('success', 'ActivityType deleted.');
    }
}
