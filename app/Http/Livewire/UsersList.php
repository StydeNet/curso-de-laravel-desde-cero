<?php

namespace App\Http\Livewire;

use App\Skill;
use App\Sortable;
use App\User;
use Livewire\Component;

class UsersList extends Component
{
    /**
     * @var mixed
     */
    protected $view;

    public function mount($view)
    {
        $this->view = $view;
    }

    public function hydrate()
    {
    }

    protected function getUsers(Sortable $sortable)
    {
        $users = User::query()
            ->with('team', 'skills', 'profile.profession')
            ->withLastLogin()
            ->onlyTrashedIf(request()->routeIs('users.trashed'))
            ->applyFilters()
            ->orderByDesc('created_at')
            ->paginate();

        $sortable->appends($users->parameters());

        return $users;
    }

    public function render()
    {
        $sortable = new Sortable(request()->url());

        $this->view = 'index';

        return view('users._livewire-list', [
            'view' => $this->view,
            'users' => $this->getUsers($sortable),
            'skills' => Skill::getList(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }
}
