<?php

namespace App\Http\Livewire;

use App\Rules\SortableColumn;
use App\Skill;
use App\Sortable;
use App\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Sortable
     */
    private $sortable;

    public $state;
    public $isTrashed;
    public $search;
    public $role;
    public $skills;
    public $from;
    public $to;
    public $currentUrl;
    public $order;

// This doesn't work, should it work?
//    protected $casts = [
//        'skills' => 'array',
//    ];

    protected $updatesQueryString = [
        'search' => ['except' => ''],
        'state' => ['except' => 'all'],
        'skills' => ['except' => []],
        'from' => ['except' => ''],
        'to' => ['except' => ''],
    ];

    public function mount(Request $request)
    {
        $this->request = $request;

        $this->currentUrl = $this->request->url();

        $this->state = $this->request->input('state');

        $this->search = $this->request->input('search');

        $this->isTrashed = $this->request->routeIs('users.trashed');

        $this->role = $this->request->input('role');

        $this->from = $request->input('from');

        $this->to = $request->input('to');

        $this->skills = $this->request->input('skills');

        // :(
        if (! is_array($this->skills)) {
            $this->skills = [];
        }

        $this->order = $this->request->input('order');

        $this->initSortable();
    }

    public function hydrate()
    {
        $this->initSortable();
    }

    public function updating($field)
    {
        $this->resetPage();
    }

    public function changeOrder($column)
    {
        $this->order = $this->sortable->column($column);
    }

    private function getUsers()
    {
        $users = User::query()
            ->with('team', 'skills', 'profile.profession')
            ->withLastLogin()
            ->onlyTrashedIf($this->isTrashed)
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

        $this->sortable->appends($users->parameters());

        return $users;
    }

    public function render()
    {
        return view('users._livewire-table', [
            'view' => $this->isTrashed ? 'trash' : 'index',
            'users' => $this->getUsers(),
            'skillsList' => Skill::orderBy('name')->get(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $this->sortable,
        ]);
    }

    protected function initSortable(): void
    {
        $this->sortable = new Sortable($this->currentUrl);
    }
}
