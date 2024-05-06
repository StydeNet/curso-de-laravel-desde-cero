<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListProfessionsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
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
