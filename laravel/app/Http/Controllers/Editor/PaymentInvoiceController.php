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
use Validator;
use Response;
use App\Post;
use View;
use Intervention\Image\Facades\Image;

class PaymentInvoiceController extends Controller
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
    return view ('editor.payment_invoice.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 

      $sql = 'SELECT
                family_cards.id,
                family_cards.`name`,
                rts.rt_name,
                family_cards.ipl_tarif,
                family_cards.ipl_id,
                family_cards.block,
                family_cards.hp,
                family_cards.`no`,
                family_cards.nip,
                ipl_payments.id AS payment_id,
                ipl_payments.transaction_no,
                -- ipl_payments.transaction_date,
                DATE_FORMAT(ipl_payments.transaction_date, "%d-%m-%Y") as transaction_date,
                ipl_payments.description,
                ipl_payments.image,
                ipl_payments.`status`
              FROM
                family_cards
              LEFT OUTER JOIN rts ON family_cards.rt_id = rts.id
              INNER JOIN ipl_payments ON family_cards.id = ipl_payments.family_card_id
              GROUP BY
                family_cards.`name`,
                rts.rt_name,
                family_cards.ipl_tarif,
                family_cards.ipl_id,
                family_cards.block,
                family_cards.hp,
                family_cards.`no`,
                family_cards.nip,
                ipl_payments.transaction_no,
                ipl_payments.id';
    $data_ipl = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($data_ipl)  

      ->addColumn('action', function ($itemdata) {
        return '<a href="payment-invoice/'.$itemdata->payment_id.'/edit" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-credit-card"></i> Detail</a> <a href="payment-invoice/'.$itemdata->payment_id.'/print" target="_blank title="Print" class="btn btn-success btn-xs"> <i class="ti-printer"></i> Print</a>';
      })

      ->addColumn('mstatus', function ($data_ipl) {
        if ($data_ipl->status == 0) {
          return '<span class="label label-success"> Aktif </span>';
        }else{
         return '<span class="label label-danger"> Dibatalkan </span>';
        };
      })

      ->addColumn('image', function ($itemdata) {
          if ($itemdata->image == null) {
            return '';
          }else{
            return '<a href="../uploads/ipl_payment/'.$itemdata->image.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
          };  
      })
 
      ->make(true);
    } else {
      exit("No data available");
    }
  }
 

  public function edit($id)
  {
    $sql = 'SELECT
              -- family_cards.id,
              family_cards.`name`,
              rts.rt_name,
              family_cards.ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip,
              ipl_payments.id,
              ipl_payments.transaction_no,
              DATE_FORMAT(ipl_payments.transaction_date, "%d-%m-%Y") as transaction_date,
              ipl_payments.description,
              ipl_payments.image,
              payment_types.payment_type_name,
              house_types.house_type_name,
              ipl_payments.`status`
            FROM
              family_cards
            LEFT OUTER JOIN rts ON family_cards.rt_id = rts.id
            INNER JOIN ipl_payments ON family_cards.id = ipl_payments.family_card_id
            LEFT JOIN payment_types ON ipl_payments.payment_type_id = payment_types.id
            LEFT JOIN house_types ON family_cards.house_type_id = house_types.id
            WHERE ipl_payments.id = '.$id.'
            GROUP BY
              family_cards.`name`,
              rts.rt_name,
              family_cards.ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              payment_types.payment_type_name,
              house_types.house_type_name,
              family_cards.nip';
    $data_header_ipl = DB::table(DB::raw("($sql) as rs_sql"))->first();

    $sql = 'SELECT
              ipl.id,
              ipl.`status`,
              ipl_period.period_name,
              ipl_period.`month`,
              ipl_period.`year`,
              ipl.period_id,
              family_cards.`name`,
              rts.rt_name,
              FORMAT(
                ipl_payment_details.ipl_tarif,
                0
              ) AS ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip
            FROM
              ipl
            LEFT OUTER JOIN ipl_period ON ipl.period_id = ipl_period.id
            LEFT OUTER JOIN family_cards ON ipl.family_card_id = family_cards.id
            LEFT OUTER JOIN rts ON family_cards.rt_id = rts.id
            INNER JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
            WHERE ipl_payment_details.ipl_payment_id = '.$id.'';
    $data_ipl = DB::table(DB::raw("($sql) as rs_sql"))->get();

    return view ('editor.payment_invoice.form', compact('data_header_ipl', 'data_ipl'));
  }

  public function print($id)
  {

    $now = Carbon::now();
    $month = $now->format('m');
    $year = $now->format('Y');

    $sql = 'SELECT
              -- family_cards.id,
              family_cards.`name`,
              rts.rt_name,
              family_cards.id AS family_card_id,
              family_cards.ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.`address`,
              family_cards.nip,
              family_cards.bill_2019,
              family_cards.unique_code,
              ipl_payments.id,
              ipl_payments.transaction_no,
              DATE_FORMAT(ipl_payments.transaction_date, "%d-%m-%Y") as transaction_date,
              ipl_payments.description,
              ipl_payments.image,
              payment_types.payment_type_name,
              house_types.house_type_name,
              ipl_payments.`status`
            FROM
              family_cards
            LEFT OUTER JOIN rts ON family_cards.rt_id = rts.id
            INNER JOIN ipl_payments ON family_cards.id = ipl_payments.family_card_id
            LEFT JOIN payment_types ON ipl_payments.payment_type_id = payment_types.id
            LEFT JOIN house_types ON family_cards.house_type_id = house_types.id
            WHERE ipl_payments.id = '.$id.'
            GROUP BY
              family_cards.`name`,
              rts.rt_name,
              family_cards.ipl_tarif,
              family_cards.ipl_id,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              payment_types.payment_type_name,
              house_types.house_type_name,
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
                          format(SUM(ipl.ipl_tarif),0) AS total_tarif_ipl_old,
                          format(SUM(family_cards.ipl_tarif)+ family_cards.unique_code,0) AS total_tarif_ipl
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
              ipl.id,
              ipl.`status`,
              ipl_period.period_name,
              ipl_period.`month`,
              ipl_period.`year`,
              ipl.period_id,
              family_cards.`name`,
              rts.rt_name,
              ipl_payment_details.ipl_tarif,
              family_cards.ipl_id,
              family_cards.unique_code,
              family_cards.block,
              family_cards.hp,
              family_cards.`no`,
              family_cards.nip
            FROM
              ipl
            LEFT OUTER JOIN ipl_period ON ipl.period_id = ipl_period.id
            LEFT OUTER JOIN family_cards ON ipl.family_card_id = family_cards.id
            LEFT OUTER JOIN rts ON family_cards.rt_id = rts.id
            INNER JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
            WHERE ipl_payment_details.ipl_payment_id = '.$id.'';
    $data_ipl = DB::table(DB::raw("($sql) as rs_sql"))->get();

    return view ('editor.payment_invoice.print', compact('data_header_ipl', 'data_ipl', 'data_header_ipl_outstanding'));
  }

  public function update($id, Request $request)
  {
    try {

        $userid= Auth::id();

        $ipl_payment = IPLpayment::where('id', $id)->first();
        $ipl_payment->status = 1;
        $ipl_payment->save(); 

        $ipl_payment_detail = IPLPaymentDetail::where('ipl_payment_id', $id)->get();

        foreach($ipl_payment_detail as $detail_data)
          {
            $data_ipl = IPL::where('id', $detail_data->ipl_id)->first();
            $data_ipl->status = 0;
            $data_ipl->save();
          };

        return redirect('editor/payment-invoice'); 
        
      } catch (\Exception $e) {
      $json['code'] = 0;
      $json['msg'] = "Failed";
    }
  }
 
}
