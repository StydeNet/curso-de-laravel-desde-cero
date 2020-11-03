<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
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
        User::factory()->create();

        $newProfession = Profession::factory()->create();

        //$this->actingAs($user);

        $response = $this->get('/edit-profile/');

        $response->assertStatus(200);

        $response = $this->put('/edit-profile/', [
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

        $response = $this->put('/edit-profile/', $this->withData([
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

        $response = $this->put('/edit-profile/', $this->withData([
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
