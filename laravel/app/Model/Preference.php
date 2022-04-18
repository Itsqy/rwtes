<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preference extends Model
{
	use SoftDeletes;
	protected $table = 'preference';
	protected $dates = ['deleted_at'];  

}
