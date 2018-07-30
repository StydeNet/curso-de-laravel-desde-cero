<?php

namespace App\Http\Controllers;

use App\Skill;

class SkillController extends Controller
{
    public function index()
    {
        return view('skills.index', [
            'skills' => Skill::orderBy('name')->get(),
        ]);
    }
}
