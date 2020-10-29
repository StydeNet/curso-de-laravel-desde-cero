<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'users',
            'user_profiles',
            'user_skill',
            'skills',
            'professions',
            'teams',
        ]);

        $this->call([
            ProfessionSeeder::class,
            SkillSeeder::class,
            TeamSeeder::class,
            UserSeeder::class,
        ]);
    }

    protected function truncateTables(array $tables)
    {
        Schema::disableForeignKeyConstraints();

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }
}
