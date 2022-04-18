<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //
    protected $dates = ['deleted_at'];
    
    public function user_role()
    {
    	return $this->hasMany('App\Model\UserRole', 'role_id', 'id');
    }
}
