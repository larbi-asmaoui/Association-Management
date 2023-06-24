<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Permission::create(['name' => 'edit users']);
        // Permission::create(['name' => 'delete users']);
        // Permission::create(['name' => 'create users']);
        // Permission::create(['name' => 'view users']);

        // // adherents
        // Permission::create(['name' => 'edit adherents']);
        // Permission::create(['name' => 'delete adherents']);
        // Permission::create(['name' => 'create adherents']);
        // Permission::create(['name' => 'view adherents']);

        // // reunions
        // Permission::create(['name' => 'edit reunions']);
        // Permission::create(['name' => 'delete reunions']);
        // Permission::create(['name' => 'create reunions']);
        // Permission::create(['name' => 'view reunions']);

        // // evenements
        // Permission::create(['name' => 'edit evenements']);
        // Permission::create(['name' => 'delete evenements']);
        // Permission::create(['name' => 'create evenements']);
        // Permission::create(['name' => 'view evenements']);

        // // Groupes
        // Permission::create(['name' => 'edit groupes']);
        // Permission::create(['name' => 'delete groupes']);
        // Permission::create(['name' => 'create groupes']);
        // Permission::create(['name' => 'view groupes']);

        // // Depenses
        // Permission::create(['name' => 'edit depenses']);
        // Permission::create(['name' => 'delete depenses']);
        // Permission::create(['name' => 'create depenses']);
        // Permission::create(['name' => 'view depenses']);

        // // Revenues
        // Permission::create(['name' => 'edit revenues']);
        // Permission::create(['name' => 'delete revenues']);
        // Permission::create(['name' => 'create revenues']);
        // Permission::create(['name' => 'view revenues']);

        // create roles and assign existing permissions
        // $role = Role::create(['name' => 'admin']);
        // $role->givePermissionTo('edit users');
        // $role->givePermissionTo('delete users');
        // $role->givePermissionTo('create users');
        // $role->givePermissionTo('view users');



        // $role = Role::create(['name' => 'user']);
        // Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'simple user']);
    }
}
