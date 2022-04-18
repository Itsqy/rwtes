<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use App\Model\Shift;

class XHRController extends Controller
{ 
	public function shift_schedule(Request $request, $id)
    {
        $shift = Shift::Where('id', '1')->get();
        $shift_schedule = $shift; 
        return $shift_schedule;
    }
}