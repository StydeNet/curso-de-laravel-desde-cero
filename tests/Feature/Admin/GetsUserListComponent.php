<?php

namespace Tests\Feature\Admin;

use App\Http\Livewire\UsersList;
use Illuminate\Http\Request;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;

trait GetsUserListComponent
{
    protected function getUserListComponent(array $query = []): TestableLivewire
    {
        $request = new Request($query);

        return Livewire::test(UsersList::class, ['view' => 'index', 'request' => $request]);
    }
}
