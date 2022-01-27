<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
