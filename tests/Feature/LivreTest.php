<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Livre;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LivreTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_livre_peut_etre_cree()
    {
        $livre = Livre::create([
            'titre' => 'Test Livre',
            'auteur' => 'Pierre',
            'categorie' => 'Informatique'
        ]);

        $this->assertDatabaseHas('livres', [
            'titre' => 'Test Livre'
        ]);
    }
}