<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::create([
            'title' => 'Backend Developer',
        ]);

        Profession::create([
            'title' => 'Frontend Developer',
        ]);

        Profession::create([
            'title' => 'Web Designer',
        ]);
    }
}
