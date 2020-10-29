<?php

namespace Tests\Feature\Admin;

use App\Models\Login;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_users_list()
    {
        User::factory()->create([
            'name' => 'Joel'
        ]);

        User::factory()->create([
            'name' => 'Ellie',
        ]);

        $this->get('/users')
            ->assertStatus(200)
            ->assertSee(trans('users.title.index'))
            ->assertSee('Joel')
            ->assertSee('Ellie');

        $this->assertNotRepeatedQueries();
    }

    /** @test */
    function it_paginates_the_users()
    {
        User::factory()->create([
            'name' => 'Third User',
            'created_at' => now()->subDays(5),
        ]);

        User::factory()->times(12)->create([
            'created_at' => now()->subDays(4),
        ]);

        User::factory()->create([
            'name' => 'Seventeenth User',
            'created_at' => now()->subDays(2),
        ]);

        User::factory()->create([
            'name' => 'Second User',
            'created_at' => now()->subDays(6),
        ]);

        User::factory()->create([
            'name' => 'First User',
            'created_at' => now()->subWeek(),
        ]);

        User::factory()->create([
            'name' => 'Sixteenth User',
            'created_at' => now()->subDays(3),
        ]);

        $this->get('/users')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Seventeenth User',
                'Sixteenth User',
                'Third User',
            ])
            ->assertDontSee('Second User')
            ->assertDontSee('First User');

        $this->get('/users?page=2')
            ->assertSeeInOrder([
                'Second User',
                'First User',
            ])
            ->assertDontSee('Third User');
    }

    /** @test */
    function users_are_ordered_by_name()
    {
        User::factory()->create(['name' => 'John Doe']);
        User::factory()->create(['name' => 'Richard Roe']);
        User::factory()->create(['name' => 'Jane Doe']);

        $this->get('/users?order=name')
            ->assertSeeInOrder([
                'Jane Doe',
                'John Doe',
                'Richard Roe',
            ]);

        $this->get('/users?order=name-desc')
            ->assertSeeInOrder([
                'Richard Roe',
                'John Doe',
                'Jane Doe',
            ]);
    }

    /** @test */
    function users_are_ordered_by_email()
    {
        User::factory()->create(['email' => 'john.doe@example.com']);
        User::factory()->create(['email' => 'richard.roe@example.com']);
        User::factory()->create(['email' => 'jane.doe@example.com']);

        $this->get('/users?order=email')
            ->assertSeeInOrder([
                'jane.doe@example.com',
                'john.doe@example.com',
                'richard.roe@example.com',
            ]);

        $this->get('/users?order=email-desc')
            ->assertSeeInOrder([
                'richard.roe@example.com',
                'john.doe@example.com',
                'jane.doe@example.com',
            ]);
    }

    /** @test */
    function users_are_ordered_by_registration_date()
    {
        User::factory()->create(['name' => 'John Doe', 'created_at' => now()->subDays(2)]);
        User::factory()->create(['name' => 'Jane Doe', 'created_at' => now()->subDays(5)]);
        User::factory()->create(['name' => 'Richard Roe', 'created_at' => now()->subDays(3)]);

        $this->get('/users?order=date')
            ->assertSeeInOrder([
                'Jane Doe',
                'Richard Roe',
                'John Doe',
            ]);

        $this->get('/users?order=date-desc')
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);
    }

    /** @test */
    function users_are_ordered_by_login_date()
    {
        Login::factory()->create([
            'created_at' => now()->subDays(3),
            'user_id' => User::factory()->create(['name' => 'John Doe']),
        ]);
        Login::factory()->create([
            'created_at' => now()->subDay(),
            'user_id' => User::factory()->create(['name' => 'Jane Doe']),
        ]);
        Login::factory()->create([
            'created_at' => now()->subDays(2),
            'user_id' => User::factory()->create(['name' => 'Richard Roe']),
        ]);

        $this->get('/users?order=login')
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->get('/users?order=login-desc')
            ->assertSeeInOrder([
                'Jane Doe',
                'Richard Roe',
                'John Doe',
            ]);
    }

    /** @test */
    function invalid_order_query_data_is_ignored_and_the_default_order_is_used_instead()
    {
        User::factory()->create(['name' => 'John Doe', 'created_at' => now()->subDays(2)]);
        User::factory()->create(['name' => 'Jane Doe', 'created_at' => now()->subDays(5)]);
        User::factory()->create(['name' => 'Richard Roe', 'created_at' => now()->subDays(3)]);

        $this->get('/users?order=id')
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->get('/users?order=invalid_column')
            ->assertOk()
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->get('/users?order=name-descendent')
            ->assertOk()
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->get('/users?order=asc-name')
            ->assertOk()
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);


        $this->get('/users?order=asc-name')
            ->assertOk()
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);
    }

    /** @test */
    function it_shows_a_default_message_if_the_users_list_is_empty()
    {
        $this->get('/users')
            ->assertStatus(200)
            ->assertSee('There are no records.');
    }

    /** @test */
    function it_shows_the_deleted_users()
    {
        User::factory()->create([
            'name' => 'Joel',
            'deleted_at' => now(),
        ]);

        User::factory()->create([
            'name' => 'Ellie',
        ]);

        $this->get('/users/trash')
            ->assertStatus(200)
            ->assertSee(trans('users.title.trash'))
            ->assertSee('Joel')
            ->assertDontSee('Ellie');
    }
}
