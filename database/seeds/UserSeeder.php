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
            'is_admin' => true,
        ]);

        $user->profile()->create([
            'bio' => 'Programador, profesor, editor, escritor, social media manager',
            'profession_id' => $professionId,
        ]);

        factory(User::class, 29)->create()->each(function ($user) {
            $user->profile()->create(
                factory(\App\UserProfile::class)->raw()
            );
        });
    }
}
