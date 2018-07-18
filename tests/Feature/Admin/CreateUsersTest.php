<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\{Profession, Skill, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Duilio',
        'email' => 'duilio@styde.net',
        'password' => '123456',
        'bio' => 'Programador de Laravel y Vue.js',
        'profession_id' => '',
        'twitter' => 'https://twitter.com/sileence',
        'role' => 'user',
    ];

    /** @test */
    function it_loads_the_new_users_page()
    {
        $profession = factory(Profession::class)->create();

        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear usuario');
    }

    /** @test */
    function it_creates_a_new_user()
    {
        $profession = factory(Profession::class)->create();

        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();
        $skillC = factory(Skill::class)->create();

        $this->post('/usuarios/', $this->withData([
            'skills' => [$skillA->id, $skillB->id],
            'profession_id' => $profession->id,
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456',
            'role' => 'user',
        ]);

        $user = User::findByEmail('duilio@styde.net');

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
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
        $this->post('/usuarios/', $this->withData([
            'twitter' => null,
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => null,
            'user_id' => User::findByEmail('duilio@styde.net')->id,
        ]);
    }

    /** @test */
    function the_role_field_is_optional()
    {
        $this->post('/usuarios/', $this->withData([
            'role' => null,
        ]))->assertRedirect('usuarios');

        $this->assertDatabaseHas('users', [
            'email' => 'duilio@styde.net',
            'role' => 'user',
        ]);
    }

    /** @test */
    function the_role_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
            'role' => 'invalid-role',
        ]))->assertSessionHasErrors('role');

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_profession_id_field_is_optional()
    {
        $this->post('/usuarios/', $this->withData([
            'profession_id' => '',
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
            'user_id' => User::findByEmail('duilio@styde.net')->id,
            'profession_id' => null,
        ]);
    }

    /** @test */
    function the_user_is_redirected_to_the_previous_page_when_the_validation_fails()
    {
        $this->handleValidationExceptions();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [])
            ->assertRedirect('usuarios/nuevo');

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_name_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
                'name' => '',
            ]))
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_email_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
                'email' => '',
            ]))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
                'email' => 'correo-no-valido',
            ]))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_email_must_be_unique()
    {
        $this->handleValidationExceptions();

        factory(User::class)->create([
            'email' => 'duilio@styde.net'
        ]);

        $this->post('/usuarios/', $this->withData([
                'email' => 'duilio@styde.net',
            ]))
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(1, User::count());
    }

    /** @test */
    function the_password_is_required()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
                'password' => '',
            ]))
            ->assertSessionHasErrors(['password']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_profession_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
                'profession_id' => '999'
            ]))
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function only_not_deleted_professions_can_be_selected()
    {
        $deletedProfession = factory(Profession::class)->create([
            'deleted_at' => now()->format('Y-m-d'),
        ]);

        $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
                'profession_id' => $deletedProfession->id,
            ]))
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_skills_must_be_an_array()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
                'skills' => 'PHP, JS'
            ]))
            ->assertSessionHasErrors(['skills']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_skills_must_be_valid()
    {
        $this->handleValidationExceptions();

        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->post('/usuarios/', $this->withData([
                'skills' => [$skillA->id, $skillB->id + 1],
            ]))
            ->assertSessionHasErrors(['skills']);

        $this->assertDatabaseEmpty('users');
    }
}
