<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BackOfficeTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_visiteur_ne_peut_pas_acceder_au_backoffice()
    {
        $response = $this->get('/bo/profils');

        $response->assertRedirect('/login');
    }
}