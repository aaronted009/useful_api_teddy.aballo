<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The users that have the module.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
