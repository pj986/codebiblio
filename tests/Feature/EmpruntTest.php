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
        // 👤 user
        $user = User::factory()->create();

        // 📚 livre
        $livre = Livre::factory()->create();

        // 📦 exemplaire dispo (OBLIGATOIRE)
        $exemplaire = Exemplaire::create([
            'livre_id' => $livre->id,
            'disponible' => true
        ]);

        // 🔐 login
        $this->actingAs($user);

        // 🚀 appel route
        $response = $this->post('/emprunts/'.$livre->id.'/emprunter');

        // ✅ JSON OK
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // ✅ vérifie DB (IMPORTANT : exemplaire_id)
        $this->assertDatabaseHas('emprunts', [
            'user_id' => $user->id,
            'exemplaire_id' => $exemplaire->id
        ]);
    }
}