<?php

namespace App\Repositories;

use App\User;

class UserEloquentRepository implements UserRepository
{
    public function create($name, $email, $password)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
