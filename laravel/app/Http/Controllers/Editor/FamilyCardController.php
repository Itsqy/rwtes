<?php

namespace App\Http\Controllers\Editor;

use Auth;
use File;
use Session;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\FamilyCardRequest;
use App\Http\Controllers\Controller;
use App\Model\RT;
use App\Model\HouseType;
use App\Model\FamilyCard;
use App\Model\FamilyCardDetail;
use App\Model\IPL;
use App\Model\IPLPayment;
use App\Model\IPLPaymentDetail;
use App\Model\PaymentType;
use App\Model\IPLPeriod; 
use Validator;
use Response;
use App\Post;
use View;
use Intervention\Image\Facades\Image;
use Excel;
// use Slack;
// use Client;


class FamilyCardController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    // 'employeename' => 'required|min:2'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      return view ('editor.family_card.index');
    }

    public function data(Request $request)
    {
      if($request->ajax()){

        // $itemdata = FamilyCard::all();
        $sql = 'SELECT
                  family_cards.id,
                  family_cards.`no`,
                  family_cards.nip,
                  family_cards.`name`,
                  family_cards.address,
                  family_cards.rt_id,
                  family_cards.village,
                  family_cards.sub_district,
                  family_cards.city,
                  family_cards.pos_code,
                  family_cards.province,
                  family_cards.house_type_id,
                  family_cards.ipl_id,
                  family_cards.block,
                  family_cards.ipl_tarif,
                  family_cards.unique_code,
                  family_cards.hp,
                  family_cards.bill_2019,
                  family_cards.image,
                  family_cards.image2,
                  family_cards.image3,
                  family_cards.image4,
                  family_cards.image5,
                  family_cards.image6,
                  family_cards.description_image,
                  family_cards.description_image2,
                  family_cards.description_image3,
                  family_cards.description_image4,
                  family_cards.description_image5,
                  family_cards.description_image6,
                  family_cards.status,
                  family_cards.created_at,
                  family_cards.updated_at,
                  house_types.house_type_name,
                  -- house_types.ipl_tarif,
                  rts.rt_name
                FROM
                  family_cards
                LEFT JOIN house_types ON family_cards.house_type_id = house_types.id
                LEFT JOIN rts ON family_cards.rt_id = rts.id';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

        return Datatables::of($itemdata)

        ->addColumn('action', function ($itemdata) {
          return '<a href="family-card/'.$itemdata->id.'/edit" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a href="family-card/'.$itemdata->id.'/member" title="Anggota Keluarga" class="btn btn-success btn-xs"> <i class="ti-user"></i> Anggota Keluarga</a> <a href="family-card/'.$itemdata->id.'/ipl" title="Tagihan IPL" class="btn btn-warning btn-xs"> <i class="ti-money"></i> Tagihan IPL</a> <a  href="javascript:void(0)" title="Hapus" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->name."'".')" class="btn btn-danger btn-xs"> <i class="ti-trash"></i> Hapus</a>';
        })

        ->addColumn('image', function ($itemdata) {
          if ($itemdata->image == null) {
            return '<a class="fancybox" rel="group" href="//assets/img/thumbnail.png"><img src="../assets/img/thumbnail.jpg" class="img-thumbnail img-responsive" /></a>';
          }else{
           return '<a class="fancybox" rel="group" href="../uploads/family-card/'.$itemdata->image.'"><img src="../uploads/family-card/thumbnail/'.$itemdata->image.'" class="img-thumbnail img-responsive" /></a>';
         };
       })

       ->addColumn('image2', function ($itemdata) {
          if ($itemdata->image2 == null) {
            return '<a class="fancybox" rel="group" href="//assets/img/thumbnail.png"><img src="../assets/img/thumbnail.jpg" class="img-thumbnail img-responsive" /></a>';
          }else{
          return '<a class="fancybox" rel="group" href="../uploads/family-card/'.$itemdata->image2.'"><img src="../uploads/family-card/thumbnail/'.$itemdata->image2.'" class="img-thumbnail img-responsive" /></a>';
        };
      })

      ->addColumn('image3', function ($itemdata) {
        if ($itemdata->image3 == null) {
          return '<a class="fancybox" rel="group" href="//assets/img/thumbnail.png"><img src="../assets/img/thumbnail.jpg" class="img-thumbnail img-responsive" /></a>';
        }else{
         return '<a class="fancybox" rel="group" href="../uploads/family-card/'.$itemdata->image3.'"><img src="../uploads/family-card/thumbnail/'.$itemdata->image3.'" class="img-thumbnail img-responsive" /></a>';
       };
     })

     ->addColumn('image4', function ($itemdata) {
        if ($itemdata->image4 == null) {
          return '<a class="fancybox" rel="group" href="//assets/img/thumbnail.png"><img src="../assets/img/thumbnail.jpg" class="img-thumbnail img-responsive" /></a>';
        }else{
        return '<a class="fancybox" rel="group" href="../uploads/family-card/'.$itemdata->image4.'"><img src="../uploads/family-card/thumbnail/'.$itemdata->image4.'" class="img-thumbnail img-responsive" /></a>';
      };
    })

    ->addColumn('image5', function ($itemdata) {
        if ($itemdata->image5 == null) {
          return '<a class="fancybox" rel="group" href="//assets/img/thumbnail.png"><img src="../assets/img/thumbnail.jpg" class="img-thumbnail img-responsive" /></a>';
        }else{
        return '<a class="fancybox" rel="group" href="../uploads/family-card/'.$itemdata->image5.'"><img src="../uploads/family-card/thumbnail/'.$itemdata->image5.'" class="img-thumbnail img-responsive" /></a>';
      };
    })


      ->addColumn('image6', function ($itemdata) {
          if ($itemdata->image6 == null) {
            return '<a class="fancybox" rel="group" href="//assets/img/thumbnail.png"><img src="../assets/img/thumbnail.jpg" class="img-thumbnail img-responsive" /></a>';
          }else{
          return '<a class="fancybox" rel="group" href="../uploads/family-card/'.$itemdata->image6.'"><img src="../uploads/family-card/thumbnail/'.$itemdata->image6.'" class="img-thumbnail img-responsive" /></a>';
        };
      })


       ->addColumn('ipl_tarif_unique_code', function ($itemdata) {
        $ipl_amount = $itemdata->ipl_tarif + $itemdata->unique_code;

        return $ipl_amount;
      })

        ->addColumn('mstatus', function ($itemdata) {
          if ($itemdata->status == 0) {
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

    public function data_member(Request $request, $id)
    {
      if($request->ajax()){

        // $itemdata = FamilyCard::all();
        $sql = 'SELECT
                  *
                FROM
                  family_card_details
                WHERE family_card_details.family_card_id = '.$id.' ';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

        return Datatables::of($itemdata)

        ->addColumn('action', function ($itemdata) {
          return '<a  href="javascript:void(0)" title="Hapus" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->full_name."'".')" class="btn btn-danger btn-xs"> <i class="ti-trash"></i></a>';
        })

        ->make(true);
      } else {
        exit("No data available");
      }
    }

    public function create()
    {
      $rt_list = RT::all()->pluck('rt_name', 'id');
      $house_type_list = HouseType::all()->pluck('house_type_name', 'id');

      return view ('editor.family_card.form', compact('rt_list', 'house_type_list'));
    }


    public function store(Request $request)
    {

      $family_card = new FamilyCard;
      $family_card->no = $request->input('no');
      $family_card->nip = $request->input('nip');
      $family_card->name = $request->input('name');
      $family_card->address = $request->input('address');
      $family_card->rt_id = $request->input('rt_id');
      $family_card->village = $request->input('village');
      $family_card->sub_district = $request->input('sub_district');
      $family_card->city = $request->input('city');
      $family_card->pos_code = $request->input('pos_code');
      $family_card->province = $request->input('province');
      $family_card->house_type_id = $request->input('house_type_id');
      $family_card->ipl_id = $request->input('ipl_id');
      $family_card->ipl_tarif = $request->input('ipl_tarif');
      $family_card->block = $request->input('block');
      $family_card->hp = $request->input('hp');
      $family_card->bill_2019 = $request->input('bill_2019');

      $family_card->description_image = $request->input('description_image');
      $family_card->description_image2 = $request->input('description_image2');
      $family_card->description_image3 = $request->input('description_image3');
      $family_card->description_image4 = $request->input('description_image4');
      $family_card->description_image5 = $request->input('description_image5');
      $family_card->description_image6 = $request->input('description_image6');

      $family_card->created_by = Auth::id();
      $family_card->save();

      if($request->image)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image->getClientOriginalExtension();
        $family_card->image = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image->getClientOriginalName());
        $request->image->move($original_directory, $family_card->image);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image);

        $family_card->save();
      }

      if($request->image2)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image2->getClientOriginalExtension();
        $family_card->image2 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image2->getClientOriginalName());
        $request->image2->move($original_directory, $family_card->image2);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image2);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image2);

        $family_card->save();
      }



      if($request->image3)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image3->getClientOriginalExtension();
        $family_card->image3 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image3->getClientOriginalName());
        $request->image3->move($original_directory, $family_card->image3);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image3);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image3);

        $family_card->save();
      }


      if($request->image4)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image4->getClientOriginalExtension();
        $family_card->image4 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image4->getClientOriginalName());
        $request->image4->move($original_directory, $family_card->image4);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image4);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image4);

        $family_card->save();
      }



      if($request->image5)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image5->getClientOriginalExtension();
        $family_card->image5 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image5->getClientOriginalName());
        $request->image5->move($original_directory, $family_card->image5);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image5);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image5);

        $family_card->save();
      }


      if($request->image6)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image6->getClientOriginalExtension();
        $family_card->image6 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image6->getClientOriginalName());
        $request->image6->move($original_directory, $family_card->image6);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image6);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image6);

        $family_card->save();
      }

        return redirect('editor/family-card');

      }

      // public function store_member(Request $request, $id)
      // {
      //   $validator = Validator::make(Input::all(), $this->rules);
      //   if ($validator->fails()) {
      //       return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      //   } else {
      //     $post = new HouseType();
      //     $post->house_type_name = $request->house_type_name;
      //     // $post->ipl_tarif = $request->ipl_tarif;
      //     $post->description = $request->description;
      //     $post->status = $request->status;
      //     $post->created_by = Auth::id();
      //     $post->save();

      //     return response()->json($post);
      //   }
      // }

       public function edit($id)
       {
        $family_card = FamilyCard::Find($id);


        $rt_list = RT::all()->pluck('rt_name', 'id');
        $house_type_list = HouseType::all()->pluck('house_type_name', 'id');

        return view ('editor.family_card.form', compact('rt_list', 'house_type_list', 'family_card'));
      }


     public function member($id)
     {
       $family_card = FamilyCard::Find($id);

       $rt_list = RT::all()->pluck('rt_name', 'id');
       $house_type_list = HouseType::all()->pluck('house_type_name', 'id');

       return view ('editor.family_card.member', compact('rt_list', 'house_type_list', 'family_card'));
     }

     public function ipl($id)
     {
      $family_card = FamilyCard::Find($id);
      $rt_list = RT::all()->pluck('rt_name', 'id');
      $house_type_list = HouseType::all()->pluck('house_type_name', 'id');

      $sql = 'SELECT
                ipl.`id`,
                ipl.`status`,
                ipl_period.`period_name`,
                ipl_period.`month`,
                ipl_period.`year`,
                ipl.period_id,
                family_cards.`name`,
                rts.rt_name,
                house_types.house_type_name,
                FORMAT(ipl.ipl_tarif,0) AS ipl_tarif,
                family_cards.ipl_id,
                family_cards.block,
                family_cards.hp,
                family_cards.`no`,
                family_cards.nip
              FROM
                ipl
              LEFT JOIN ipl_period ON ipl.period_id = ipl_period.id
              LEFT JOIN family_cards ON ipl.family_card_id = family_cards.id
              LEFT JOIN rts ON family_cards.rt_id = rts.id
              LEFT JOIN house_types ON family_cards.house_type_id = house_types.id
              WHERE family_cards.id = '.$id.'';
      $data_ipl = DB::table(DB::raw("($sql) as rs_sql"))->get();

      $sql_period = 'SELECT
                *
              FROM
                ipl_period
              WHERE ipl_period.id NOT IN (SELECT period_id FROM ipl WHERE family_card_id = '.$id.' )';
      $data_ipl_period = DB::table(DB::raw("($sql_period) as rs_sql_period"))->get();

      return view ('editor.family_card.ipl', compact('rt_list', 'house_type_list', 'family_card', 'data_ipl', 'data_ipl_period'));
    }

    public function store_ipl($id, Request $request)
     {
        $period = IPLPeriod::where('id', $request->input('period_id'))->first();
        $family_card = FamilyCard::where('id', $id)->first();

        $ipl = New IPL;
        $ipl->period_id = $period->id;
        $ipl->month = $period->month;
        $ipl->year = $period->year;
        $ipl->family_card_id = $family_card->id;
        $ipl->family_card_name = $family_card->name;
        $ipl->ipl_tarif = $family_card->ipl_tarif + $family_card->unique_code;
        $ipl->save();

        return redirect()->back();
     }

     public function store_member($id, Request $request)
     {
       $post = new FamilyCardDetail;
       $post->family_card_id = $id;
       $post->full_name = $request->full_name;
       $post->nik = $request->nik;
       $post->gender = $request->gender;
       $post->place_birth = $request->place_birth;
       $post->date_birth = $request->date_birth;
       $post->religion = $request->religion;
       $post->education = $request->education;
       $post->job = $request->job;
       $post->blood = $request->blood;
       $post->marital_status = $request->marital_status;
       $post->marital_date = $request->marital_date;
       $post->family_relation = $request->family_relation;
       $post->cityzen = $request->cityzen;
       $post->paspor_no = $request->paspor_no;
       $post->kit_no = $request->kit_no;
       $post->father = $request->father;
       $post->mother = $request->mother;
       $post->save();

       return response()->json($post);
     }

      public function update($id, Request $request)
      {

        $family_card = FamilyCard::Find($id);
        $family_card->no = $request->input('no');
        $family_card->nip = $request->input('nip');
        $family_card->name = $request->input('name');
        $family_card->address = $request->input('address');
        $family_card->rt_id = $request->input('rt_id');
        $family_card->village = $request->input('village');
        $family_card->sub_district = $request->input('sub_district');
        $family_card->city = $request->input('city');
        $family_card->pos_code = $request->input('pos_code');
        $family_card->province = $request->input('province');
        $family_card->house_type_id = $request->input('house_type_id');
        $family_card->ipl_id = $request->input('ipl_id');
        $family_card->ipl_tarif = $request->input('ipl_tarif');
        $family_card->block = $request->input('block');
        $family_card->hp = $request->input('hp');
        $family_card->bill_2019 = $request->input('bill_2019');

        $family_card->description_image = $request->input('description_image');
        $family_card->description_image2 = $request->input('description_image2');
        $family_card->description_image3 = $request->input('description_image3');
        $family_card->description_image4 = $request->input('description_image4');
        $family_card->description_image5 = $request->input('description_image5');
        $family_card->description_image6 = $request->input('description_image6');

        $family_card->created_by = Auth::id();
        $family_card->save();

        if($request->image)
        {
          $family_card = FamilyCard::FindOrFail($family_card->id);
          $original_directory = "uploads/family-card/";

        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          }

          //$file_extension = $request->image->getClientOriginalExtension();
          $family_card->image = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image->getClientOriginalName());
          $request->image->move($original_directory, $family_card->image);

          $thumbnail_directory = $original_directory."thumbnail/";
          if(!File::exists($thumbnail_directory))
            {
              File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
            }
            $thumbnail = Image::make($original_directory.$family_card->image);
            $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image);

            $family_card->save();
        }


      if($request->image2)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

        if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image2->getClientOriginalExtension();
        $family_card->image2 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image2->getClientOriginalName());
        $request->image2->move($original_directory, $family_card->image2);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image2);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image2);

        $family_card->save();
      }



      if($request->image3)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image3->getClientOriginalExtension();
        $family_card->image3 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image3->getClientOriginalName());
        $request->image3->move($original_directory, $family_card->image3);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image3);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image3);

        $family_card->save();
      }


      if($request->image4)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image4->getClientOriginalExtension();
        $family_card->image4 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image4->getClientOriginalName());
        $request->image4->move($original_directory, $family_card->image4);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image4);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image4);

        $family_card->save();
      }



      if($request->image5)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image5->getClientOriginalExtension();
        $family_card->image5 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image5->getClientOriginalName());
        $request->image5->move($original_directory, $family_card->image5);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image5);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image5);

        $family_card->save();
      }



      if($request->image6)
      {
        $family_card = FamilyCard::FindOrFail($family_card->id);

        $original_directory = "uploads/family-card/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image6->getClientOriginalExtension();
        $family_card->image6 = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image6->getClientOriginalName());
        $request->image6->move($original_directory, $family_card->image6);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
          }
        $thumbnail = Image::make($original_directory.$family_card->image6);
        $thumbnail->fit(10,10)->save($thumbnail_directory.$family_card->image6);

        $family_card->save();
      }

      return redirect('editor/family-card');

    }

    public function delete($id)
    {
      $post =  FamilyCard::Find($id);
      $post->delete();
      return response()->json($post);
    }

    public function delete_member($id)
    {
      $post =  FamilyCardDetail::Find($id);
      $post->delete();
      return response()->json($post);
    }

    public function deletebulk(Request $request)
    {
    $idkey = $request->idkey;
    foreach($idkey as $key => $id)
    {
      $post = FamilyCard::Find($id["1"]);
      $post->delete();
      }
      echo json_encode(array("status" => TRUE));
    }

}
