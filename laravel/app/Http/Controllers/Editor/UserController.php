<?php

namespace App\Http\Controllers\Editor;

use Auth;
// use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\User;
// use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        if (Input::has('page')) {
            $page = Input::get('page');
        } else {
            $page = 1;
        }
        $no = 15 * $page - 14;
        //$users = User::paginate(15);
        $users = DB::table('user')
            ->select(
                'user.id',
                'user.employee_id',
                'user.username',
                'user.email',
                'user.first_name',
                'user.last_name',
                'user.created_at',
                'user.item_category_id',
                'user.updated_at'
            )
            ->whereNull('user.deleted_at')
            ->get();

        //dd($users);

        return view('editor.user.index', compact('users'))->with('number', $no);
    }

    public function create()
    {

        return view('editor.user.form');
    }

    public function store(RegisterRequest $request)
    {
        $user = new User;
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->action('Editor\UserController@index');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('editor.user.detail', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('editor.user.form', compact('user'));
    }

    public function update($id, PasswordRequest $request)
    {
        $user = User::find($id);
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->action('Editor\UserController@index');
    }

    public function delete($id)
    {
        $post =  User::Find($id);
        $post->delete();

        return response()->json($post);
    }

    public function datefilter(Request $request)
    {
        $post = User::where('id', Auth::id())->first();
        $post->grfrom = $request->grfrom;
        $post->grto = $request->grto;
        $post->item_category_id = $request->item_category_id;
        $post->container_id = $request->container_id;
        $post->search_filter = $request->search_filter;
        $post->save();
        return response()->json($post);
    }

    public function employeefilter(Request $request)
    {
        $post = User::where('id', Auth::id())->first();
        $post->employee_id = $request->employee_id;
        $post->save();
        return response()->json($post);
    }

    public function datefilterbranch(Request $request)
    {
        $post = User::where('id', Auth::id())->first();
        $post->grfrom = $request->grfrom;
        $post->grto = $request->grto;
        $post->item_category_id = $request->item_category_id;
        $post->branch_id = $request->branch_id;
        $post->search = $request->search;
        $post->save();
        return response()->json($post);
    }

    public function read_notif(Request $request)
    {
        $post = User::where('id', Auth::id())->first();
        $post->read_notif = 0;
        $post->save();
        return response()->json($post);
    }

    public function periodfilteronly(Request $request)
    {
        $post = User::where('id', Auth::id())->first();
        $post->period_id = $request->period_id;
        $post->save();
        return response()->json($post);
    }

    public function emklupdate(Request $request)
    {
        $user_id = Auth::id();
        $post = DB::insert("UPDATE emkl_cost
                            INNER JOIN (
                                SELECT
                                    purchase_order_detail.biaya_emkl,
                                    purchase_order_detail.total,
                                    purchase_order_detail.fee,
                                    purchase_order.doc_date 
                                FROM
                                    purchase_order
                                    JOIN purchase_order_detail ON purchase_order.id = purchase_order_detail.purchase_order_id,
                                `user` 
                                WHERE
                                    (
                                        purchase_order.doc_date BETWEEN `user`.grfrom 
                                        AND `user`.grto 
                                    ) 
                                    AND ( `user`.id = " . $user_id . " ) 
                                ) AS po 
                                SET po.biaya_emkl = emkl_cost.emkl 
                            WHERE
                                po.doc_date BETWEEN emkl_cost.datefrom 
                                AND emkl_cost.dateto");
        return response()->json($post);
    }
}
