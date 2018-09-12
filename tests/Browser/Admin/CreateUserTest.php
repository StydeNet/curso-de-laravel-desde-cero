<?php

namespace Tests\Browser\Admin;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\{Profession, Skill, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_be_created()
    {
        $profession = factory(Profession::class)->create();
        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->browse(function (Browser $browser) use ($profession, $skillA, $skillB) {
            $browser->visit('usuarios/nuevo')
                ->type('name', 'Duilio')
                ->type('email', 'duilio@styde.net')
                ->type('password', 'laravel')
                ->type('bio', 'Programador')
                ->select('profession_id', $profession->id)
                ->type('twitter', 'https://twitter.com/sileence')
                ->check("skills[{$skillA->id}]")
                ->check("skills[{$skillB->id}]")
                ->radio('role', 'user')
                ->radio('state', 'active')
                ->press('Crear usuario')
                ->assertPathIs('/usuarios')
                ->assertSee('Duilio')
                ->assertSee('duilio@styde.net');
        });

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => 'laravel',
            'role' => 'user',
            'active' => true,
        ]);

        $user = User::findByEmail('duilio@styde.net');

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador',
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
    }
}
