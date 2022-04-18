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

class PaymentArrearsReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $year = year::all();
    return view ('editor.payment_arrears_report.index', compact('year'));
  }

  public function data(Request $request)
  {

    if($request->ajax()){ 
      
      $year = $request->input('year');
      $month = $request->input('month');

      // $id = 2020;
      $sql = 'SELECT
                rts.id,
                rts.rt_name,
                COUNT(family_cards.id) AS jumlah_rumah,
                sum(ipl.ipl_tarif) AS tagihan,
                ifnull(
                  sum(ipl_payment_details.ipl_tarif),
                  0
                ) AS pembayaran
              FROM
                rts
              INNER JOIN family_cards ON rts.id = family_cards.rt_id
              INNER JOIN (SELECT * FROM ipl WHERE status=0 AND ipl.year = '.$year.' AND ipl.month = '.$month.') AS ipl ON family_cards.id = ipl.family_card_id
              LEFT JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
              GROUP BY
                rts.id,
                rts.rt_name';
      $data_ipl = DB::table(DB::raw("($sql) as rs_sql"));



      return Datatables::of($data_ipl)  

      ->filter(function ($data_ipl) use ($request) {
        //  $year = $request->input('year');
        //  $data_ipl->where('rs_sql.year_name', $year);
      })
      
     

     ->addColumn('tagihan_periode', function ($data_ipl) use ($request) {

      $year = $request->input('year');
      $month = $request->input('month');

      $sql_period = 'SELECT
                      rts.id,
                      rts.rt_name,
                      COUNT(family_cards.id) AS jumlah_rumah,
                      sum(ipl.ipl_tarif) AS tagihan,
                      ifnull(
                        sum(ipl_payment_details.ipl_tarif),
                        0
                      ) AS pembayaran
                    FROM
                      rts
                    INNER JOIN family_cards ON rts.id = family_cards.rt_id
                    INNER JOIN ipl ON family_cards.id = ipl.family_card_id
                    LEFT JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
                    WHERE ipl.year = '.$year.' AND ipl.month = '.$month.' AND rts.id = '.$data_ipl->id.'
                    GROUP BY
                      rts.id,
                      rts.rt_name';
        $data_ipl_period = DB::table(DB::raw("($sql_period) as rs_sql_period"))->first();
        
        if(isset($data_ipl_period))
        {
          return $data_ipl_period->tagihan;
        }else{
          return 0;
        }
    })

    ->addColumn('pembayaran_periode', function ($data_ipl) use ($request) {

      $year = $request->input('year');
      $month = $request->input('month');

      $sql_period = 'SELECT
                      rts.id,
                      rts.rt_name,
                      COUNT(family_cards.id) AS jumlah_rumah,
                      sum(ipl.ipl_tarif) AS tagihan,
                      ifnull(
                        sum(ipl_payment_details.ipl_tarif),
                        0
                      ) AS pembayaran
                    FROM
                      rts
                    INNER JOIN family_cards ON rts.id = family_cards.rt_id
                    INNER JOIN ipl ON family_cards.id = ipl.family_card_id
                    LEFT JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
                    WHERE ipl.year = '.$year.' AND ipl.month = '.$month.' AND rts.id = '.$data_ipl->id.'
                    GROUP BY
                      rts.id,
                      rts.rt_name';
        $data_ipl_period = DB::table(DB::raw("($sql_period) as rs_sql_period"))->first();

        if(isset($data_ipl_period))
        {
          return $data_ipl_period->pembayaran;
        }else{
          return 0;
        }
    })

    ->addColumn('persen_bayar_period', function ($data_ipl) use ($request) {

      $year = $request->input('year');
      $month = $request->input('month');

      $sql_period = 'SELECT
                      rts.id,
                      rts.rt_name,
                      COUNT(family_cards.id) AS jumlah_rumah,
                      sum(ipl.ipl_tarif) AS tagihan,
                      ifnull(
                        sum(ipl_payment_details.ipl_tarif),
                        0
                      ) AS pembayaran
                    FROM
                      rts
                    INNER JOIN family_cards ON rts.id = family_cards.rt_id
                    INNER JOIN ipl ON family_cards.id = ipl.family_card_id
                    LEFT JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
                    WHERE ipl.year = '.$year.' AND ipl.month = '.$month.' AND rts.id = '.$data_ipl->id.'
                    GROUP BY
                      rts.id,
                      rts.rt_name';
        $data_ipl_period = DB::table(DB::raw("($sql_period) as rs_sql_period"))->first();

      if(isset($data_ipl_period))
      {
        return ($data_ipl_period->pembayaran / $data_ipl_period->tagihan) * 100;
      }else{
        return 0;
      }
    })

    ->addColumn('sisa_period', function ($data_ipl) use ($request) {

      $year = $request->input('year');
      $month = $request->input('month');

      $sql_period = 'SELECT
                      rts.id,
                      rts.rt_name,
                      COUNT(family_cards.id) AS jumlah_rumah,
                      sum(ipl.ipl_tarif) AS tagihan,
                      ifnull(
                        sum(ipl_payment_details.ipl_tarif),
                        0
                      ) AS pembayaran
                    FROM
                      rts
                    INNER JOIN family_cards ON rts.id = family_cards.rt_id
                    INNER JOIN ipl ON family_cards.id = ipl.family_card_id
                    LEFT JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
                    WHERE ipl.year = '.$year.' AND ipl.month = '.$month.' AND rts.id = '.$data_ipl->id.'
                    AND ipl.status = 0
                    GROUP BY
                      rts.id,
                      rts.rt_name';
        $data_ipl_period = DB::table(DB::raw("($sql_period) as rs_sql_period"))->first();

      if(isset($data_ipl_period))
      {
        return $data_ipl_period->tagihan - $data_ipl_period->pembayaran;
      }else{
        return 0;
      }
    })

    ->addColumn('persen_sisa_period', function ($data_ipl) use ($request) {

      $year = $request->input('year');
      $month = $request->input('month');

      $sql_period = 'SELECT
                      rts.id,
                      rts.rt_name,
                      COUNT(family_cards.id) AS jumlah_rumah,
                      sum(ipl.ipl_tarif) AS tagihan,
                      ifnull(
                        sum(ipl_payment_details.ipl_tarif),
                        0
                      ) AS pembayaran
                    FROM
                      rts
                    INNER JOIN family_cards ON rts.id = family_cards.rt_id
                    INNER JOIN ipl ON family_cards.id = ipl.family_card_id
                    LEFT JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
                    WHERE ipl.year = '.$year.' AND ipl.month = '.$month.' AND rts.id = '.$data_ipl->id.'
                    AND ipl.status = 0
                    GROUP BY
                      rts.id,
                      rts.rt_name';
        $data_ipl_period = DB::table(DB::raw("($sql_period) as rs_sql_period"))->first();
        
      if(isset($data_ipl_period))
      {
        return 100 - (($data_ipl_period->pembayaran / $data_ipl_period->tagihan) * 100);
      }else{
        return 0;
      }
  })


  ->addColumn('collectability_ratio', function ($data_ipl) use ($request) {

    $year = $request->input('year');
    $month = $request->input('month');

    $sql_period = 'SELECT
                    rts.id,
                    rts.rt_name,
                    COUNT(family_cards.id) AS jumlah_rumah,
                    sum(ipl.ipl_tarif) AS tagihan,
                    ifnull(
                      sum(ipl_payment_details.ipl_tarif),
                      0
                    ) AS pembayaran
                  FROM
                    rts
                  INNER JOIN family_cards ON rts.id = family_cards.rt_id
                  INNER JOIN ipl ON family_cards.id = ipl.family_card_id
                  LEFT JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
                  WHERE ipl.year <= '.$year.' AND ipl.month < '.$month.' AND rts.id = '.$data_ipl->id.'
                  GROUP BY
                    rts.id,
                    rts.rt_name';
      $data_ipl_period = DB::table(DB::raw("($sql_period) as rs_sql_period"))->first();
      
    if(isset($data_ipl_period))
    {
      return $data_ipl->pembayaran / $data_ipl_period->tagihan * 100;
    }else{
      return 0;
    }
  })

  ->addColumn('tunggakan_periode_sebelumnya', function ($data_ipl) use ($request) {

    $year = $request->input('year');
    $month = $request->input('month');

    $sql_period = 'SELECT
                    rts.id,
                    rts.rt_name,
                    COUNT(family_cards.id) AS jumlah_rumah,
                    sum(ipl.ipl_tarif) AS tagihan,
                    ifnull(
                      sum(ipl_payment_details.ipl_tarif),
                      0
                    ) AS pembayaran
                  FROM
                    rts
                  INNER JOIN family_cards ON rts.id = family_cards.rt_id
                  INNER JOIN ipl ON family_cards.id = ipl.family_card_id
                  LEFT JOIN ipl_payment_details ON ipl.id = ipl_payment_details.ipl_id
                  WHERE ipl.year <= '.$year.' AND ipl.month < '.$month.' AND rts.id = '.$data_ipl->id.'
                  AND ipl.status = 0
                  GROUP BY
                    rts.id,
                    rts.rt_name';
      $data_ipl_period = DB::table(DB::raw("($sql_period) as rs_sql_period"))->first();
      
    if(isset($data_ipl_period))
    {
      return $data_ipl_period->tagihan;
    }else{
      return 0;
    }
  })

  ->addColumn('rata_rata', function ($data_ipl) {
    
      return $data_ipl->tagihan / $data_ipl->jumlah_rumah;
   
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
