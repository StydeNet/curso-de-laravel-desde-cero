<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @title Filter the users by state active
     * @description This will allow users to filter other users in the system by active state.
     */
    function filter_users_by_state_active()
    {
        $activeUser = User::factory()->create();

        $inactiveUser = User::factory()->inactive()->create();

        $response = $this->get('/users?state=active');

        $response->assertViewCollection('users')
            ->contains($activeUser)
            ->notContains($inactiveUser);
    }

    /** @test */
    function filter_users_by_state_inactive()
    {
        $activeUser = User::factory()->create();

        $inactiveUser = User::factory()->inactive()->create();

        $response = $this->get('users?state=inactive');

        $response->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($inactiveUser)
            ->notContains($activeUser);
    }

    /** @test */
    function filter_users_by_role_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $user = User::factory()->create(['role' => 'user']);

        $response = $this->get('/users?role=admin');

        $response->assertViewCollection('users')
            ->contains($admin)
            ->notContains($user);
    }

    /** @test */
    function filter_users_by_role_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $user = User::factory()->create(['role' => 'user']);

        $response = $this->get('users?role=user');

        $response->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($user)
            ->notContains($admin);
    }

    /** @test */
    function filter_users_by_skill()
    {
        $php = Skill::factory()->create(['name' => 'php']);
        $css = Skill::factory()->create(['name' => 'css']);

        $backendDev = User::factory()->create();
        $backendDev->skills()->attach($php);

        $fullStackDev = User::factory()->create();
        $fullStackDev->skills()->attach([$php->id, $css->id]);

        $frontendDev = User::factory()->create();
        $frontendDev->skills()->attach($css);

        $response = $this->get("users?skills[0]={$php->id}&skills[1]={$css->id}");

        $response->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($fullStackDev)
            ->notContains($backendDev)
            ->notContains($frontendDev);
    }

    /** @test */
    function filter_users_created_from_date()
    {
        $newestUser = User::factory()->create([
            'created_at' => '2018-10-02 12:00:00',
        ]);

        $oldestUser = User::factory()->create([
            'created_at' => '2018-09-29 12:00:00',
        ]);

        $newUser = User::factory()->create([
            'created_at' => '2018-10-01 00:00:00',
        ]);

        $oldUser = User::factory()->create([
            'created_at' => '2018-09-30 23:59:59',
        ]);

        $response = $this->get('users?from=01/10/2018');

        $response->assertOk();

        $response->assertViewCollection('users')
            ->contains($newUser)
            ->contains($newestUser)
            ->notContains($oldUser)
            ->notContains($oldestUser);
    }

    /** @test */
    function filter_users_created_to_date()
    {
        $newestUser = User::factory()->create([
            'created_at' => '2018-10-02 12:00:00',
        ]);

        $oldestUser = User::factory()->create([
            'created_at' => '2018-09-29 12:00:00',
        ]);

        $newUser = User::factory()->create([
            'created_at' => '2018-10-01 00:00:00',
        ]);

        $oldUser = User::factory()->create([
            'created_at' => '2018-09-30 23:59:59',
        ]);

        $response = $this->get('users?to=30/09/2018');

        $response->assertOk();

        $response->assertViewCollection('users')
            ->contains($oldestUser)
            ->contains($oldUser)
            ->notContains($newestUser)
            ->notContains($newUser);
    }
}
