<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exemplaire;
use App\Models\Livre;

class ExemplaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 📚 Récupérer tous les livres
        $livres = Livre::all();

        foreach ($livres as $livre) {

            // 🔒 Évite les doublons (si déjà des exemplaires → skip)
            if ($livre->exemplaires()->exists()) {
                continue;
            }

            // 🎲 Nombre aléatoire d'exemplaires (2 à 5)
            $nombreExemplaires = rand(2, 5);

            for ($i = 0; $i < $nombreExemplaires; $i++) {

                // 💎 Création via relation Eloquent (plus propre)
                $livre->exemplaires()->create([
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