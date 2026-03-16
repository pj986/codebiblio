<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exemplaire;
use App\Models\Livre;

class ExemplaireSeeder extends Seeder
{
    public function run(): void
    {

        // récupérer tous les livres
        $livres = Livre::all();

        foreach ($livres as $livre) {

            // nombre d'exemplaires par livre (entre 2 et 5)
            $nombreExemplaires = rand(2,5);

            for ($i = 0; $i < $nombreExemplaires; $i++) {

                Exemplaire::create([
                    'livre_id' => $livre->id,
                    'etat' => fake()->randomElement([
                        'excellent',
                        'bon',
                        'moyen'
                    ]),
                    'disponible' => true
                ]);

            }

        }

    }
}