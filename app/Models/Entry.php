<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $hidden =  ['updated_at', 'created_at'];
    protected $appends = ['created_date'];
    public function getCreatedDateAttribute()
    {
        return $this->created_at;
    }
}
