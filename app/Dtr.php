<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dtr extends Model
{
    protected $table = 'dtrs';
    public $timestamps = false;
    
    public function dev()
    {
        return $this->belongsToMany('App\Dev', 'id', 'proj_devs_id');
    }
}

