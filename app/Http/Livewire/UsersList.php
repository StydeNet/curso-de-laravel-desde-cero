<?php

namespace App\Http\Livewire;

use App\Skill;
use App\Sortable;
use App\User;
use Illuminate\Http\Request;
use Livewire\Component;

class UsersList extends Component
{
    /**
     * @var mixed
     */
    public $view;
    /**
     * @var mixed|string
     */
    public $currentUrl;

    public $search;

    public $state;

    public $role;

    public $skills;

    protected $updatesQueryString = [
        'search' => ['except' => ''],
        'state' => ['except' => 'all'],
        'role' => ['except' => 'all'],
        'skills' => [],
    ];

    public function mount($view, Request $request)
    {
        $this->view = $view;

        $this->currentUrl = $request->url();

        $this->search = $request->input('search');

        $this->state = $request->input('state');

        $this->role = $request->input('role');

        $this->skills = is_array($request->input('skills')) ? $request->input('skills') : [];
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
            ->applyFilters([
                'search' => $this->search,
                'state' => $this->state,
                'role' => $this->role,
                'skills' => $this->skills,
                'from' => request()->input('from'),
                'to' => request()->input('to'),
                'order' => request()->input('order'),
            ])
            ->orderByDesc('created_at')
            ->paginate();

        $sortable->appends($users->parameters());

        return $users;
    }

    public function render()
    {
        $sortable = new Sortable($this->currentUrl);

        return view('users._livewire-list', [
            'users' => $this->getUsers($sortable),
            'skillsList' => Skill::getList(),
            'sortable' => $sortable,
        ]);
    }
}
