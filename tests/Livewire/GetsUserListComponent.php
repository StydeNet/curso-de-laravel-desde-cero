<?php

namespace Tests\Livewire;

use App\Http\Livewire\UserList;
use Illuminate\Http\Request;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;

trait GetsUserListComponent
{
    protected function getUserListComponent(array $query = []): TestableLivewire
    {
        $request = new Request($query);

        return Livewire::test(UserList::class, ['view' => 'index', 'request' => $request]);
    }
}
