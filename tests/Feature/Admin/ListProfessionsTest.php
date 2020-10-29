<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListProfessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_professions_list()
    {
        Profession::factory()->create(['title' => 'Designer']);

        Profession::factory()->create(['title' => 'Developer']);

        Profession::factory()->create(['title' => 'Admin']);

        $this->get('/professions')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Admin',
                'Designer',
                'Developer',
            ]);
    }
}
