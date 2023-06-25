<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Get all users for this association except the current user
        $users = User::where('id', '!=', auth()->user()->id)->get();

        // Append role to each user
        $users->map(function ($user) {
            $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();
            if ($role != null) {
                $role_name = Role::find($role->role_id)->name;
                $user->role = $role_name;
            }
            return $user;
        });

        // Render the user index view
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable',
            'role' => 'required|exists:roles,name'
        ]);

        // Remove all assigned roles from the user
        foreach ($user->roles as $role) {
            $user->removeRole($role->name);
        }

        // Assign the new role to the user
        $user->assignRole($request->role);

        // Update user with request data
        $user->update($request->only('name', 'email'));

        // Return back with success message
        return back()->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Delete user
        $user->delete();

        // Return back with success message
        return back()->with('success', 'User deleted successfully.');
    }
}
