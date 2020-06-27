<?php

namespace App\Http\Controllers;

use App\Profession;
use App\Skill;
use App\Sortable;
use App\User;
use App\UserFilter;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('users.index', [
            'view' => $request->routeIs('users.trashed') ? 'trash' : 'index',
        ]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return $this->form('users.create', new User);
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return $this->form('users.edit', $user);
    }

    protected function form($view, User $user)
    {
        return view($view, [
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->route('users.show', ['user' => $user]);
    }

    public function trash(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();

        $user->forceDelete();

        return redirect()->route('users.trashed');
    }
}
