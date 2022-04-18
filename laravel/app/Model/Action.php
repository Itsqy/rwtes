<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use SoftDeletes;

    protected $table = 'action';
    protected $dates = ['deleted_at'];

    public function privilege()
    {
    	return $this->hasMany('App\Model\Privilege', 'action_id', 'id');
    }
}
