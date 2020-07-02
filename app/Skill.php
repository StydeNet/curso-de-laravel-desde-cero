<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public static function getList()
    {
        return static::query()->orderBy('name')->get();
    }
}
