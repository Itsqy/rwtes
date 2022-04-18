<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\IPL; 
use App\Model\Year; 
use Validator;
use Response;
use App\Post;
use View;
use NotificationChannels\SMSGatewayMe\SMSGatewayMeChannel;
use NotificationChannels\SMSGatewayMe\SMSGatewayMeMessage;
use Illuminate\Notifications\Notification;

class IPLChartController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $year = Year::all();
    return view ('editor.ipl_chart.index', compact('year'));
  }

  public function view(Request $request)
  {
    $year = Year::all();
    return view ('editor.ipl_chart.view', compact('year'));
  }
 
}
