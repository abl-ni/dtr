<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dtr_id', 'overtime', 'message', 'status', 'user_id', 'requested_by', 'approved_by', 'notification_type'
    ];

    public $timestamps = true;

    public function requested_by()
    {
        return $this->hasOne('App\User', 'id', 'requested_by');
    }    

    public function approved_by()
    {
        return $this->hasOne('App\User', 'id', 'approved_by');
    }

    public function dtrs()
    {
        return $this->hasOne('App\Dtr');
    }
}
