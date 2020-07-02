<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Skill;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function filter_users_by_state_active()
    {
        $activeUser = factory(User::class)->create(['name' => 'John Doe']);

        $inactiveUser = factory(User::class)->state('inactive')->create(['name' => 'Jane Doe']);

        $response = $this->get('/usuarios?state=active');

        $response->assertStatus(200)
            ->assertSee('John Doe')
            ->assertDontSee('Jane Doe');
    }

    /** @test */
    function filter_users_by_state_inactive()
    {
        $activeUser = factory(User::class)->create(['name' => 'John Doe']);

        $inactiveUser = factory(User::class)->state('inactive')->create(['name' => 'Jane Doe']);

        $response = $this->get('usuarios?state=inactive');

        $response->assertStatus(200)
            ->assertSee('Jane Doe')
            ->assertDontSee('John Doe');
    }

    /** @test */
    function filter_users_by_role_admin()
    {
        $admin = factory(User::class)->create(['role' => 'admin', 'name' => 'Mr Admin User']);

        $user = factory(User::class)->create(['role' => 'user', 'name' => 'Mr User']);

        $response = $this->get('/usuarios?role=admin');

        $response->assertSee('Mr Admin User')
            ->assertDontSee('Mr User');
    }

    /** @test */
    function filter_users_by_role_user()
    {
        $admin = factory(User::class)->create(['role' => 'admin', 'name' => 'Mr Admin User']);

        $user = factory(User::class)->create(['role' => 'user', 'name' => 'Mr User']);

        $response = $this->get('usuarios?role=user');

        $response->assertStatus(200);

        $response->assertSee('Mr User')
            ->assertDontSee('Mr Admin User');
    }

    /** @test */
    function filter_users_by_skill()
    {
        $php = factory(Skill::class)->create(['name' => 'php']);
        $css = factory(Skill::class)->create(['name' => 'css']);

        $backendDev = factory(User::class)->create(['name' => 'Mr Backend Developer']);
        $backendDev->skills()->attach($php);

        $fullStackDev = factory(User::class)->create(['name' => 'Mrs FullStack Developer']);
        $fullStackDev->skills()->attach([$php->id, $css->id]);

        $frontendDev = factory(User::class)->create(['name' => 'Miss Frontend Developer']);
        $frontendDev->skills()->attach($css);

        $response = $this->get("usuarios?skills[0]={$php->id}&skills[1]={$css->id}");

        $response->assertStatus(200);

        $response->assertSee('Mrs FullStack Developer')
            ->assertDontSee('Mr Backend Developer')
            ->assertDontSee('Miss Frontend Developer');
    }

    /** @test */
    function filter_users_created_from_date()
    {
        $newestUser = factory(User::class)->create([
            'name' => 'The Newest User',
            'created_at' => '2018-10-02 12:00:00',
        ]);

        $oldestUser = factory(User::class)->create([
            'name' => 'The Oldest User',
            'created_at' => '2018-09-29 12:00:00',
        ]);

        $newUser = factory(User::class)->create([
            'name' => 'The New User',
            'created_at' => '2018-10-01 00:00:00',
        ]);

        $oldUser = factory(User::class)->create([
            'name' => 'The Old User',
            'created_at' => '2018-09-30 23:59:59',
        ]);

        $response = $this->get('usuarios?from=01/10/2018');

        $response->assertOk();

        $response->assertSee('The Newest User')
            ->assertSee('The New User')
            ->assertDontSee('The Old User')
            ->assertDontSee('The Oldest User');
    }

    /** @test */
    function filter_users_created_to_date()
    {
        $newestUser = factory(User::class)->create([
            'name' => 'The Newest User',
            'created_at' => '2018-10-02 12:00:00',
        ]);

        $oldestUser = factory(User::class)->create([
            'name' => 'The Oldest User',
            'created_at' => '2018-09-29 12:00:00',
        ]);

        $newUser = factory(User::class)->create([
            'name' => 'The New User',
            'created_at' => '2018-10-01 00:00:00',
        ]);

        $oldUser = factory(User::class)->create([
            'name' => 'The Old User',
            'created_at' => '2018-09-30 23:59:59',
        ]);

        $response = $this->get('usuarios?to=30/09/2018');

        $response->assertOk();

        $response->assertSee('The Oldest User')
            ->assertSee('The Old User')
            ->assertDontSee('The Newest User')
            ->assertDontSee('The New User');
    }
}
