<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $permissions = Permission::all();
        $users = User::where('id', '!=', auth()->user()->id)->with('permissions')->get();

        // $users->map(function ($user) {
        //     $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();
        //     if ($role != null) {
        //         $role_name = Role::find($role->role_id)->name;
        //         $user->role = $role_name;
        //     }
        //     return $user;
        // });

        return Inertia::render('Users/Index', [
            'users' => $users,
            'roles' => Role::all(),
            'permissions' => $permissions
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
            'permissions' => 'nullable|array',
        ]);

        // create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
        ]);

        foreach ($request->permissions as $permissionId) {
            $permission = Permission::findById($permissionId);
            if ($permission) {
                $user->givePermissionTo($permission);
            }
        }


        return back()->with('success', 'User added successfully.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'permissions' => 'required|array', // Ensure permissions is an array
        ]);

        // update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // remove all current permissions
        $user->permissions()->detach();

        // validate each permission in the array exists
        foreach ($request->permissions as $permissionId) {
            $permission = Permission::findById($permissionId);
            if ($permission) {
                $user->givePermissionTo($permission);
            }
        }

        return back()->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
