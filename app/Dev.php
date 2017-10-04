<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dev extends Model
{
    protected $table = 'devs';
    public $timestamps = false;
    
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'dev_id');
    }
    
    public function project()
    {
        return $this->belongsTo('App\Project', 'id', 'proj_id');
    }
    
    public function dtr()
    {
        return $this->hasMany('App\Dtr', 'proj_devs_id', 'id');
    }
}
