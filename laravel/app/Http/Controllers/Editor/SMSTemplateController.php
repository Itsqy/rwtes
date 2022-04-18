<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SMSTemplateRequest;
use App\Http\Controllers\Controller;
use App\Model\SMSTemplate; 
use Validator;
use Response;
use App\Post;
use View;

class SMSTemplateController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'sms_template_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.sms_template.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $sms_template = SMSTemplate::orderBy('sms_template_name', 'ASC')->get();

      return Datatables::of($sms_template)  

      ->addColumn('action', function ($sms_template) {
        return '<a href="#" onclick="edit('."'".$sms_template->id."'".')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a>';
      })
      
      ->addColumn('mstatus', function ($sms_template) {
        if ($sms_template->status == 0) {
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
      $post = new SMSTemplate(); 
      // $post->sms_template_name = $request->sms_template_name; 
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
    $sms_template = SMSTemplate::Find($id);
    echo json_encode($sms_template); 
  }

  public function update($id, Request $request)
  {
      $post = SMSTemplate::Find($id); 
      // $post->sms_template_name = $request->sms_template_name; 
      // $post->ipl_tarif = $request->ipl_tarif; 
      $post->description = $request->description; 
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
  }

  public function delete($id)
  {
    $post =  SMSTemplate::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
