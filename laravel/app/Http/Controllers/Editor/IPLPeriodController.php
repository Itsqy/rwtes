<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\IPL; 
use App\Model\IPLPeriod; 
use App\Model\FamilyCard; 
use App\Model\Year; 
use Validator;
use Response;
use App\Post;
use View;

class IPLPeriodController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $year = Year::all();
    return view ('editor.ipl_period.index', compact('year'));
  }

  public function store(Request $request)
  {
    $month = $request->month;
    $year = $request->year;

    $ipl_period = IPLPeriod::where('year', $year)->where('month', $month)->first();

    if(isset($ipl_period))
    {
      $msg = 'Error, Periode sudah dibuat sebelumnya!';
    }else{
      $period = New IPLPeriod;
      $period->year = $year;
      $period->month = $month;
      $period->period_name = 'Periode Bulan ' . $month . ' Tahun '. $year;
      $period->save();

      $family_card = FamilyCard::all();

      foreach($family_card as $family_cards)
      {
        $ipl = New IPL;
        $ipl->period_id = $period->id;
        $ipl->month = $month;
        $ipl->year = $year;
        $ipl->family_card_id = $family_cards->id;
        $ipl->family_card_name = $family_cards->name;
        $ipl->ipl_tarif = $family_cards->ipl_tarif + $family_cards->unique_code;
        $ipl->save();

        $msg = 'Tagihan berhasil dibuat';
      }
    }

    return response()->json($msg);
  }
 
}
