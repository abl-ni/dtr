<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dtr extends Model
{
    protected $table = 'dtrs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'proj_devs_id', 'task_title', 'ticket_no', 'roadblock', 'hours_rendered', 'overtime?', 'date_created'
    ];

    public $timestamps = false;
    
    public function dev()
    {
        return $this->belongsToMany('App\Dev', 'id', 'proj_devs_id');
    }
}

