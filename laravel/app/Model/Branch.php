<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
	use SoftDeletes;
	protected $table = 'branch';
	protected $dates = ['deleted_at']; 

	public function cashbond()
	{
		return $this->hasMany('App\Model\Cashbond', 'branch_id', 'id');
	}

	public function invoice()
	{
		return $this->hasMany('App\Model\Invoice', 'branch_id', 'id');
	}

	public function item_central()
	{
		return $this->hasMany('App\Model\ItemCentral', 'branch_id', 'id');
	}

	public function revenue()
	{
		return $this->hasMany('App\Model\ItemCentral', 'branch_id', 'id');
	}

}
