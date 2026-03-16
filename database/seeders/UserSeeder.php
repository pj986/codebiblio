<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Administrateur
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => 'Admin Bibliothèque',
            'email' => 'admin@biblio.fr',
            'password' => Hash::make('Admin123!'),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Utilisateur de test
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => 'Utilisateur Test',
            'email' => 'user@test.fr',
            'password' => Hash::make('User123!'),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Utilisateurs Faker
        |--------------------------------------------------------------------------
        */

        for ($i = 0; $i < 25; $i++) {

            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password')
            ]);

        }

    }
}