<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $table = 'module';
    protected $dates = ['deleted_at'];

    public function privilege()
    {
    	return $this->hasMany('App\Model\Privilege', 'module_id', 'id');
    }
}
