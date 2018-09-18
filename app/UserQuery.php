<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Builder
{
    use FiltersQueries;

    public function findByEmail($email)
    {
        return static::where(compact('email'))->first();
    }

    protected function filterRules(): array
    {
        return [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user',
        ];
    }

    public function filterBySearch($search)
    {
        return $this->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhereHas('team', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
    }

    public function filterByState($state)
    {
        return $this->where('active', $state == 'active');
    }
}
