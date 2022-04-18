<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    //
	protected $table = 'users_roles';
    protected $dates = ['deleted_at'];

    public function user()
    {
    	return $this->hasOne('App\Model\User', 'id', 'user_id');
    }

    public function role()
    {
    	return $this->hasOne('App\Model\Role', 'id', 'role_id');
    }
}
