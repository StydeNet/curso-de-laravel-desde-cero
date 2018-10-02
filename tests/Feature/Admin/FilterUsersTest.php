<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\{Skill, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function filter_users_by_state_active()
    {
        $activeUser = factory(User::class)->create();

        $inactiveUser = factory(User::class)->state('inactive')->create();

        $response = $this->get('/usuarios?state=active');

        $response->assertViewCollection('users')
            ->contains($activeUser)
            ->notContains($inactiveUser);
    }

    /** @test */
    function filter_users_by_state_inactive()
    {
        $activeUser = factory(User::class)->create();

        $inactiveUser = factory(User::class)->state('inactive')->create();

        $response = $this->get('usuarios?state=inactive');

        $response->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($inactiveUser)
            ->notContains($activeUser);
    }

    /** @test */
    function filter_users_by_role_admin()
    {
        $admin = factory(User::class)->create(['role' => 'admin']);

        $user = factory(User::class)->create(['role' => 'user']);

        $response = $this->get('/usuarios?role=admin');

        $response->assertViewCollection('users')
            ->contains($admin)
            ->notContains($user);
    }

    /** @test */
    function filter_users_by_role_user()
    {
        $admin = factory(User::class)->create(['role' => 'admin']);

        $user = factory(User::class)->create(['role' => 'user']);

        $response = $this->get('usuarios?role=user');

        $response->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($user)
            ->notContains($admin);
    }

    /** @test */
    function filter_users_by_skill()
    {
        $php = factory(Skill::class)->create(['name' => 'php']);
        $css = factory(Skill::class)->create(['name' => 'css']);

        $backendDev = factory(User::class)->create();
        $backendDev->skills()->attach($php);

        $fullStackDev = factory(User::class)->create();
        $fullStackDev->skills()->attach([$php->id, $css->id]);

        $frontendDev = factory(User::class)->create();
        $frontendDev->skills()->attach($css);

        $response = $this->get("usuarios?skills[0]={$php->id}&skills[1]={$css->id}");

        $response->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($fullStackDev)
            ->notContains($backendDev)
            ->notContains($frontendDev);
    }
}
