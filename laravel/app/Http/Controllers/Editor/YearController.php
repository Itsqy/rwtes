<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\YearRequest;
use App\Http\Controllers\Controller;
use App\Model\Year; 
use Validator;
use Response;
use App\Post;
use View;

class YearController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'year_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.year.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $year = Year::orderBy('year_name', 'ASC')->get();

      return Datatables::of($year)  

      ->addColumn('action', function ($year) {
        return '<a href="#" onclick="edit('."'".$year->id."'".')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$year->id."', '".$year->year_name."'".')"> <i class="ti-trash"></i> Delete</a>';
      })
      
      ->addColumn('mstatus', function ($year) {
        if ($year->status == 0) {
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
    
      $post = new Year(); 
      $post->year_name = $request->year_name;  
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
  }

  public function edit($id)
  {
    $rt = Year::Find($id);
    echo json_encode($rt); 
  }

  public function update($id, Request $request)
  {
    
      $post = Year::Find($id); 
      $post->year_name = $request->year_name;  
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
  }

  public function delete($id)
  {
    $post =  Year::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
