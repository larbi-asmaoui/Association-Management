<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'update users']);

        Permission::create(['name' => 'add adherent']);
        Permission::create(['name' => 'delete adherent']);
        Permission::create(['name' => 'read adherent']);
        Permission::create(['name' => 'update adherent']);

        Permission::create(['name' => 'add reunion']);
        Permission::create(['name' => 'delete reunion']);
        Permission::create(['name' => 'read reunion']);
        Permission::create(['name' => 'update reunion']);

        Permission::create(['name' => 'add reunion type']);
        Permission::create(['name' => 'delete reunion type']);
        Permission::create(['name' => 'read reunion type']);
        Permission::create(['name' => 'update reunion type']);

        Permission::create(['name' => 'add statut']);
        Permission::create(['name' => 'delete statut']);
        Permission::create(['name' => 'read statut']);
        Permission::create(['name' => 'update statut']);

        Permission::create(['name' => 'add activity']);
        Permission::create(['name' => 'delete activity']);
        Permission::create(['name' => 'read activity']);
        Permission::create(['name' => 'update activity']);



        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'simple user']);
        $user = User::create([
            'name' => "asmaoui",
            'email' => "admin@admin.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);

        // get all permissions
        $permissions = Permission::all();

        // assign all permissions to user
        $user->syncPermissions($permissions);




        \App\Models\DepenseType::create([

            'name' => 'Transport',
        ]);
        \App\Models\DepenseType::create([

            'name' => 'éléctricité et eau',
        ]);
        \App\Models\DepenseType::create([

            'name' => 'documents',
        ]);

        \App\Models\DepenseType::create([

            'name' => 'autres',
        ]);

        \App\Models\StockType::create([

            'name' => 'inactif',
        ]);
        \App\Models\StockType::create([

            'name' => 'actif',
        ]);
        \App\Models\StockType::create([

            'name' => 'sécurité',
        ]);

        \App\Models\ActivityType::create([

            'name' => 'séminaire',
        ]);

        \App\Models\ActivityType::create([

            'name' => 'conférence',
        ]);

        \App\Models\ActivityType::create([

            'name' => 'formation',
        ]);

        \App\Models\ActivityType::create([

            'name' => 'autres',
        ]);

        // Reunion Type
        // \App\Models\ReunionType::create([

        //     'name' => 'الجمع العام',
        // ]);

        \App\Models\ReunionType::create([

            'name' => 'الجمع العام العادي',
        ]);

        // \App\Models\ReunionType::create([

        //     'name' => 'الجمع العام غير العادي',
        // ]);

        \App\Models\ReunionType::create([

            'name' => 'الجمع العام الاستثنائي',
        ]);



        // \App\Models\Statut::create([

        //     'name' => 'الرئيس',
        // ]);

        // \App\Models\Statut::create([

        //     'name' => 'نائب الرئيس',
        // ]);

        // \App\Models\Statut::create([

        //     'name' => 'الأمين',
        // ]);

        // \App\Models\Statut::create([

        //     'name' => 'نائب الأمين',
        // ]);

        // \App\Models\Statut::create([

        //     'name' => 'الكاتب',
        // ]);

        // \App\Models\Statut::create([

        //     'name' => 'نائب الكاتب',
        // ]);

        // \App\Models\Statut::create([

        //     'name' => 'المستشار 1',
        // ]);

        // \App\Models\Statut::create([

        //     'name' => 'المستشار 2',
        // ]);





        // \App\Models\Association::create()


        // \App\Models\Groupe::factory(5)->create();
        // \App\Models\Adherent::factory(20)->create();
        // \App\Models\Cotisation::factory(10)->create();



        // \App\Models\Stock::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


    }
}
