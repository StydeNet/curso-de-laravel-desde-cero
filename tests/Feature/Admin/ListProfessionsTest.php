<?php

namespace Tests\Feature\Admin;

use App\Profession;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListProfessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_professions_list()
    {
        Profession::factory()->create(['title' => 'Diseñador']);

        Profession::factory()->create(['title' => 'Programador']);

        Profession::factory()->create(['title' => 'Administrador']);

        $this->get('/profesiones')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Administrador',
                'Diseñador',
                'Programador',
            ]);
    }
}
