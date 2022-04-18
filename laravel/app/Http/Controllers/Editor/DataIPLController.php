<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use File;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\IPL; 
use App\Model\IPLPayment; 
use App\Model\IPLPaymentDetail; 
use App\Model\PaymentType; 
use Validator;
use Response;
use App\Post;
use View;
use Intervention\Image\Facades\Image;

class DataIPLController extends Controller
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
    return view ('editor.data_ipl.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 

      $sql = 'SELECT 
                family_cards.id, 
                family_cards.`name`,
                rts.rt_name,
                family_cards.ipl_tarif + family_cards.unique_code AS ipl_tarif,
                family_cards.ipl_id,
                family_cards.block,
                family_cards.hp,
                family_cards.`no`,
                family_cards.nip,
                house_types.house_type_name,
                CONCAT(COUNT(ipl.period_id), " Bulan") AS tunggakan,
                SUM(ipl.ipl_tarif) AS total_tarif_ipl
              FROM
                ipl
              LEFT JOIN ipl_period ON ipl.period_id = ipl_period.id
              LEFT JOIN family_cards ON ipl.family_card_id = family_cards.id
              LEFT JOIN house_types ON family_cards.house_type_id = house_types.id
              LEFT JOIN rts ON family_cards.rt_id = rts.id
              WHERE ipl.`status` = 0
              GROUP BY   
                family_cards.`name`,
                rts.rt_name,
                family_cards.ipl_tarif,
                family_cards.ipl_id,
                family_cards.block,
                family_cards.hp,
                family_cards.`no`,
                house_types.house_type_name,
                family_cards.nip';
    $data_ipl = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($data_ipl)  

      ->addColumn('action', function ($itemdata) {
        return '<a href="data-ipl/'.$itemdata->id.'/edit" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-credit-card"></i> Bayar</a>';
      })
 
      ->make(true);
    } else {
      exit("No data available");
    }
  }
 

  public function edit($id)
  {

    $now = Carbon::now();
    $month = $now->format('m');
    $year = $now->format('Y');

    $payment_type_list = PaymentType::all()->pluck('payment_type_name', 'id');

    $sql = 'SELECT 
              family_cards.id, 
              family_cards.id AS family_card_id, 
              family_cards.`name`,
              rts.rt_name,
              format(family_cards.ipl_tarif + family_cards.unique_code, 0) AS ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip,
              CONCAT(COUNT(ipl.period_id), " Bulan") AS tunggakan,
              format(SUM(ipl.ipl_tarif),0) AS total_tarif_ipl
            FROM
              ipl
            LEFT JOIN ipl_period ON ipl.period_id = ipl_period.id
            LEFT JOIN family_cards ON ipl.family_card_id = family_cards.id
            LEFT JOIN rts ON family_cards.rt_id = rts.id
            WHERE ipl.`status` = 0 AND family_cards.id = '.$id.'
            GROUP BY   
              family_cards.`name`,
              rts.rt_name,
              family_cards.ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip';
    $data_header_ipl = DB::table(DB::raw("($sql) as rs_sql"))->first();

    $sql_outstanding = 'SELECT 
                            family_cards.id, 
                            family_cards.id AS family_card_id, 
                            family_cards.`name`,
                            rts.rt_name,
                            format(family_cards.ipl_tarif + family_cards.unique_code, 0) AS ipl_tarif,
                            family_cards.ipl_id,
                            family_cards.block,
                            family_cards.hp,
                            family_cards.`no`,
                            family_cards.nip,
                            CONCAT(COUNT(ipl.period_id), " Bulan") AS tunggakan,
                            format(SUM(ipl.ipl_tarif),0) AS total_tarif_ipl
                          FROM
                            ipl
                          LEFT JOIN ipl_period ON ipl.period_id = ipl_period.id
                          LEFT JOIN family_cards ON ipl.family_card_id = family_cards.id
                          LEFT JOIN rts ON family_cards.rt_id = rts.id
                          WHERE ipl.`status` = 0 
                          AND family_cards.id = '.$data_header_ipl->family_card_id.'
                          AND ipl.month <= '.$month.' AND ipl.year = '.$year.'
                          GROUP BY   
                            family_cards.`name`,
                            rts.rt_name,
                            family_cards.ipl_tarif,
                            family_cards.ipl_id,
                            family_cards.block,
                            family_cards.hp,
                            family_cards.`no`,
                            family_cards.nip';
    $data_header_ipl_outstanding = DB::table(DB::raw("($sql_outstanding) as rs_sql"))->first();

    $sql = 'SELECT
                ipl.`id`,
                ipl.`status`,
                ipl_period.`period_name`,
                ipl_period.`month`,
                ipl_period.`year`,
                ipl.period_id,
                family_cards.`name`,
                rts.rt_name,
                house_types.house_type_name,
                FORMAT(ipl.ipl_tarif,0) AS ipl_tarif,
                family_cards.ipl_id,
                family_cards.block,
                family_cards.hp,
                family_cards.`no`,
                family_cards.nip
              FROM
                ipl
              LEFT JOIN ipl_period ON ipl.period_id = ipl_period.id
              LEFT JOIN family_cards ON ipl.family_card_id = family_cards.id
              LEFT JOIN rts ON family_cards.rt_id = rts.id
              LEFT JOIN house_types ON family_cards.house_type_id = house_types.id
              WHERE family_cards.id = '.$id.' AND ipl.status = 0';
    $data_ipl = DB::table(DB::raw("($sql) as rs_sql"))->get();

    return view ('editor.data_ipl.form', compact('data_header_ipl', 'data_ipl', 'payment_type_list', 'data_header_ipl_outstanding'));
  }

  public function update($id, Request $request)
  {
    try {

        $userid= Auth::id();

        DB::insert("INSERT INTO ipl_payments (transaction_no, transaction_date, created_by, created_at)
                    SELECT
                    IFNULL(CONCAT(DATE_FORMAT(NOW(), '%y%m%d'),RIGHT((RIGHT(MAX(RIGHT(ipl_payments.transaction_no,5)),5))+100001,5)), CONCAT(DATE_FORMAT(NOW(), '%y%m%d'),'00001')), DATE(NOW()), '".$userid."', DATE(NOW())
                    FROM
                    ipl_payments");

        $lastInsertedID = DB::table('ipl_payments')->max('id');

        $ipl_payment = IPLpayment::where('id', $lastInsertedID)->first();
        $ipl_payment->description = $request->input('description');
        $ipl_payment->family_card_id = $request->input('family_card_id');
        $ipl_payment->payment_type_id = $request->input('payment_type_id');

        if($request->image)
        {

          $original_directory = "uploads/ipl_payment/";

          if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          }

          $ipl_payment->image = Carbon::now()->format("d-m-Y-h-i-s").$request->image->getClientOriginalName();
          $request->image->move($original_directory, $ipl_payment->image);
          
        }

        $ipl_payment->save(); 


        foreach($request->input('payment') as $key => $detail_data)
          {
          
          $data_ipl = IPL::where('id', $key)->first();
          $data_ipl->status = 1;
          $data_ipl->save();

          $post = new IPLPaymentDetail;
          $post->period_id = $data_ipl->period_id;
          $post->ipl_id = $data_ipl->id;
          $post->ipl_tarif = $data_ipl->ipl_tarif;
          $post->ipl_payment_id = $lastInsertedID;
          $post->save();

          // if( isset($detail_data['checklist'])){
          //   $checklist = 1;
          // }else{
          //   $checklist = 0;
          // };
          };

        return redirect('editor/payment-invoice/'.$ipl_payment->id.'/edit'); 
        
      } catch (\Exception $e) {
      $json['code'] = 0;
      $json['msg'] = "Failed";
    }
  }
 
}
