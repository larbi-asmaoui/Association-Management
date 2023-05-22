<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();
        \App\Models\DepenseType::create([
            'user_id' => 1,
            'name' => 'Transport',
        ]);
        \App\Models\DepenseType::create([
            'user_id' => 1,
            'name' => 'éléctricité et eau',
        ]);
        \App\Models\DepenseType::create([
            'user_id' => 1,
            'name' => 'documents',
        ]);

        \App\Models\DepenseType::create([
            'user_id' => 1,
            'name' => 'autres',
        ]);

        \App\Models\StockType::create([
            'user_id' => 1,
            'name' => 'inactif',
        ]);
        \App\Models\StockType::create([
            'user_id' => 1,
            'name' => 'actif',
        ]);
        \App\Models\StockType::create([
            'user_id' => 1,
            'name' => 'sécurité',
        ]);

        \App\Models\Groupe::factory(5)->create();
        \App\Models\Adherant::factory(10)->create();



        \App\Models\Stock::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


    }
}
