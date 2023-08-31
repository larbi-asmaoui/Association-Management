<?php

namespace App\Http\Controllers;


use App\Models\Adherent;
use App\Models\Activity;
use App\Models\ActivityType;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $activityTypes = ActivityType::all();
        $adherents = Adherent::all();

        return Inertia::render('Activities/Index', [
            'activities' => Activity::query()
                ->with('adherents')
                ->with('activity_type')
                ->get(),
            'adherents' => $adherents,
            'activityTypes' => $activityTypes
            // 'filters' => Request::only(['search'])
        ]);
    }
    public function calender()
    {

        $Activities = Activity::all();
        $adherents = Adherent::all();

        return Inertia::render('Activities/Calender', [
            'activities' => $Activities,
            'adherents' => $adherents
            // 'filters' => Request::only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Activities/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'start' => 'required',
            'end' => 'required',
            'description' => 'nullable',
            'location' => 'required',
            'city' => 'required',
            'region' => 'required',
            'activity_type_id' => 'required|exists:activity_types,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
        ]);

        // Fetch the last created event's reference number
        $lastActivity = Activity::latest()->first();

        if ($lastActivity) {
            // Extract the increment part and increment it
            // $lastIncrementPart = intval(explode('-', $lastActivity->reference)[1]);
            $lastIncrementPart = $lastActivity ? substr($lastActivity->reference, -3) : 0;
            $newIncrementPart = str_pad((int)$lastIncrementPart + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // If there is no event yet, start the increment part from 1
            $newIncrementPart = 1;
        }

        // Generate the new reference
        $currentYear = date('Y');
        $prevYear = intval($currentYear) - 1;
        $newReference = "$prevYear/$currentYear-$newIncrementPart";

        // Add the reference to the data
        $validatedData['reference'] = $newReference;

        $activityData = [
            'title' => $validatedData['title'],
            'start' => $validatedData['start'],
            'end' => $validatedData['end'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'region' => $validatedData['region'],
            'city' => $validatedData['city'],
            'activity_type_id' => $validatedData['activity_type_id'],

            'reference' => $validatedData['reference']

        ];
        // Create the event
        $newEvent = Activity::create($activityData);

        if (isset($validatedData['adherents'])) {
            $newEvent->adherents()->sync($validatedData['adherents']);
            // dd($newEvent);
        }
        return redirect()->back()->with('success', 'Event created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {

        // load activity with its adherents and activity type
        $activity->load('adherents');
        $activity->load('activity_type');

        $adherents = Adherent::all();
        $activityTypes = ActivityType::all();
        return Inertia::render('Activities/Show', [
            'activity' => $activity,
            'activityTypes' => $activityTypes,
            'adherents' => $adherents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, Activity $activity)
    {
        $activity->load('adherents');
        $formFields = $request->validate([
            'title' => 'required',
            'start' => 'required',
            'description' => 'nullable',
            'revenue' => 'nullable',
            'depense' => 'nullable',
            'end' => 'required',
            'location' => 'required',
            'city' => 'required',
            'region' => 'required',
            'activity_type_id' => 'required|exists:activity_types,id',
            'adherents' => 'nullable|array',
            'adherents.*' => 'exists:adherents,id',
        ]);

        $adherents = $formFields['adherents'];
        unset($formFields['adherents']);

        $activity->update($formFields);

        if (isset($adherents)) {
            $activity->adherents()->sync($adherents);
        }
        return redirect()->back()->with('success', 'Activity updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->back()->with('success', 'Activity deleted.');
    }
}
