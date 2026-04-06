<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Livre;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LivreTest extends TestCase
{
    use RefreshDatabase;

    public function test_affichage_catalogue()
    {
        Livre::factory()->create([
            'titre' => 'Clean Code'
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Clean Code');
    }

    public function test_recherche_livre()
    {
        Livre::factory()->create(['titre' => 'Laravel']);
        Livre::factory()->create(['titre' => 'Java']);

        $response = $this->get('/?search=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel');
        $response->assertDontSee('Java');
    }
}