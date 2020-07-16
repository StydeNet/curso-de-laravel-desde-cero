<?php

namespace Tests\Feature\Admin;

use App\Http\Livewire\UsersList;
use App\Login;
use App\User;
use Illuminate\Http\Request;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase, GetsUserListComponent;

    /** @test */
    function displays_the_user_list_component()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee(trans('users.title.index'))
            ->assertSeeLivewire('users-list');
    }

    /** @test */
    function shows_the_list_of_users()
    {
        factory(User::class)->create([
            'name' => 'John'
        ]);

        factory(User::class)->create([
            'name' => 'Jane',
        ]);

        $this->getUserListComponent()
            ->assertStatus(200)
            ->assertSee('John')
            ->assertSee('Jane');

        $this->assertNotRepeatedQueries();
    }

    /** @test */
    function it_paginates_the_users()
    {
        factory(User::class)->create([
            'name' => 'Tercer Usuario',
            'created_at' => now()->subDays(5),
        ]);

        factory(User::class)->times(12)->create([
            'created_at' => now()->subDays(4),
        ]);

        factory(User::class)->create([
            'name' => 'Decimoséptimo Usuario',
            'created_at' => now()->subDays(2),
        ]);

        factory(User::class)->create([
            'name' => 'Segundo Usuario',
            'created_at' => now()->subDays(6),
        ]);

        factory(User::class)->create([
            'name' => 'Primer Usuario',
            'created_at' => now()->subWeek(),
        ]);

        factory(User::class)->create([
            'name' => 'Decimosexto Usuario',
            'created_at' => now()->subDays(3),
        ]);

        $this->getUserListComponent()
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Decimoséptimo Usuario',
                'Decimosexto Usuario',
                'Tercer Usuario',
            ])
            ->assertDontSee('Segundo Usuario')
            ->assertDontSee('Primer Usuario');

        $this->getUserListComponent(['page' => 2])
            ->assertSeeInOrder([
                'Segundo Usuario',
                'Primer Usuario',
            ])
            ->assertDontSee('Tercer Usuario');
    }

    /** @test */
    function users_are_ordered_by_name()
    {
        factory(User::class)->create(['name' => 'John Doe']);
        factory(User::class)->create(['name' => 'Richard Roe']);
        factory(User::class)->create(['name' => 'Jane Doe']);

        $this->getUserListComponent(['order' => 'name'])
            ->assertSeeInOrder([
                'Jane Doe',
                'John Doe',
                'Richard Roe',
            ]);

        $this->getUserListComponent(['order' => 'name-desc'])
            ->assertSeeInOrder([
                'Richard Roe',
                'John Doe',
                'Jane Doe',
            ]);
    }

    /** @test */
    function users_are_ordered_by_email()
    {
        factory(User::class)->create(['email' => 'john.doe@example.com']);
        factory(User::class)->create(['email' => 'richard.roe@example.com']);
        factory(User::class)->create(['email' => 'jane.doe@example.com']);

        $this->getUserListComponent(['order' => 'email'])
            ->assertSeeInOrder([
                'jane.doe@example.com',
                'john.doe@example.com',
                'richard.roe@example.com',
            ]);

        $this->getUserListComponent(['order' => 'email-desc'])
            ->assertSeeInOrder([
                'richard.roe@example.com',
                'john.doe@example.com',
                'jane.doe@example.com',
            ]);
    }

    /** @test */
    function users_are_ordered_by_registration_date()
    {
        factory(User::class)->create(['name' => 'John Doe', 'created_at' => now()->subDays(2)]);
        factory(User::class)->create(['name' => 'Jane Doe', 'created_at' => now()->subDays(5)]);
        factory(User::class)->create(['name' => 'Richard Roe', 'created_at' => now()->subDays(3)]);

        $this->getUserListComponent(['order' => 'date'])
            ->assertSeeInOrder([
                'Jane Doe',
                'Richard Roe',
                'John Doe',
            ]);

        $this->getUserListComponent(['order' => 'date-desc'])
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);
    }

    /** @test */
    function users_are_ordered_by_login_date()
    {
        factory(Login::class)->create([
            'created_at' => now()->subDays(3),
            'user_id' => factory(User::class)->create(['name' => 'John Doe']),
        ]);
        factory(Login::class)->create([
            'created_at' => now()->subDay(),
            'user_id' => factory(User::class)->create(['name' => 'Jane Doe']),
        ]);
        factory(Login::class)->create([
            'created_at' => now()->subDays(2),
            'user_id' => factory(User::class)->create(['name' => 'Richard Roe']),
        ]);

        $this->getUserListComponent(['order' => 'login'])
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->getUserListComponent(['order' => 'login-desc'])
            ->assertSeeInOrder([
                'Jane Doe',
                'Richard Roe',
                'John Doe',
            ]);
    }

    /** @test */
    function invalid_order_query_data_is_ignored_and_the_default_order_is_used_instead()
    {
        factory(User::class)->create(['name' => 'John Doe', 'created_at' => now()->subDays(2)]);
        factory(User::class)->create(['name' => 'Jane Doe', 'created_at' => now()->subDays(5)]);
        factory(User::class)->create(['name' => 'Richard Roe', 'created_at' => now()->subDays(3)]);

        $this->getUserListComponent(['order' => 'id'])
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->getUserListComponent(['order' => 'invalid-column'])
            ->assertOk()
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->getUserListComponent(['order' => 'name-descendent'])
            ->assertOk()
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->getUserListComponent(['order' => 'asc-name'])
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
        $this->getUserListComponent()
            ->assertStatus(200)
            ->assertSee('No hay usuarios registrados.');
    }

    /** @test */
    function it_shows_the_deleted_users()
    {
        factory(User::class)->create([
            'name' => 'Joel',
            'deleted_at' => now(),
        ]);

        factory(User::class)->create([
            'name' => 'Ellie',
        ]);

        $this->get('/usuarios/papelera')
            ->assertStatus(200)
            ->assertSee(trans('users.title.trash'))
            ->assertSee('Joel')
            ->assertDontSee('Ellie');
    }
}
