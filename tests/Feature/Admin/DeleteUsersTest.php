<?php

namespace Tests\Feature\Admin;

use App\Models\Skill;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @enlighten {"order": 100000}
 */
class DeleteUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_sends_a_user_to_the_trash()
    {
        $user = User::factory()->create();

        $user->skills()->attach(Skill::factory()->create());

        $this->patch("users/{$user->id}/trash")
            ->assertRedirect('users');

        // Option 1:
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);

        $this->assertSoftDeleted('user_skill', [
            'user_id' => $user->id,
        ]);

        $this->assertSoftDeleted('user_profiles', [
            'user_id' => $user->id,
        ]);

        // Option 2:
        $user->refresh();

        $this->assertTrue($user->trashed());
    }

    /** @test */
    function it_completely_deletes_a_user()
    {
        $user = User::factory()->create([
            'deleted_at' => now()
        ]);

        $this->delete("users/{$user->id}")
            ->assertRedirect('users/trash');

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function it_cannot_delete_a_user_that_is_not_in_the_trash()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create([
            'deleted_at' => null,
        ]);

        $this->delete("users/{$user->id}")
            ->assertStatus(404);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }
}
