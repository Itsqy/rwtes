<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\RTRequest;
use App\Http\Controllers\Controller;
use App\Model\FamilyCard; 
use App\Model\RT; 
use Validator;
use Response;
use App\Post;
use View;

class RTController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'rt_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $family_card = FamilyCard::all();
    return view ('editor.rt.index', compact('family_card'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      // $rt = RT::orderBy('rt_name', 'ASC')->get();

      $sql = 'SELECT
                rts.id,
                rts.rt_name,
                rts.location,
                rts.description,
                rts.family_card_id,
                rts.`status`,
                family_cards.`name`
              FROM
                rts
              LEFT JOIN family_cards ON rts.family_card_id = family_cards.id';
      $rt = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($rt)  

      ->addColumn('action', function ($rt) {
        return '<a href="#" onclick="edit('."'".$rt->id."'".')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$rt->id."', '".$rt->rt_name."'".')"> <i class="ti-trash"></i> Delete</a>';
      })
      
      ->addColumn('mstatus', function ($rt) {
        if ($rt->status == 0) {
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

  public function store(Request $request)
  { 
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = new RT(); 
      $post->rt_name = $request->rt_name; 
      $post->family_card_id = $request->family_card_id; 
      $post->description = $request->description; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $rt = RT::Find($id);
    echo json_encode($rt); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = RT::Find($id); 
      $post->rt_name = $request->rt_name; 
      $post->family_card_id = $request->family_card_id; 
      $post->description = $request->description; 
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  RT::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
