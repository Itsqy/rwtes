<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\IPL; 
use App\Model\IPLPayment; 
use App\Model\IPLPaymentDetail; 
use Validator;
use Response;
use App\Post;
use View;

class DataIPLPaymentController extends Controller
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
    if($request->ajax()){ 

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
                CONCAT(COUNT(ipl.period_id), " Bulan") AS tunggakan,
                SUM(family_cards.ipl_tarif) AS total_tarif_ipl
              FROM
                ipl
              LEFT JOIN ipl_period ON ipl.period_id = ipl_period.id
              LEFT JOIN family_cards ON ipl.family_card_id = family_cards.id
              LEFT JOIN rts ON family_cards.rt_id = rts.id
              WHERE ipl.`status` = 1
              GROUP BY   
                family_cards.`name`,
                rts.rt_name,
                family_cards.ipl_tarif,
                family_cards.ipl_id,
                family_cards.block,
                family_cards.hp,
                family_cards.`no`,
                family_cards.nip';
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
