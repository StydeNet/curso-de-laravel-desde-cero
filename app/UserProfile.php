<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['bio', 'twitter', 'github', 'profession_id'];
}
