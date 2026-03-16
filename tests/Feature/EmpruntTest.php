<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Livre;
use App\Models\Exemplaire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmpruntTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_utilisateur_peut_emprunter_un_livre()
    {
        $user = User::factory()->create();

        $livre = Livre::create([
            'titre' => 'Livre Test',
            'auteur' => 'Auteur Test',
            'categorie' => 'Roman'
        ]);

        $exemplaire = Exemplaire::create([
            'livre_id' => $livre->id,
            'etat' => 'excellent',
            'disponible' => true
        ]);

        $this->actingAs($user);

        $response = $this->post('/emprunter/'.$exemplaire->id);

        $response->assertStatus(302);
    }
}