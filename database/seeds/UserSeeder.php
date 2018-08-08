<?php

use App\Skill;
use App\User;
use App\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professions = Profession::all();

        $skills = Skill::all();

        $user = factory(User::class)->create([
            'name' => 'Duilio Palacios',
            'email' => 'duilio@styde.net',
            'password' => bcrypt('laravel'),
            'role' => 'admin',
            'created_at' => now()->addDay(),
        ]);

        $user->profile()->create([
            'bio' => 'Programador, profesor, editor, escritor, social media manager',
            'profession_id' => $professions->firstWhere('title', 'Desarrollador back-end')->id,
        ]);

        factory(User::class, 999)->create()->each(function ($user) use ($professions, $skills) {
            $randomSkills = $skills->random(rand(0, 7));

            $user->skills()->attach($randomSkills);

            factory(\App\UserProfile::class)->create([
                'user_id' => $user->id,
                'profession_id' => rand(0, 2) ? $professions->random()->id : null,
            ]);
        });
    }
}
