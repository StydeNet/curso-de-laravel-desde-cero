<?php

namespace App\Http\Livewire;

use App\Sortable;
use App\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $view;

    public $originalUrl;

    public $search;

    public $state;

    public $role;

    public $skills = [];

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

    protected $listeners = [
        'refreshUserList' => 'refreshList',
    ];

    public function mount($view, Request $request)
    {
        $this->fill([
            'view' => $view,
            'originalUrl' => $request->url(),
            'search' => $request->input('search'),
            'state' => $request->input('state'),
            'role' => $request->input('role'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'order' => $request->input('order'),
            'skills' => $this->normalizeSkills($request->input('skills')),
            'page' => $request->input('page'), // <-- This is required for testing purposes!
        ]);
    }

    protected function normalizeSkills($skills)
    {
        if (is_array($skills)) {
            return array_combine($skills, $skills);
        } else {
            return [];
        }
    }

    public function refreshList($field, $value, $checked = true)
    {
        if (in_array($field, ['search', 'state', 'role', 'from', 'to'])) {
            $this->fill([$field => $value]);
        }

        if ($field === 'skills') {
            $this->toggleSkill($value, $checked);
        }
    }

    protected function toggleSkill($value, bool $checked): void
    {
        if ($checked) {
            $this->skills[$value] = $value;
        } else {
            unset($this->skills[$value]);
        }
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
            'sortable' => $sortable,
        ]);
    }
}
