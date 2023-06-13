<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $association = Association::where('user_id', auth()->id())->first();
        return Inertia::render('Association/Index', [
            'association' => $association
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
    // public function store(Request $request)
    // {


    //     $association = Association::first();
    //     dd($association);
    //     if (!$association) {
    //         Validator::make($request->all(), [
    //             'name' => 'nullable',
    //             'objectifs' => 'nullable',
    //             'address' => 'nullable',
    //             'region' => 'nullable',
    //             'city' => 'nullable',

    //         ])->validate();

    //         Association::create($request->all() + ['user_id' => auth()->id()]);

    //         $this->processImage($request);

    //         return redirect()->back()
    //             ->with('message', 'Association created');
    //     } else {
    //         $association->update($request->only(['title', 'author']));

    //         $this->processImage($request, $association);

    //         return redirect()->back()
    //             ->with('message', 'Association updated');
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show(Association $association)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Association $association)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Association $association)
    {
        // with user id
        $association->update($request->all() + ['user_id' => auth()->id()]);
        // Validator::make($request->all(), [
        //     'title' => 'required',
        //     'author' => 'required'
        // ])->validate();

        // $association->update($request->only([
        //     'name' => 'nullable',
        //     'objectifs' => 'nullable',
        //     'address' => 'nullable',
        //     'region' => 'nullable',
        //     'city' => 'nullable'
        // ]));

        // $this->processImage($request, $association);

        return redirect()->back()
            ->with('message', 'Book updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Association $association)
    {
        //
    }

    protected function processImage(Request $request, Association $association = null)
    {
        if ($image = $request->get('image')) {
            $path = storage_path('app/public/' . $image);
            if (file_exists($path)) {
                copy($path, public_path($image));
                unlink($path);
            }
        }

        if ($association) {
            if (!$request->get('image')) {
                if ($association->image) {
                    if (file_exists(public_path($association->image))) {
                        unlink(public_path($association->image));
                    }
                }
            }
            $association->update([
                'image' => $request->get('image')
            ]);
        }
    }

    public function uploadRevert(Request $request)
    {
        if ($image = $request->get('image')) {
            $path = storage_path('app/public/' . $image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return '';
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('imageFilepond')) {
            return $request->file('imageFilepond')->store('uploads/logos', 'public');
        }
        return '';
    }
}
