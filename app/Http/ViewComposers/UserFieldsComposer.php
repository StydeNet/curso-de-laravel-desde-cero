<?php

namespace App\Http\ViewComposers;

use App\Skill;
use App\Profession;
use Illuminate\Contracts\View\View;

class UserFieldsComposer
{
    public function compose(View $view)
    {
        $professions = Profession::orderBy('title', 'ASC')->get();
        $skills = Skill::orderBy('name', 'ASC')->get();
        $roles = trans('users.roles');

        $view->with(compact('professions', 'skills', 'roles'));
    }
}