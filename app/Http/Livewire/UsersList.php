<?php

namespace App\Http\Livewire;

use App\Skill;
use App\Sortable;
use App\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public $view;

    public $originalUrl;

    public $search;

    public $state;

    public $role;

    public $skills;

    public $from;

    public $to;

    public $order;

    protected $updatesQueryString = [
        'search' => ['except' => ''],
        'state' => ['except' => 'all'],
        'role' => ['except' => 'all'],
        'skills' => [],
        'from' => ['except' => ''],
        'to' => ['except' => ''],
        'order' => ['except' => ''],
    ];

    public function mount($view, Request $request)
    {
        $this->view = $view;

        $this->originalUrl = $request->url();

        $this->search = $request->input('search');

        $this->state = $request->input('state');

        $this->role = $request->input('role');

        $this->skills = is_array($request->input('skills')) ? $request->input('skills') : [];

        $this->from = $request->input('from');

        $this->to = $request->input('to');

        $this->order = $request->input('order');

        $this->page = $request->input('page', 1);
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function changeOrder($order)
    {
        $this->order = $order;
        $this->resetPage();
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
                'from' => $this->from,
                'to' => $this->to,
                'order' => $this->order,
            ])
            ->orderByDesc('created_at')
            ->paginate();

        $sortable->appends($users->parameters());

        return $users;
    }

    public function render()
    {
        $sortable = new Sortable($this->originalUrl);

        return view('users._livewire-list', [
            'users' => $this->getUsers($sortable),
            'skillsList' => Skill::getList(),
            'sortable' => $sortable,
        ]);
    }
}
