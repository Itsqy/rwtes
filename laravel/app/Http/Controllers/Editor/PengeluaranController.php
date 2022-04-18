<?php


namespace App\Http\Controllers\Editor;

use App\Pengeluaran;
use Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Response;

use App\Post;
use Carbon\Carbon;
use View;


class PengeluaranController extends Controller
{
    /**
     * @var array
     */
    protected $rules =
    [
        'nama' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = Pengeluaran::where('jumlah', '!=', 0)->sum('jumlah');
        $pengeluaran = Pengeluaran::all();

        return view('editor.pengeluaran.index', compact('pengeluaran', 'total'));
    }

    public function create()
    {

        return view('editor.pengeluaran.form');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            // $rt = RT::orderBy('rt_name', 'ASC')->get();

            // $rt = Pengeluaran::where('jumlah', '!=', 0)->sum('jumlah');
            $rt = Pengeluaran::orderBy('nama', 'ASC')->get();

            return Datatables::of($rt)

            

                ->addColumn('action', function ($rt) {
                    return '<a href="#" onclick="edit(' . "'" . $rt->id . "'" . ')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id(' . "'" . $rt->id . "', '" . $rt->nama . "'" . ')"> <i class="ti-trash"></i> Delete</a>';
                })

                ->addColumn('id', function ($rt) {
                    return 'EZCSH/000'.$rt->id.'';
                })
                ->addColumn('jumlah', function ($rt) {
                    return'Rp. '.number_format($rt->jumlah, 0, ',', '.').'';
                })

                ->addColumn('mstatus', function ($rt) {
                    if ($rt->status == 0) {
                        return '<span class="label label-success"> CASH </span>';
                    } else {
                        return '<span class="label label-danger"> CREDIT </span>';
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
            $post = new Pengeluaran();
            $post->nama = $request->nama;
            $post->jumlah = $request->jumlah;
            $post->status = $request->status;



            if ($request->image) {

                $original_directory = "uploads/pengeluaran/";

                if (!File::exists($original_directory)) {
                    File::makeDirectory($original_directory, $mode = 0777, true, true);
                }

                $post->image = Carbon::now()->format("d-m-Y-h-i-s") . $request->image->getClientOriginalName();
                $request->image->move($original_directory, $post->image);
            }

            $post->save();

            return redirect('editor/dudu')->with('success', 'Data Pengeluaran Berhasil Ditambahkan');
            // }
        }
    }

    public function edit($id)
    {
        $out = Pengeluaran::find($id);
        return response($out);

        // return view('editor.pengeluaran.form', compact('out'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $post = Pengeluaran::Find($id);
            $post->nama = $request->nama;
            $post->jumlah = $request->jumlah;
            $post->status = $request->status;


            $post->save();

            return response()->json($post);
            // return redirect('editor/dudu');
        }
    }

    public function delete($id)
    {
        $post =  Pengeluaran::Find($id);
        $post->delete();

        return response()->json($post);
    }
}
