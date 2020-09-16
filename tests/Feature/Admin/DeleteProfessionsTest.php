<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Profession;
use App\User;
use App\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProfessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_deletes_a_profession()
    {
        $profession = Profession::factory()->create();

        $response = $this->delete("profesiones/{$profession->id}");

        $response->assertRedirect();

        $this->assertDatabaseEmpty('professions');
    }

    /** @test */
    function a_profession_associated_to_a_profile_cannot_be_deleted()
    {
        $this->withExceptionHandling();

        $profession = Profession::factory()->create();

        $user = User::factory()->create();
        $user->profile->update([
            'profession_id' => $profession->id,
        ]);

        $response = $this->delete("profesiones/{$profession->id}");

        $response->assertStatus(400);

        $this->assertDatabaseHas('professions', [
            'id' => $profession->id,
        ]);
    }
}
