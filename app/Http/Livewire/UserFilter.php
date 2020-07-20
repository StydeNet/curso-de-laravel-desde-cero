<?php

namespace App\Http\Livewire;

use App\Skill;
use Livewire\Component;

class UserFilter extends Component
{
    public function render()
    {
        return view('users._livewire-filters', [
            'skillsList' => Skill::getList(),
        ]);
    }
}
