<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_fails_on_purpose()
    {
        $profession = Profession::factory()->create();

        $this->get("/professions/{$profession->id}/edit")
            ->assertStatus(200);
    }
}
