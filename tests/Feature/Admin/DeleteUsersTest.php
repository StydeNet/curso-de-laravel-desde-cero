<?php

namespace Tests\Feature\Admin;

use App\User;
use App\UserProfile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_sends_a_user_to_the_trash()
    {
        $user = factory(User::class)->create();

        factory(UserProfile::class)->create([
            'user_id' => $user->id,
        ]);

        $this->patch("usuarios/{$user->id}/papelera")
            ->assertRedirect('usuarios');

        // Option 1:
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
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
        $user = factory(User::class)->create([
            'deleted_at' => now()
        ]);

        factory(UserProfile::class)->create([
            'user_id' => $user->id,
        ]);

        $this->delete("usuarios/{$user->id}")
            ->assertRedirect('usuarios/papelera');

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function it_cannot_delete_a_user_that_is_not_in_the_trash()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create([
            'deleted_at' => null,
        ]);

        factory(UserProfile::class)->create([
            'user_id' => $user->id,
        ]);

        $this->delete("usuarios/{$user->id}")
            ->assertStatus(404);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }
}
