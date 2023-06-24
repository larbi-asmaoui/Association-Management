<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // display users except current user
        // $users = User::where('id', '!=', auth()->user()->id)->get();
        $users = User::all();
        return Inertia::render('Users/Index', [
            'users' => $users,
            'roles' => Role::all(),
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
        // if (auth()->user()->hasRole('Admin')) {
        // validate request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
        ]);

        // create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => bcrypt('password'),
            'password' => bcrypt('password'),
        ]);

        // assign role to user
        $user->assignRole($request->role);

        // return back with success message
        return back()->with('success', 'User added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
