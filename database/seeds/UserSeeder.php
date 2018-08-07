<?php

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
        //$professions = DB::select('SELECT id FROM professions WHERE title = ?', ['Desarrollador back-end']);

        $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');

        $user = factory(User::class)->create([
            'name' => 'Duilio Palacios',
            'email' => 'duilio@styde.net',
            'password' => bcrypt('laravel'),
            'role' => 'admin',
        ]);

        $user->profile()->create([
            'bio' => 'Programador, profesor, editor, escritor, social media manager',
            'profession_id' => $professionId,
        ]);

        factory(User::class, 999)->create()->each(function ($user) {
            factory(\App\UserProfile::class)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
