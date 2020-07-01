<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UsersList extends Component
{
    /**
     * @var mixed
     */
    protected $view;
    /**
     * @var mixed
     */
    protected $users;
    /**
     * @var mixed
     */
    protected $skills;
    /**
     * @var mixed
     */
    protected $checkedSkills;
    /**
     * @var mixed
     */
    protected $sortable;

    public function mount($view, $users, $skills, $checkedSkills, $sortable)
    {
        $this->view = $view;
        $this->users = $users;
        $this->skills = $skills;
        $this->checkedSkills = $checkedSkills;
        $this->sortable = $sortable;
    }

    public function render()
    {
        return view('users._livewire-list', [
            'view' => $this->view,
            'users' => $this->users,
            'skills' => $this->skills,
            'checkedSkills' => $this->checkedSkills,
            'sortable' => $this->sortable,
        ]);
    }
}
