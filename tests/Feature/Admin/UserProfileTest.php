<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Profession;
use App\User;
use App\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Duilio',
        'email' => 'duilio@styde.net',
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/sileence',
    ];

    /** @test */
    function a_user_can_edit_its_profile()
    {
        $user = User::factory()->create();

        $newProfession = Profession::factory()->create();

        //$this->actingAs($user);

        $response = $this->get('/editar-perfil/');

        $response->assertStatus(200);

        $response = $this->put('/editar-perfil/', [
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/sileence',
            'profession_id' => $newProfession->id,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/sileence',
            'profession_id' => $newProfession->id,
        ]);
    }

    /** @test */
    function the_user_cannot_change_its_role()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->put('/editar-perfil/', $this->withData([
            'role' => 'admin',
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'user',
        ]);
    }

    /** @test */
    function the_user_cannot_change_its_password()
    {
        User::factory()->create([
            'password' => bcrypt('old123'),
        ]);

        $response = $this->put('/editar-perfil/', $this->withData([
            'email' => 'duilio@styde.net',
            'password' => 'new456'
        ]));

        $response->assertRedirect();

        $this->assertCredentials([
            'email' => 'duilio@styde.net',
            'password' => 'old123',
        ]);
    }
}
