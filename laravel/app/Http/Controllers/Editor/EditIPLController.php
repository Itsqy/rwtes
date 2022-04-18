<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EditIPLRequest;
use App\Http\Controllers\Controller;
use App\Model\IPL; 
use Validator;
use Response;
use App\Post;
use View;

class EditIPLController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'ipl_tarif' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.edit_ipl.index');
  }

  public function getBulan($bln){
    switch ($bln){
      case 1: 
        return "JANUARI";
        break;
      case 2:
        return "FEBRUARI";
        break;
      case 3:
        return "MARET";
        break;
      case 4:
        return "APRIL";
        break;
      case 5:
        return "MEI";
        break;
      case 6:
        return "JUNI";
        break;
      case 7:
        return "JULI";
        break;
      case 8:
        return "AGUSTUS";
        break;
      case 9:
        return "SEPTEMBER";
        break;
      case 10:
        return "OKTOBER";
        break;
      case 11:
        return "NOVEMBER";
        break;
      case 12:
        return "DESEMBER";
        break;
    }
  } 

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $ipl = IPL::orderBy('family_card_name', 'ASC')->where('status', '0')->get();

      return Datatables::of($ipl)  

      ->addColumn('month', function ($ipl) {

        $month_name = $this->getBulan($ipl->month);
        return ''.$month_name.'';
      })
      

      ->addColumn('action', function ($ipl) {
        return '<a href="#" onclick="edit('."'".$ipl->id."'".')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit Tarif</a> ';
      })
      
      ->addColumn('mstatus', function ($ipl) {
        if ($ipl->status == 0) {
          return '<span class="label label-success"> Active </span>';
        }else{
         return '<span class="label label-danger"> Not Active </span>';
       };
     })
      ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function edit($id)
  {
    $ipl = IPL::Find($id);
    echo json_encode($ipl); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = IPL::Find($id); 
      $post->ipl_tarif = $request->ipl_tarif; 
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

}
