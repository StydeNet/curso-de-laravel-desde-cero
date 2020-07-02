<?php

namespace Tests\Feature\Admin;

use App\Team;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function search_users_by_name()
    {
        factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        factory(User::class)->create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);

        $this->get('/usuarios?search=John')
            ->assertStatus(200)
            ->assertSee('John Doe')
            ->assertDontSee('Jane Doe');
    }

    /** @test */
    function show_results_with_a_partial_search_by_name()
    {
        factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        factory(User::class)->create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);

        $this->get('/usuarios?search=Jo')
            ->assertStatus(200)
            ->assertSee('John Doe')
            ->assertDontSee('Jane Doe');
    }

    /** @test */
    function search_users_by_email()
    {
        factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        factory(User::class)->create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);

        $this->get('/usuarios?search=john.doe@example.com')
            ->assertStatus(200)
            ->assertSee('John Doe')
            ->assertDontSee('Jane Doe');
    }

    /** @test */
    function show_results_with_a_partial_search_by_email()
    {
        factory(User::class)->create([
            'email' => 'john.doe@example.com',
        ]);

        factory(User::class)->create([
            'email' => 'jane.doe@example.com',
        ]);

        $this->get('/usuarios?search=john.doe@ex')
            ->assertStatus(200)
            ->assertSee('john.doe@example.com')
            ->assertDontSee('jane.doe@example.com');
    }

    /** @test */
    function search_users_by_team_name()
    {
        factory(User::class)->create([
            'name' => 'John Doe',
            'team_id' => factory(Team::class)->create(['name' => "John's company"]),
        ]);

        factory(User::class)->create([
            'name' => 'Jane Doe',
            'team_id' => null,
        ]);

        factory(User::class)->create([
            'name' => 'Roe Doe',
            'team_id' => factory(Team::class)->create(['name' => "ROE INC"]),
        ]);

        $this->get('/usuarios?search=ROE INC')
            ->assertStatus(200)
            ->assertSee('Roe Doe')
            ->assertDontSee('John Doe')
            ->assertDontSee('Jane Doe');
    }

    /** @test */
    function partial_search_by_team_name()
    {
        factory(User::class)->create([
            'name' => 'John Doe',
            'team_id' => factory(Team::class)->create(['name' => "John's company"]),
        ]);

        factory(User::class)->create([
            'name' => 'Jane Doe',
            'team_id' => null,
        ]);

        factory(User::class)->create([
            'name' => 'Roe Doe',
            'team_id' => factory(Team::class)->create(['name' => "ROE INC"]),
        ]);

        $this->get('/usuarios?search=INC')
            ->assertStatus(200)
            ->assertSee('Roe Doe')
            ->assertDontSee('John Doe')
            ->assertDontSee('Jane Doe');
    }
}
