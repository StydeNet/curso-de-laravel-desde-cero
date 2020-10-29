<?php

namespace Tests\Feature\Admin;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;
use App\Models\Profession;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Duilio',
        'email' => 'duilio@styde.net',
        'password' => '123456',
        'bio' => 'Laravel Developer',
        'profession_id' => '',
        'twitter' => 'https://twitter.com/sileence',
        'role' => 'user',
        'state' => 'active',
    ];

    /**
     * @test
     * @enlighten {"exclude": true}
     */
    function it_loads_the_new_users_page()
    {
        $profession = Profession::factory()->create();

        $skillA = Skill::factory()->create();
        $skillB = Skill::factory()->create();

        $this->get('/users/create')
            ->assertStatus(200)
            ->assertSee('Create User')
            ->assertViewHas('professions', function ($professions) use ($profession) {
                return $professions->contains($profession);
            })
            ->assertViewHas('skills', function ($skills) use ($skillA, $skillB) {
                return $skills->contains($skillA) && $skills->contains($skillB);
            });
    }

    /** @test */
    function it_displays_validation_errors_in_the_new_user_form()
    {
        $profession = Profession::factory()->create();

        $skillA = Skill::factory()->create();
        $skillB = Skill::factory()->create();

        $this->withSession([
                'errors' => (new ViewErrorBag)
                    ->put('default', new MessageBag([
                        'email' => ['The field email must be unique'],
                    ])),
            ])
            ->get('/users/create')
            ->assertStatus(200)
            ->assertSeeText('Create User')
            ->assertSeeText('The field email must be unique');
    }

    /** @test */
    function it_creates_a_new_user()
    {
        $profession = Profession::factory()->create();

        $skillA = Skill::factory()->create();
        $skillB = Skill::factory()->create();
        $skillC = Skill::factory()->create();

        $this->post('/users/', $this->withData([
            'skills' => [$skillA->id, $skillB->id],
            'profession_id' => $profession->id,
        ]))->assertRedirect('users');

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456',
            'role' => 'user',
            'active' => true,
        ]);

        $user = User::findByEmail('duilio@styde.net');

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Laravel Developer',
            'twitter' => 'https://twitter.com/sileence',
            'user_id' => $user->id,
            'profession_id' => $profession->id,
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillA->id,
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillB->id,
        ]);

        $this->assertDatabaseMissing('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillC->id,
        ]);
    }

    /** @test */
    function the_twitter_field_is_optional()
    {
        $this->post('/users/', $this->withData([
            'twitter' => null,
        ]))->assertRedirect('users');

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Laravel Developer',
            'twitter' => null,
            'user_id' => User::findByEmail('duilio@styde.net')->id,
        ]);
    }

    /** @test */
    function the_role_field_is_optional()
    {
        $this->post('/users/', $this->withData([
            'role' => null,
        ]))->assertRedirect('users');

        $this->assertDatabaseHas('users', [
            'email' => 'duilio@styde.net',
            'role' => 'user',
        ]);
    }

    /** @test */
    function the_role_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
            'role' => 'invalid-role',
        ]))->assertSessionHasErrors('role');

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_profession_id_field_is_optional()
    {
        $this->post('/users/', $this->withData([
            'profession_id' => '',
        ]))->assertRedirect('users');

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Laravel Developer',
            'user_id' => User::findByEmail('duilio@styde.net')->id,
            'profession_id' => null,
        ]);
    }

    /** @test */
    function the_user_is_redirected_to_the_previous_page_when_the_validation_fails()
    {
        $this->handleValidationExceptions();

        $this->from('users/create')
            ->post('/users/', [])
            ->assertRedirect('users/create');

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_name_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
                'name' => '',
            ]))
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_email_is_required()
    {
        $this->handleValidationExceptions();

        $this->from('users/create')
            ->post('/users/', $this->withData([
                'email' => '',
            ]))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
                'email' => 'correo-no-valido',
            ]))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_email_must_be_unique()
    {
        $this->handleValidationExceptions();

        User::factory()->create([
            'email' => 'duilio@styde.net'
        ]);

        $this->post('/users/', $this->withData([
                'email' => 'duilio@styde.net',
            ]))
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(1, User::count());
    }

    /** @test */
    function the_password_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
                'password' => '',
            ]))
            ->assertSessionHasErrors(['password']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_profession_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
                'profession_id' => '999'
            ]))
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function only_not_deleted_professions_can_be_selected()
    {
        $deletedProfession = Profession::factory()->create([
            'deleted_at' => now()->format('Y-m-d'),
        ]);

        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
                'profession_id' => $deletedProfession->id,
            ]))
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_skills_must_be_an_array()
    {
        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
                'skills' => 'PHP, JS'
            ]))
            ->assertSessionHasErrors(['skills']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_skills_must_be_valid()
    {
        $this->handleValidationExceptions();

        $skillA = Skill::factory()->create();
        $skillB = Skill::factory()->create();

        $this->post('/users/', $this->withData([
                'skills' => [$skillA->id, $skillB->id + 1],
            ]))
            ->assertSessionHasErrors(['skills']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_state_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
            'state' => null,
        ]))->assertSessionHasErrors('state');

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_state_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/users/', $this->withData([
            'state' => 'invalid-state',
        ]))->assertSessionHasErrors('state');

        $this->assertDatabaseEmpty('users');
    }
}
