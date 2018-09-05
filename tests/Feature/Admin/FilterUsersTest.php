<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function filter_users_by_state_active()
    {
        $activeUser = factory(User::class)->create();

        $inactiveUser = factory(User::class)->create();

        $response = $this->get('/usuarios?state=active');

        $response->assertViewCollection('users')
            ->contains($activeUser)
            ->notContains($inactiveUser);
    }

    /** @test */
    function filter_users_by_state_inactive()
    {
        $activeUser = factory(User::class)->create();
        $inactiveUser = factory(User::class)->create();

        $response = $this->get('usuarios?state=active');

        $response->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($inactiveUser)
            ->notContains($activeUser);
    }
}
