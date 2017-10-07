<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dev extends Model
{
    protected $table = 'devs';
    public $timestamps = false;
    
    
    public function user()
    {
        return $this->belongsTo('App\User', 'dev_id', 'id');
    }
    
    public function project()
    {
        return $this->belongsToMany('App\Project', 'id', 'proj_id');
    }
    
    public function dtrs()
    {
        return $this->hasMany('App\Dtr', 'proj_devs_id', 'id');
    }
}
