<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    public $timestamps = false;
    
    public function PM()
    {
        return $this->hasOne('App\User', 'id', 'pm_id');
    }
    
    public function TL()
    {
        return $this->hasOne('App\User', 'id', 'tl_id');
    }
    
    public function dev()
    {
        return $this->hasMany('App\Dev', 'proj_id', 'id');
    }
}
