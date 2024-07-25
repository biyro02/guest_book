<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property $created_date
 */
class User extends Authenticatable
{
    use HasFactory;

    protected $hidden =  ['updated_at', 'created_at'];
    protected $appends = ['created_date'];
    public function getCreatedDateAttribute()
    {
        return $this->created_at;
    }
}
