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

class MonthlyReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $year = year::all();
    return view ('editor.monthly_report.index', compact('year'));
  }

  public function data(Request $request)
  {

    if($request->ajax()){ 
      // $id = 2020;
      $sql = 'SELECT
                rts.rt_name,
                DATE_FORMAT(
                  ipl_payments.transaction_date,
                  "%m"
                ) AS month_name,
                DATE_FORMAT(
                  ipl_payments.transaction_date,
                  "%Y"
                ) AS year_name,
                SUM(ipl_payment_details.ipl_tarif) AS total
              FROM
                ipl
              LEFT OUTER JOIN ipl_period ON ipl.period_id = ipl_period.id
              LEFT OUTER JOIN family_cards ON ipl.family_card_id = family_cards.id
              LEFT OUTER JOIN rts ON family_cards.rt_id = rts.id
              INNER JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
              INNER JOIN ipl_payments ON ipl_payment_details.ipl_payment_id = ipl_payments.id
              GROUP BY
                rts.rt_name,
                DATE_FORMAT(
                  ipl_payments.transaction_date,
                  "%m"
                ),
                DATE_FORMAT(
                  ipl_payments.transaction_date,
                  "%Y"
                )';
      $data_ipl = DB::table(DB::raw("($sql) as rs_sql"));

      return Datatables::of($data_ipl)  

      ->filter(function ($data_ipl) use ($request) {
         $year = $request->input('year');
         $data_ipl->where('rs_sql.year_name', $year);
      })

      ->addColumn('januari', function ($data_ipl) {
        if($data_ipl->month_name == 01){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('februari', function ($data_ipl) {
        if($data_ipl->month_name == 02){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('maret', function ($data_ipl) {
        if($data_ipl->month_name == 03){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('april', function ($data_ipl) {
        if($data_ipl->month_name == 04){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('mei', function ($data_ipl) {
        if($data_ipl->month_name == 05){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('juni', function ($data_ipl) {
        if($data_ipl->month_name == 6){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('juli', function ($data_ipl) {
        if($data_ipl->month_name == 7){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('agustus', function ($data_ipl) {
        if($data_ipl->month_name == 8){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('september', function ($data_ipl) {
        if($data_ipl->month_name == 9){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('oktober', function ($data_ipl) {
        if($data_ipl->month_name == 10){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('november', function ($data_ipl) {
        if($data_ipl->month_name == 11){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->addColumn('desember', function ($data_ipl) {
        if($data_ipl->month_name == 12){
          return $data_ipl->total;
        }else{
          return 0;
        };
      })

      ->make(true);

    } else {
      exit("No data available");
    }

  }

  public function print(Request $request, $id)
  {

    return view ('editor.monthly_report.print', compact('data_ipl', 'id'));
    
  }
 
}
