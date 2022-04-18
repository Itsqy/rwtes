<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Privilege extends Model
{
    use SoftDeletes;

    protected $table = 'privilege';
    protected $dates = ['deleted_at'];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function module()
    {
    	return $this->belongsTo('App\Model\Module', 'module_id', 'id');
    }

    public function action()
    {
    	return $this->belongsTo('App\Model\Action', 'action_id', 'id');
    }
}
