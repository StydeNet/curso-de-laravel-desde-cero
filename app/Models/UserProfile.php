<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    public function profession()
    {
        return $this->belongsTo(Profession::class)->withDefault([
            'title' => '(Sin profesión)'
        ]);
    }
}
