<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\IPL; 
use Carbon\Carbon;
use Validator;
use Response;
use App\Post;
use View;

class DataIPLArrearsController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'image' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.data_ipl_arrears.index');
  }

  public function data(Request $request)
  {   
    $now = Carbon::now();
    $month = $now->format('m');
    $year = $now->format('Y');

    if($request->ajax()){ 

      $sql = 'SELECT
                family_cards.id,
                family_cards.`name`,
                rts.rt_name,
                family_cards.ipl_id,
                family_cards.block,
                family_cards.hp,
                family_cards.`no`,
                family_cards.nip,
                payment_types.payment_type_name,
                ipl_payments.transaction_no,
                ipl_payments.transaction_date,
                ipl_payments.description,
                ipl_payment_details.ipl_tarif,
                ipl_period.period_name,
                ipl_period.`year`,
                ipl_period.`month`
              FROM
                family_cards
              INNER JOIN ipl_payments ON family_cards.id = ipl_payments.family_card_id
              INNER JOIN payment_types ON ipl_payments.payment_type_id = payment_types.id
              INNER JOIN ipl_payment_details ON ipl_payments.id = ipl_payment_details.ipl_payment_id
              INNER JOIN ipl_period ON ipl_payment_details.period_id = ipl_period.id
              INNER JOIN rts ON family_cards.rt_id = rts.id
              ORDER BY ipl_payments.id DESC';
    $data_ipl = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($data_ipl)  

      ->addColumn('action', function ($itemdata) {
        return '<a href="data-ipl/'.$itemdata->id.'/edit" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Bayar</a>';
      })
 
      ->make(true);
    } else {
      exit("No data available");
    }
  }
 
}
