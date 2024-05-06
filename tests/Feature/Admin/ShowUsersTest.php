<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUsersTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    function it_displays_the_users_details()
    {
        $user = User::factory()->create([
            'name' => 'Duilio Palacios'
        ]);

        $this->get("/users/{$user->id}")
        ->assertStatus(200)
            ->assertSee('Duilio Palacios');
    }

    #[Test]
    function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->withExceptionHandling();

        $this->get('/users/999')
            ->assertStatus(404)
            ->assertSee('Not Found');
    }
}
