<?php

namespace Database\Seeders;

use App\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::factory()->create(['name' => 'HTML']);
        Skill::factory()->create(['name' => 'CSS']);
        Skill::factory()->create(['name' => 'JS']);
        Skill::factory()->create(['name' => 'PHP']);
        Skill::factory()->create(['name' => 'SQL']);
        Skill::factory()->create(['name' => 'OOP']);
        Skill::factory()->create(['name' => 'TDD']);
    }
}
