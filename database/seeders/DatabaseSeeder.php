<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'simple user']);
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

        // $user->assignRole('admin');


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

        \App\Models\EvenementType::create([

            'name' => 'séminaire',
        ]);

        \App\Models\EvenementType::create([

            'name' => 'conférence',
        ]);

        \App\Models\EvenementType::create([

            'name' => 'formation',
        ]);

        \App\Models\EvenementType::create([

            'name' => 'autres',
        ]);

        \App\Models\Statut::create([

            'name' => 'president',
        ]);

        \App\Models\Statut::create([

            'name' => 'vice-president',
        ]);

        \App\Models\Statut::create([

            'name' => 'tresorier',
        ]);

        \App\Models\Statut::create([

            'name' => 'vice-tresorier',
        ]);

        \App\Models\Statut::create([

            'name' => 'Secretaire',
        ]);

        \App\Models\Statut::create([

            'name' => 'vice-Secretaire',
        ]);

        \App\Models\Statut::create([

            'name' => 'Membre',
        ]);

        \App\Models\Statut::create([

            'name' => 'Consultant 1',
        ]);

        \App\Models\Statut::create([

            'name' => 'Consultant 2',
        ]);

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
