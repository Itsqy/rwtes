<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\HouseTypeRequest;
use App\Http\Controllers\Controller;
use App\Model\HouseType; 
use Validator;
use Response;
use App\Post;
use View;

class HouseTypeController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'house_type_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.house_type.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $house_type = HouseType::orderBy('house_type_name', 'ASC')->get();

      return Datatables::of($house_type)  

      ->addColumn('action', function ($house_type) {
        return '<a href="#" onclick="edit('."'".$house_type->id."'".')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$house_type->id."', '".$house_type->house_type_name."'".')"> <i class="ti-trash"></i> Delete</a>';
      })
      
      ->addColumn('mstatus', function ($house_type) {
        if ($house_type->status == 0) {
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
      $post = new HouseType(); 
      $post->house_type_name = $request->house_type_name; 
      // $post->ipl_tarif = $request->ipl_tarif; 
      $post->description = $request->description; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $house_type = HouseType::Find($id);
    echo json_encode($house_type); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = HouseType::Find($id); 
      $post->house_type_name = $request->house_type_name; 
      // $post->ipl_tarif = $request->ipl_tarif; 
      $post->description = $request->description; 
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  HouseType::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
