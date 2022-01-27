<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'companies';

    public static function get_field($field)
    {
        return self::select($field)->get();
    }
}
