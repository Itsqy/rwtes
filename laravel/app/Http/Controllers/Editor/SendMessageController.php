<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\IPL; 
use Validator;
use Response;
use App\Post;
use View;
use NotificationChannels\SMSGatewayMe\SMSGatewayMeChannel;
use NotificationChannels\SMSGatewayMe\SMSGatewayMeMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;
use App\Model\SMSTemplate; 
use App\Model\SMSHistory; 

class SendMessageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.send_message.index');
  }

  public function store(Request $request)
  {
    $now = Carbon::now();
    $month = $now->format('m');
    $year = $now->format('Y');

    $tunggakan = $request->input('tunggakan'); 
    $sms_template = SMSTemplate::where('id', $tunggakan)->first();

    if($tunggakan < 4)
    {
      $sql = 'SELECT 
              family_cards.id, 
              family_cards.`name`,
              rts.rt_name,
              family_cards.ipl_tarif AS ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip,
              COUNT(ipl.period_id) AS count_id,
              CONCAT(COUNT(ipl.period_id), " Bulan") AS tunggakan,
              SUM(family_cards.ipl_tarif) AS total_tarif_ipl
            FROM
              ipl
            LEFT JOIN ipl_period ON ipl.period_id = ipl_period.id
            LEFT JOIN family_cards ON ipl.family_card_id = family_cards.id
            LEFT JOIN rts ON family_cards.rt_id = rts.id
            WHERE ipl.`status` = 0
            AND ipl.month <= '.$month.' AND ipl.year = '.$year.' AND family_cards.hp != ""
            GROUP BY   
              family_cards.`name`,
              rts.rt_name,
              family_cards.ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip
            HAVING COUNT(ipl.period_id) = '.$tunggakan.'';
    }else{
      $sql = 'SELECT 
              family_cards.id, 
              family_cards.`name`,
              rts.rt_name,
              family_cards.ipl_tarif AS ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip,
              COUNT(ipl.period_id) AS count_id,
              CONCAT(COUNT(ipl.period_id), " Bulan") AS tunggakan,
              SUM(family_cards.ipl_tarif) AS total_tarif_ipl
            FROM
              ipl
            LEFT JOIN ipl_period ON ipl.period_id = ipl_period.id
            LEFT JOIN family_cards ON ipl.family_card_id = family_cards.id
            LEFT JOIN rts ON family_cards.rt_id = rts.id
            WHERE ipl.`status` = 0
            AND ipl.month <= '.$month.' AND ipl.year = '.$year.' AND family_cards.hp != ""
            GROUP BY   
              family_cards.`name`,
              rts.rt_name,
              family_cards.ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip
            HAVING COUNT(ipl.period_id) > 3';
    };
    
    $data_ipl = DB::table(DB::raw("($sql) as rs_sql"))->get();

    foreach($data_ipl as $data_ipls)
    {

          $post = new SMSHistory;
          $post->ipl_id = $data_ipls->ipl_id;
          $post->family_name = $data_ipls->name;
          $post->description = $sms_template->description;
          $post->save();
    };

    return redirect()->action('Editor\SendMessageController@history');

  }


  public function history()
  {
    return view ('editor.send_message.history');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $sms_history = SMSHistory::orderBy('id', 'DESC')->get();

      return Datatables::of($sms_history)  
      ->make(true);
    } else {
      exit("No data available");
    }
  }
 
}
