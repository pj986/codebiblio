<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emprunt;
use App\Models\User;
use App\Models\Exemplaire;
use Illuminate\Support\Facades\DB;

class EmpruntSeeder extends Seeder
{
    public function run(): void
    {

        $users = User::all();
        $exemplaires = Exemplaire::all();

        for ($i = 0; $i < 250; $i++) {

            $emprunt = Emprunt::create([
                'user_id' => $users->random()->id,
                'date_emprunt' => now(),
                'date_retour_prevue' => now()->addDays(30)
            ]);

            $nombreExemplaires = rand(1,5);

            for ($j = 0; $j < $nombreExemplaires; $j++) {

                $ex = $exemplaires->random();

                DB::table('emprunt_exemplaire')->insert([
                    'emprunt_id' => $emprunt->id,
                    'exemplaire_id' => $ex->id
                ]);

            }

        }

    }
}