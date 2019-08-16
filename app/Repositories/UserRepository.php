<?php

namespace App\Repositories;

interface UserRepository
{
    public function create($name, $email, $password);
}
