<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Popup;
use App\Pengeluaran;

class EditorController extends Controller
{
  public function index()
  {
    $sql = 'SELECT
                COUNT(family_cards.id) AS count_family_card
              FROM
                family_cards
              WHERE
                family_cards.`status` = 0';
    $count_family_card = DB::table(DB::raw("($sql) as rs_sql"))->first();


    $sql1 = 'SELECT
                SUM(ipl.ipl_tarif) AS ipl_tarif
              FROM
                ipl
              WHERE
                ipl.`status` = 0';
    $outstranding = DB::table(DB::raw("($sql1) as rs_sql1"))->first();


    $sql2 = 'SELECT
                SUM(ipl.ipl_tarif) AS ipl_tarif
              FROM
                ipl
              WHERE
                ipl.`status` = 1';
    $payment = DB::table(DB::raw("($sql2) as rs_sql2"))->first();


    $sql3 = 'SELECT
                COUNT(ipl_period.id) AS count_period
              FROM
                ipl_period';
    $period = DB::table(DB::raw("($sql3) as rs_sql3"))->first();

    // $period = Pengeluaran::all()->count();


    return view('editor.index', compact('count_family_card', 'outstranding', 'payment', 'period'));
  }

  public function notif()
  {
    $notif = [];
    return view('editor.notif.index', compact('notif'));
  }
}
