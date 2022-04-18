<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentTypeRequest;
use App\Http\Controllers\Controller;
use App\Model\PaymentType;
use Validator;
use Response;
use App\Post;
use View;

class PaymentTypeController extends Controller
{
  /**
   * @var array
   */
  protected $rules =
  [
    'payment_type_name' => 'required'
  ];


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    return view('editor.payment_type.index');
  }

  public function data(Request $request)
  {
    if ($request->ajax()) {
      $payment_type = PaymentType::orderBy('payment_type_name', 'ASC')->get();

      return Datatables::of($payment_type)

        ->addColumn('action', function ($payment_type) {
          return '<a href="#" onclick="edit(' . "'" . $payment_type->id . "'" . ')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id(' . "'" . $payment_type->id . "', '" . $payment_type->payment_type_name . "'" . ')"> <i class="ti-trash"></i> Delete</a>';
        })

        ->addColumn('mstatus', function ($payment_type) {
          if ($payment_type->status == 0) {
            return '<span class="label label-success"> Active </span>';
          } else {
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

    $post = new PaymentType();
    $post->payment_type_name = $request->payment_type_name;
    $post->status = $request->status;
    $post->created_by = Auth::id();
    $post->save();

    return response()->json($post);
  }

  public function edit($id)
  {
    $rt = PaymentType::Find($id);
    echo json_encode($rt);
  }

  public function update($id, Request $request)
  {

    $post = PaymentType::Find($id);
    $post->payment_type_name = $request->payment_type_name;
    $post->status = $request->status;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post);
  }

  public function delete($id)
  {
    $post =  PaymentType::Find($id);
    $post->delete();

    return response()->json($post);
  }
}
