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

        User::create([
            'name' => 'Duilio Palacios',
            'email' => 'duilio@styde.net',
            'password' => bcrypt('laravel'),
            'profession_id' => $professionId,
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Another User',
            'email' => 'another@user.com',
            'password' => bcrypt('laravel'),
            'profession_id' => $professionId
        ]);

        User::create([
            'name' => 'Another User',
            'email' => 'another2@user.com',
            'password' => bcrypt('laravel'),
            'profession_id' => null
        ]);
    }
}
