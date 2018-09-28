<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Builder
{
    public function findByEmail($email)
    {
        return $this->where(compact('email'))->first();
    }
}
