<?php

namespace Database\Seeders;

use App\Models\Login;
use App\Models\Skill;
use App\Models\Team;
use App\Models\User;
use App\Models\Profession;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    protected $professions;
    protected $skills;
    protected $teams;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fetchRelations();

        $this->createAdmin();

        $this->createRandomUser([
            'api_token' => 'user-api-token',
        ]);

        foreach(range(1, 99) as $i) {
            $this->createRandomUser();
        }
    }

    protected function fetchRelations()
    {
        $this->professions = Profession::all();

        $this->skills = Skill::all();

        $this->teams = Team::all();
    }

    protected function createAdmin()
    {
        $admin = User::factory()->create([
            'team_id' => $this->teams->firstWhere('name', 'Styde'),
            'name' => 'Duilio Palacios',
            'email' => 'duilio@styde.net',
            'password' => bcrypt('laravel'),
            'role' => 'admin',
            'created_at' => now(),
            'active' => true,
            'api_token' => 'admin-api-token',
        ]);

        $admin->skills()->attach($this->skills);

        $admin->profile->update([
            'bio' => 'Programador, profesor, editor, escritor, social media manager',
            'profession_id' => $this->professions->firstWhere('title', 'Desarrollador back-end')->id,
        ]);
    }

    protected function createRandomUser(array $customAttributes = [])
    {
        $user = User::factory()->create(array_merge([
            'team_id' => rand(0, 2) ? null : $this->teams->random()->id,
            'active' => rand(0, 3) ? true : false,
            'created_at' => now()->subDays(rand(1, 90)),
        ], $customAttributes));

        $user->skills()->attach($this->skills->random(rand(0, 7)));

        $user->profile->update([
            'profession_id' => rand(0, 2) ? $this->professions->random()->id : null,
        ]);

        Login::factory()->times(rand(1, 10))->create([
            'user_id' => $user->id,
        ]);
    }
}
