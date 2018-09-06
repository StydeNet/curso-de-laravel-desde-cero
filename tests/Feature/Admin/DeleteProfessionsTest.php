<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\{Profession, User, UserProfile};
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProfessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_deletes_a_profession()
    {
        $profession = factory(Profession::class)->create();

        $response = $this->delete("profesiones/{$profession->id}");

        $response->assertRedirect();

        $this->assertDatabaseEmpty('professions');
    }

    /** @test */
    function a_profession_associated_to_a_profile_cannot_be_deleted()
    {
        $this->withExceptionHandling();

        $profession = factory(Profession::class)->create();

        $profile = factory(UserProfile::class)->create([
            'profession_id' => $profession->id,
            'user_id' => factory(User::class)->create()->id,
        ]);

        $response = $this->delete("profesiones/{$profession->id}");

        $response->assertStatus(400);

        $this->assertDatabaseHas('professions', [
            'id' => $profession->id,
        ]);
    }
}
