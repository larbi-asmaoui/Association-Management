<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use App\Models\Supervisor;
use Illuminate\Http\Request;

class DiplomeController extends Controller
{


    public function store(Request $request, $id)
    {
        dd($id);
        $data = $request->all();


        // if ($request->hasFile('files')) {
        //     $paths = [];
        //     foreach ($request->file('files') as $file) {
        //         $paths[] = $file->store('diploma_files');
        //     }
        //     $data['file_paths'] = $paths;
        // }

        // $validatedData = [
        //     'supervisor_id' => $supervisor->id, // This is the same as 'supervisor_id' => $supervisor->id,
        //     'name' => $data['name'],
        //     'file_paths' => $data['file_paths'],
        // ];

        // $supervisor->diplomes()->create($validatedData);
        return redirect()->back();
    }

    public function update(Request $request, Diplome $diploma)
    {
        $data = $request->all();

        if ($request->hasFile('files')) {
            $paths = $diploma->file_paths ?? []; // Retrieve existing file paths
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('diploma_files');
            }
            $data['file_paths'] = $paths;
        }

        $diploma->update($data);
        return redirect()->back();
    }



    public function show(Diplome $diplome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diplome $diplome)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $diplome = Diplome::find($id);
        $diplome->delete();
        return redirect()->back();
    }
}
