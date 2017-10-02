<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dtr extends Model
{
    protected $table = 'dtrs';
    
    public function dev()
    {
        return $this->hasOne('App\Dev', 'id', 'proj_devs_id');
    }
}

