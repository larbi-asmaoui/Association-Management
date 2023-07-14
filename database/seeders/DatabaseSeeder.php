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
