<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function search_users_by_name()
    {
        $joel = factory(User::class)->create([
            'name' => 'Joel'
        ]);

        $ellie = factory(User::class)->create([
            'name' => 'Ellie',
        ]);

        $this->get('/usuarios?search=Joel')
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && !$users->contains($ellie);
            });
    }

    /** @test */
    function show_results_with_a_partial_search_by_name()
    {
        $joel = factory(User::class)->create([
            'name' => 'Joel'
        ]);

        $ellie = factory(User::class)->create([
            'name' => 'Ellie',
        ]);

        $this->get('/usuarios?search=Jo')
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && !$users->contains($ellie);
            });
    }

    /** @test */
    function search_users_by_email()
    {
        $joel = factory(User::class)->create([
            'email' => 'joel@example.com',
        ]);

        $ellie = factory(User::class)->create([
            'email' => 'ellie@example.net',
        ]);

        $this->get('/usuarios?search=joel@example.com')
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && !$users->contains($ellie);
            });
    }

    /** @test */
    function show_results_with_a_partial_search_by_email()
    {
        $joel = factory(User::class)->create([
            'email' => 'joel@example.com',
        ]);

        $ellie = factory(User::class)->create([
            'email' => 'ellie@example.net',
        ]);

        $this->get('/usuarios?search=joel@example')
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && !$users->contains($ellie);
            });
    }
}
