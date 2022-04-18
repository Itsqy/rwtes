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
use App\Http\Requests\EmployeeRequest;
use App\Http\Controllers\Controller;
use App\Model\Employee; 
use App\Model\Position;
use App\Model\Department;
use App\Model\City;
use App\Model\Sex;
use App\Model\TaxStatus;
use App\Model\Golongan;
use App\Model\PayrollType;
use App\Model\Religion; 
use App\Model\EducationLevel;
use App\Model\EducationMajor;
use App\Model\EmployeeStatus;
use App\Model\MaritalStatus;
use App\Model\TerminationType;
use App\Model\OvertimeType;
use App\Model\BasicLog;
use App\Model\Overtime;
use App\Model\StaffStatus;
use App\Model\Confederation;
use App\Model\ShiftGroup;
use Validator;
use Response;
use App\Post;
use View;
use Intervention\Image\Facades\Image;
use Excel;
// use Slack;
// use Client;


class EmployeeController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [ 
    'employeename' => 'required|min:2'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      return view ('editor.employee.index');
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
        employee.id,
        employee.nik,
        employee.identity_no,
        employee.employee_name,
        employee.nick_name,
        employee.place_birth,
        employee.address,
        employee.position_id,
        position.position_name,
        employee.department_id,
        employee.image,
        employee.staff_status_id,
        staff_status.staff_status_name,
        employee.`status`,
        department.department_name,
        city.city_name,
        employee.npwp,
        employee.tax_status,
        employee.education_level_id,
        employee.confederation,
        education_level.education_level_name,
        date_format(employee.join_date, "%d/%m/%Y") AS join_date,
        CASE WHEN employee.employee_status_id = 2 THEN "" ELSE date_format(employee.term_date, "%d/%m/%Y") END AS term_date,
        date_format(employee.date_birth, "%d/%m/%Y") AS date_birth,
        date_format(DATE_ADD(employee.date_birth, INTERVAL 672 MONTH), "%d/%m/%Y")  AS pension_date,
        date_format(employee.pension_date, "%d/%m/%Y") AS pension_date_manual,
        payroll_type.payroll_type_name,
        employee.bank_account,
        FORMAT(employee.basic,0) AS basic,
        employee.bank_name,
        employee.bank_branch,
        employee.bank_an,
        employee.jamsostek_member,
        employee.sex,
        CASE
        WHEN employee.sex = 1 THEN
        "Laki-laki"
        ELSE
        "Perempuan"
        END AS gender
        FROM
        employee
        LEFT JOIN department ON employee.department_id = department.id
        LEFT JOIN position ON employee.position_id = position.id
        LEFT JOIN city ON employee.city_id = city.id
        LEFT JOIN education_level ON employee.education_level_id = education_level.id
        LEFT JOIN payroll_type ON employee.payroll_type_id = payroll_type.id
        LEFT JOIN staff_status ON employee.staff_status_id = staff_status.id
        WHERE
        (employee.deleted_at IS NULL) AND (employee.status = 0  OR employee.status IS NULL)';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('employee_name', 'ASC')->get(); 

        return Datatables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
          return '<a href="employee/'.$itemdata->id.'/edit" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a href="employee/'.$itemdata->id.'/view" title="View" class="btn btn-warning btn-xs"> <i class="ti-eye"></i> View</a>  <a  href="javascript:void(0)" title="Hapus" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->employee_name."'".')" class="btn btn-danger btn-xs"> <i class="ti-trash"></i> Hapus</a>';
        })

        ->addColumn('image', function ($itemdata) {
          if ($itemdata->image == null) {
            return '<a class="fancybox" rel="group" href="//assets/img/thumbnail.png"><img src="../assets/img/thumbnail.jpg" class="img-thumbnail img-responsive" /></a>';
          }else{
           return '<a class="fancybox" rel="group" href="../uploads/employee/'.$itemdata->image.'"><img src="../uploads/employee/thumbnail/'.$itemdata->image.'" class="img-thumbnail img-responsive" /></a>';
         };
       })

        ->addColumn('gender_icon', function ($itemdata) {
          if ($itemdata->sex == 1) {
            return '<span class="label label-primary" style="background-color:#428bca !important"> <i class="fa fa-male"></i> M</span>';
          }else{
           return '<span class="label label-primary" style="background-color:#ef9292 !important"><i class="fa fa-female"></i> F</span>';
         };
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

    public function create()
    { 

      $department_list = Department::all()->pluck('department_name', 'departmentcode');
      $position_list = Position::all()->pluck('position_name', 'id'); 
      $sex_list = Sex::all()->pluck('sex_name', 'id');
      $tax_status_list = TaxStatus::all()->pluck('tax_status', 'id');
      $payroll_type_list = PayrollType::all()->pluck('payroll_type_name', 'id');
      $religion_list = Religion::all()->pluck('religion_name', 'id');
      $city_list = City::all()->pluck('city_name', 'id');
      $education_level_list = EducationLevel::all()->pluck('education_level_name', 'id');
      $education_major_list = EducationMajor::all()->pluck('education_major_name', 'id');
      $employee_shift_list = array('1' => 'Yes', '0' => 'No');
      $marital_status_list = MaritalStatus::all()->pluck('marital_status_name', 'id'); 
      $employee_status_list = EmployeeStatus::all()->pluck('employee_status_name', 'id'); 
      $overtime_type_list = OvertimeType::all()->pluck('overtimetypename', 'id'); 
      $staff_status_list = StaffStatus::all()->pluck('staff_status_name', 'id'); 
      $shift_group_list = ShiftGroup::all()->pluck('shift_group_name', 'id'); 

      return view ('editor.employee.form', compact('department_list', 'position_list','city_list', 'sex_list', 'tax_status_list', 'payroll_type_list','religion_list','city_list', 'education_level_list', 'education_major_list', 'employee_shift_list', 'marital_status_list', 'employee_status_list', 'overtime_type_list', 'staff_status_list', 'shift_group_list'));
    }


    public function store(Request $request)
    { 

      $date_array_birth = explode("-",$request->input('date_birth')); // split the array
      $var_day_birth = $date_array_birth[0]; //day seqment
      $var_month_birth = $date_array_birth[1]; //month segment
      $var_year_birth = $date_array_birth[2]; //year segment
      $date_format_birth = "$var_year_birth-$var_month_birth-$var_day_birth"; // join them together


      $date_array_join = explode("-",$request->input('join_date')); // split the array
      $var_day_join = $date_array_join[0]; //day seqment
      $var_month_join = $date_array_join[1]; //month segment
      $var_year_join = $date_array_join[2]; //year segment
      $date_format_join = "$var_year_join-$var_month_join-$var_day_join"; // join them together


      $date_array_term = explode("-",$request->input('term_date')); // split the array
      $var_day_term = $date_array_term[0]; //day seqment
      $var_month_term = $date_array_term[1]; //month segment
      $var_year_term = $date_array_term[2]; //year segment
      $date_format_term = "$var_year_term-$var_month_term-$var_day_term"; // join them together


      // $date_array_pension = explode("-",$request->input('pension_date')); // split the array
      // $var_day_pension = $date_array_pension[0]; //day seqment
      // $var_month_pension = $date_array_pension[1]; //month segment
      // $var_year_pension = $date_array_pension[2]; //year segment
      // $date_format_pension = "$var_year_pension-$var_month_pension-$var_day_pension"; // join them together

        
      $employee = new Employee; 
      $employee->identity_no = $request->input('identity_no');
      $employee->nik = $request->input('nik');
      $employee->employee_name = $request->input('employee_name');
      $employee->nick_name = $request->input('nick_name'); 
      $employee->date_birth = $date_format_birth; 
      $employee->join_date = $date_format_join; 
      $employee->term_date = $date_format_term; 
      // $employee->pension_date = $date_format_pension; 
      $employee->insurance_no = $request->input('insurance_no'); 
      $employee->npwp = $request->input('npwp'); 
      $employee->address = $request->input('address'); 
      $employee->hp = $request->input('hp'); 
      $employee->rt = $request->input('rt'); 
      $employee->rw = $request->input('rw'); 
      $employee->email = $request->input('email'); 
      $employee->telp_1 = $request->input('telp_1'); 
      $employee->bank_an = $request->input('bank_an'); 
      $employee->bank_account = $request->input('bank_account'); 
      $employee->bank_name = $request->input('bank_name'); 
      $employee->bank_branch = $request->input('bank_branch'); 
      $employee->city_id = $request->input('city_id'); 
      $employee->sex = $request->input('sex'); 
      $employee->tax_status = $request->input('tax_status'); 
      $employee->department_id = $request->input('department_id'); 
      $employee->position_id = $request->input('position_id'); 
      $employee->payroll_type_id = $request->input('payroll_type_id'); 
      $employee->religion_id = $request->input('religion_id'); 
      $employee->place_birth = $request->input('place_birth'); 
      $employee->education_level_id = $request->input('education_level_id'); 
      $employee->marital_status_id = $request->input('marital_status_id'); 
      $employee->employee_status_id = $request->input('employee_status_id'); 
      $employee->emergency_contact_name = $request->input('emergency_contact_name'); 
      $employee->emergency_contact_phone = $request->input('emergency_contact_phone'); 
      $employee->emergency_address = $request->input('emergency_address'); 
      $employee->emergency_status = $request->input('emergency_status'); 
      $employee->staff_status_id = $request->input('staff_status_id'); 
      $employee->shift_group_id = $request->input('shift_group_id'); 
      $employee->confederation = $request->input('confederation'); 
      $employee->kelurahan = $request->input('kelurahan'); 
      $employee->kecamatan = $request->input('kecamatan'); 
      $employee->basic = $request->input('basic'); 
      $employee->meal_trans_all = $request->input('meal_trans_all');  
      $employee->created_by = Auth::id();
      $employee->save();

      if($request->image)
      {
        $employee = Employee::FindOrFail($employee->id);

        $original_directory = "uploads/employee/";

        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          }

          //$file_extension = $request->image->getClientOriginalExtension();
          $employee->image = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image->getClientOriginalName());
          $request->image->move($original_directory, $employee->image);

          $thumbnail_directory = $original_directory."thumbnail/";
          if(!File::exists($thumbnail_directory))
            {
             File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
           }
           $thumbnail = Image::make($original_directory.$employee->image);
           $thumbnail->fit(10,10)->save($thumbnail_directory.$employee->image);

           $employee->save(); 
         }

         // return redirect('editor/employeefamily/'.$employee->id.''); 
         return redirect('editor/employee'); 

       }

       public function edit($id)
       { 
        $employee = Employee::Find($id);  

        $basic_amt = number_format($employee->basic,0);
        $meal_amt = number_format($employee->mealtrans_all,0);
        $transportall_amt = number_format($employee->transport_all,0);
        $overtimeall_amt = number_format($employee->overtime_all,0);
        $insentive_amt = number_format($employee->insentive,0);

        $department_list = Department::all()->pluck('department_name', 'departmentcode');
        $position_list = Position::all()->pluck('position_name', 'id'); 
        $sex_list = Sex::all()->pluck('sex_name', 'id');
        $tax_status_list = TaxStatus::all()->pluck('tax_status', 'id');
        $payroll_type_list = PayrollType::all()->pluck('payroll_type_name', 'id');
        $religion_list = Religion::all()->pluck('religion_name', 'id');
        $city_list = City::all()->pluck('city_name', 'id');
        $education_level_list = EducationLevel::all()->pluck('education_level_name', 'id');
        $education_major_list = EducationMajor::all()->pluck('education_major_name', 'id');
        $employee_shift_list = array('1' => 'Yes', '0' => 'No');
        $marital_status_list = MaritalStatus::all()->pluck('marital_status_name', 'id'); 
        $employee_status_list = EmployeeStatus::all()->pluck('employee_status_name', 'id'); 
        $overtime_type_list = OvertimeType::all()->pluck('overtimetypename', 'id'); 
        $staff_status_list = StaffStatus::all()->pluck('staff_status_name', 'id'); 
        $shift_group_list = ShiftGroup::all()->pluck('shift_group_name', 'id'); 

        return view ('editor.employee.form', compact('department_list', 'position_list','city_list', 'sex_list', 'tax_status_list', 'payroll_type_list','religion_list','city_list', 'education_level_list', 'education_major_list', 'employee_shift_list', 'marital_status_list', 'employee_status_list', 'overtime_type_list', 'staff_status_list', 'shift_group_list', 'employee'));
      }

      public function update($id, Request $request)
      { 

        $date_array_birth = explode("-",$request->input('date_birth')); // split the array
        $var_day_birth = $date_array_birth[0]; //day seqment
        $var_month_birth = $date_array_birth[1]; //month segment
        $var_year_birth = $date_array_birth[2]; //year segment
        $date_format_birth = "$var_year_birth-$var_month_birth-$var_day_birth"; // join them together


        $date_array_join = explode("-",$request->input('join_date')); // split the array
        $var_day_join = $date_array_join[0]; //day seqment
        $var_month_join = $date_array_join[1]; //month segment
        $var_year_join = $date_array_join[2]; //year segment
        $date_format_join = "$var_year_join-$var_month_join-$var_day_join"; // join them together


        $date_array_term = explode("-",$request->input('term_date')); // split the array
        $var_day_term = $date_array_term[0]; //day seqment
        $var_month_term = $date_array_term[1]; //month segment
        $var_year_term = $date_array_term[2]; //year segment
        $date_format_term = "$var_year_term-$var_month_term-$var_day_term"; // join them together


        $date_array_pension = explode("-",$request->input('pension_date')); // split the array
        $var_day_pension = $date_array_pension[0]; //day seqment
        $var_month_pension = $date_array_pension[1]; //month segment
        $var_year_pension = $date_array_pension[2]; //year segment
        $date_format_pension = "$var_year_pension-$var_month_pension-$var_day_pension"; // join them together


        $employee = Employee::Find($id);
        $employee->identity_no = $request->input('identity_no');
        $employee->nik = $request->input('nik');
        $employee->employee_name = $request->input('employee_name');
        $employee->nick_name = $request->input('nick_name'); 
        $employee->date_birth = $date_format_birth; 
        $employee->join_date = $date_format_join; 
        $employee->term_date = $date_format_term; 
        $employee->pension_date = $date_format_pension; 
        $employee->insurance_no = $request->input('insurance_no'); 
        $employee->npwp = $request->input('npwp'); 
        $employee->address = $request->input('address'); 
        $employee->hp = $request->input('hp'); 
        $employee->rt = $request->input('rt'); 
        $employee->rw = $request->input('rw'); 
        $employee->email = $request->input('email'); 
        $employee->telp_1 = $request->input('telp_1'); 
        $employee->bank_an = $request->input('bank_an'); 
        $employee->bank_account = $request->input('bank_account'); 
        $employee->bank_name = $request->input('bank_name'); 
        $employee->bank_branch = $request->input('bank_branch'); 
        $employee->city_id = $request->input('city_id'); 
        $employee->sex = $request->input('sex'); 
        $employee->tax_status = $request->input('tax_status'); 
        $employee->department_id = $request->input('department_id'); 
        $employee->position_id = $request->input('position_id'); 
        $employee->payroll_type_id = $request->input('payroll_type_id'); 
        $employee->religion_id = $request->input('religion_id'); 
        $employee->place_birth = $request->input('place_birth'); 
        $employee->education_level_id = $request->input('education_level_id'); 
        $employee->marital_status_id = $request->input('marital_status_id'); 
        $employee->employee_status_id = $request->input('employee_status_id'); 
        $employee->emergency_contact_name = $request->input('emergency_contact_name'); 
        $employee->emergency_contact_phone = $request->input('emergency_contact_phone'); 
        $employee->emergency_address = $request->input('emergency_address'); 
        $employee->emergency_status = $request->input('emergency_status'); 
        $employee->staff_status_id = $request->input('staff_status_id'); 
        $employee->shift_group_id = $request->input('shift_group_id'); 
        $employee->confederation = $request->input('confederation'); 
        $employee->status = $request->input('status'); 
        $employee->basic = $request->input('basic'); 
        $employee->meal_trans_all = $request->input('meal_trans_all'); 
        $employee->transport_all = $request->input('transport_all'); 
        $employee->insentive_all = $request->input('insentive_all'); 
        $employee->kelurahan = $request->input('kelurahan'); 
        $employee->kecamatan = $request->input('kecamatan'); 
        $employee->basic = $request->input('basic'); 
        $employee->meal_trans_all = $request->input('meal_trans_all'); 
        $employee->updated_by = Auth::id();
        $employee->save();

      if($request->image)
      {
        $employee = Employee::FindOrFail($employee->id);

        $original_directory = "uploads/employee/";

      if(!File::exists($original_directory))
      {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      }

      // $file_extension = $request->image->getClientOriginalExtension();
        $employee->image = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image->getClientOriginalName());
        $request->image->move($original_directory, $employee->image);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
           File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
         }
         $thumbnail = Image::make($original_directory.$employee->image);
         $thumbnail->fit(10,10)->save($thumbnail_directory.$employee->image);

         $employee->save(); 
       } 
 

        // Instantiate with defaults, so all messages created
        // will be sent from 'Cyril' and to the #accounting channel
        // by default. Any names like @regan or #channel will also be linked.
        $settings = [
          'username' => 'Admin Spinel',
          'channel' => '#spinel-hr',
          'link_names' => true
        ];

        // $client = new \Maknz\Slack\Client('https://hooks.slack.com/services/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', $settings);

        $client->send('Edit karyawan atas nama '.$employee->employee_name.'.');

        switch($request->save) {
            case 'save': 
                return redirect('editor/employee'); 
            break;

            case 'saveadd': 
                return redirect('editor/employee/create'); 
                // return redirect()->back();
            break;
        }
     }


    public function view($id)
       { 
        // $employee = Employee::Find($id);  

        $sql = 'SELECT
        employee.id,
        employee.nik,
        employee.identity_no,
        employee.employee_name,
        employee.nick_name,
        employee.place_birth,
        employee.address,
        employee.position_id,
        position.position_name,
        employee.department_id,
        employee.image,
        employee.rt,
        employee.rw,
        employee.email,
        employee.hp,
        employee.telp_1,
        employee.kelurahan,
        employee.kecamatan,
        employee.staff_status_id,
        staff_status.staff_status_name,
        employee.`status`,
        department.department_name,
        city.city_name,
        employee.npwp,
        -- employee.tax_status,
        employee.education_level_id,
        employee.confederation,
        employee.meal_trans_all AS mealtrans_all,
        employee.transport_all AS transport_all,
        employee.overtime_all AS overtime_all,
        employee.allowance AS insentive,
        education_level.education_level_name,
        employee.join_date AS join_date,
        CASE WHEN employee.employee_status_id = 2 THEN "" ELSE employee.term_date END AS term_date,
        employee.date_birth AS date_birth,
        DATE_ADD(employee.date_birth, INTERVAL 672 MONTH)  AS pension_date,
        employee.pension_date AS pension_date_manual,
        payroll_type.payroll_type_name,
        employee.bank_account,
        employee.basic AS basic,
        employee.bank_name,
        employee.bank_branch,
        employee.bank_an,
        employee.jamsostek_member,
        employee.insurance_no,
        employee.bpjs_tk_no,
        employee.bpjs_kesehatan_no,
        marital_status.marital_status_name,
        employee_status.employee_status_name,
        ptkp.tax_status,
        religion.religion_name,
        employee.sex,
        CASE
        WHEN employee.sex = 1 THEN
        "Laki-laki"
        ELSE
        "Perempuan"
        END AS gender
        FROM
        employee
        LEFT JOIN department ON employee.department_id = department.id
        LEFT JOIN position ON employee.position_id = position.id
        LEFT JOIN city ON employee.city_id = city.id
        LEFT JOIN education_level ON employee.education_level_id = education_level.id
        LEFT JOIN payroll_type ON employee.payroll_type_id = payroll_type.id
        LEFT JOIN staff_status ON employee.staff_status_id = staff_status.id
        LEFT JOIN marital_status ON employee.marital_status_id = marital_status.id
        LEFT JOIN employee_status ON employee.employee_status_id = employee_status.id
        LEFT JOIN ptkp ON employee.tax_status = ptkp.id
        LEFT JOIN religion ON employee.religion_id = religion.id
        WHERE
        employee.id = '.$id.'';
        $employee = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('employee_name', 'ASC')->first(); 



        $basic_amt = number_format($employee->basic,0);
        $meal_amt = number_format($employee->mealtrans_all,0);
        $transportall_amt = number_format($employee->transport_all,0);
        $overtimeall_amt = number_format($employee->overtime_all,0);
        $insentive_amt = number_format($employee->insentive,0);

        $department_list = Department::all()->pluck('department_name', 'departmentcode');
        $position_list = Position::all()->pluck('position_name', 'id'); 
        $sex_list = Sex::all()->pluck('sex_name', 'id');
        $tax_status_list = TaxStatus::all()->pluck('tax_status', 'id');
        $payroll_type_list = PayrollType::all()->pluck('payroll_type_name', 'id');
        $religion_list = Religion::all()->pluck('religionname', 'id');
        $city_list = City::all()->pluck('city_name', 'id');
        $education_level_list = EducationLevel::all()->pluck('education_level_name', 'id');
        $education_major_list = EducationMajor::all()->pluck('education_major_name', 'id');
        $employee_shift_list = array('1' => 'Yes', '0' => 'No');
        $marital_status_list = MaritalStatus::all()->pluck('marital_status_name', 'id'); 
        $employee_status_list = EmployeeStatus::all()->pluck('employee_status_name', 'id'); 
        $overtime_type_list = OvertimeType::all()->pluck('overtimetypename', 'id'); 
        $staff_status_list = StaffStatus::all()->pluck('staff_status_name', 'id'); 



        return view ('editor.employee.view', compact('department_list', 'position_list','city_list', 'sex_list', 'tax_status_list', 'payroll_type_list','religion_list','city_list', 'education_level_list', 'education_major_list', 'employee_shift_list', 'marital_status_list', 'employee_status_list', 'overtime_type_list', 'staff_status_list', 'employee'));
      }


    public function resign($id)
    {
      $employee = Employee::Find($id);
      echo json_encode($employee); 
    }

    public function storeresign(Request $request, $id)
    {  
      $post = new Employeeresign(); 
      $post->employeeid = $id; 
      $post->dateresign = $request->dateresign;
      $post->terminationtype = $request->terminationtype;
      $post->note = $request->note;
      $post->created_by = Auth::id();
      $post->save();

      $post = Employee::where('id', $id)->first(); 
      $post->status = 9;  
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }  

    public function delete($id)
     {
      $post =  Employee::Find($id);
      $post->delete(); 
      return response()->json($post); 
    }

  public function deletebulk(Request $request)
  {
   $idkey = $request->idkey;   
   foreach($idkey as $key => $id)
   { 
    $post = Employee::Find($id["1"]);
    $post->delete(); 
    }
    echo json_encode(array("status" => TRUE));
  }

  public function storeexport(Request $request, $type)
  {

    $userid = Auth::id();
    $sql = 'SELECT
              employee.nik,
              employee.identityno AS identity_no,
              employee.employeename AS employee_name,
              employee.nickname AS nick_name,
              employee.placebirth AS plach_birth,
              employee.datebirth AS date_birth,
              employee.address,
              employee.npwp,
              employee.tax_status AS tax_status,
              employee.joindate AS join_date,
              employee.termdate AS term_date,
              employee.bankname AS bank_name,
              employee.bankbranch AS bank_branch,
              employee.bankan AS bank_an,
              employee.gol AS golongan,
              employee.sex,
              employee.basic,
              employee.rt,
              employee.rw,
              employee.kelurahan,
              employee.kecamatan,
              employee.blood,
              employee.pensiondate AS pension_date,
              employee.insuranceno AS insurance_no,
              employee.postall AS position_allowance,
              employee.allowance,
              employee.mealtransall AS meal_transport_allowance,
              employee.bank_account AS bank_account,
              employee.hp,
              employee.telp_1 AS telp_1,
              employee.telp_2 AS telp_2,
              employee.bpjs_tk_no AS bpjs_tk_no,
              employee.bpjs_kesehatan_no AS bpjs_kesehatan_no
            FROM
              employee 
            LIMIT 1';

    $data = DB::table(DB::raw("($sql) as rs_sql"))->get();
    // dd($data);
    $data = collect($data)->map(function($x){ return (array) $x; })->toArray();
    return Excel::create('employee', function($excel) use ($data) {
      $excel->sheet('sheet1', function($sheet) use ($data)
      {
        $sheet->fromArray($data);
      });
    })->download($type);
  }


  public function storeimport(Request $request)
  { 

    if($request->hasFile('import_file')){
      $path = $request->file('import_file')->getRealPath();
      $data = Excel::load($path, function($reader) {})->get();

      if(!empty($data) && $data->count()){
        foreach ($data->toArray() as $key => $value) {
          if(!empty($value)){
            foreach ($value as $v) {

              $insert[] = ['nik' => $v['nik'], 'identityno' => $v['identity_no'], 'employeename' => $v['employee_name'], 'nickname' => $v['nick_name'], 'placebirth' => $v['plach_birth'], 'datebirth' => $v['date_birth'], 'address' => $v['address'], 'npwp' => $v['npwp'], 'tax_status' => $v['tax_status'], 'joindate' => $v['join_date'], 'termdate' => $v['term_date'], 'bankname' => $v['bank_name'], 'bankbranch' => $v['bank_branch'], 'bankan' => $v['bank_an'], 'gol' => $v['golongan'], 'sex' => $v['sex'], 'basic' => $v['basic'], 'rt' => $v['rt'], 'rw' => $v['rw'], 'kelurahan' => $v['kelurahan'], 'kecamatan' => $v['kecamatan'], 'blood' => $v['blood'], 'pensiondate' => $v['pension_date'], 'insuranceno' => $v['insurance_no'], 'postall' => $v['position_allowance'], 'allowance' => $v['allowance'], 'mealtransall' => $v['meal_transport_allowance'], 'bank_account' => $v['bank_account'], 'hp' => $v['hp'], 'telp_1' => $v['telp_1'], 'telp_2' => $v['telp_2'], 'bpjs_tk_no' => $v['bpjs_tk_no'], 'bpjs_kesehatan_no' => $v['bpjs_kesehatan_no'] ];
            }
          }
        } 

        if(!empty($insert)){
          Employee::insert($insert);
          return back()->with('success','Insert Record successfully.');
        }
      }
    }
    return back()->with('error','Please Check your file, Something is wrong there.');
  }



  public function updateexport(Request $request, $type)
  {

    $userid = Auth::id();
    // $sql = 'SELECT
    //           employee.nik,
    //           employee.identityno AS identity_no,
    //           employee.employeename AS employee_name,
    //           employee.nickname AS nick_name,
    //           department.department_name,
    //           city.cityname,
    //           education_level.education_level_name,
    //           position.position_name,
    //           employeestatus.employeestatusname,
    //           employee.placebirth AS plach_birth,
    //           employee.datebirth AS date_birth,
    //           employee.address,
    //           employee.npwp,
    //           employee.tax_status AS tax_status,
    //           employee.joindate AS join_date,
    //           employee.termdate AS term_date,
    //           employee.bankname AS bank_name,
    //           employee.bankbranch AS bank_branch,
    //           employee.bankan AS bank_an,
    //           employee.gol AS golongan,
    //           employee.sex,
    //           employee.basic,
    //           employee.rt,
    //           employee.rw,
    //           employee.kelurahan,
    //           employee.kecamatan,
    //           employee.blood,
    //           employee.pensiondate AS pension_date,
    //           employee.insuranceno AS insurance_no,
    //           employee.postall AS position_allowance,
    //           employee.allowance,
    //           employee.mealtransall AS meal_transport_allowance,
    //           employee.bank_account AS bank_account,
    //           employee.hp,
    //           employee.telp_1 AS telp_1,
    //           employee.telp_2 AS telp_2,
    //           employee.bpjs_tk_no AS bpjs_tk_no,
    //           employee.bpjs_kesehatan_no AS bpjs_kesehatan_no
    //         FROM
    //           employee
    //         LEFT JOIN department ON employee.department_id = department.id
    //         LEFT JOIN position ON employee.positionid = position.id
    //         LEFT JOIN city ON employee.cityid = city.id
    //         LEFT JOIN education_level ON employee.education_level_id = education_level.id
    //         LEFT JOIN payroll_type ON employee.payroll_type_id = payroll_type.id
    //         LEFT JOIN employeestatus ON employee.employeestatusid = employeestatus.id
    //         WHERE employee.status = 0';


    $sql = 'SELECT
              employee.nik,
              employee.employeename AS employee_name, 
              employee.basic 
            FROM
              employee
            LEFT JOIN department ON employee.department_id = department.id
            LEFT JOIN position ON employee.positionid = position.id
            LEFT JOIN city ON employee.cityid = city.id
            LEFT JOIN education_level ON employee.education_level_id = education_level.id
            LEFT JOIN payroll_type ON employee.payroll_type_id = payroll_type.id
            LEFT JOIN employeestatus ON employee.employeestatusid = employeestatus.id
            WHERE employee.status = 0';

    $data = DB::table(DB::raw("($sql) as rs_sql"))->get();
    // dd($data);
    $data = collect($data)->map(function($x){ return (array) $x; })->toArray();
    return Excel::create('employee', function($excel) use ($data) {
      $excel->sheet('sheet1', function($sheet) use ($data)
      {
        $sheet->fromArray($data);
      });
    })->download($type);
  }


  public function updateimport(Request $request)
  { 
    Employeetemp::query()->truncate();
    if($request->hasFile('import_file')){
      $path = $request->file('import_file')->getRealPath();
      $data = Excel::load($path, function($reader) {})->get();

      if(!empty($data) && $data->count()){
        foreach ($data->toArray() as $key => $value) {
          if(!empty($value)){
            foreach ($value as $v) {

              // $insert[] = ['nik' => $v['nik'], 'identityno' => $v['identity_no'], 'employeename' => $v['employee_name'], 'nickname' => $v['nick_name'], 'placebirth' => $v['plach_birth'], 'datebirth' => $v['date_birth'], 'address' => $v['address'], 'npwp' => $v['npwp'], 'tax_status' => $v['tax_status'], 'joindate' => $v['join_date'], 'termdate' => $v['term_date'], 'bankname' => $v['bank_name'], 'bankbranch' => $v['bank_branch'], 'bankan' => $v['bank_an'], 'gol' => $v['golongan'], 'sex' => $v['sex'], 'basic' => $v['basic'], 'rt' => $v['rt'], 'rw' => $v['rw'], 'kelurahan' => $v['kelurahan'], 'kecamatan' => $v['kecamatan'], 'blood' => $v['blood'], 'pensiondate' => $v['pension_date'], 'insuranceno' => $v['insurance_no'], 'postall' => $v['position_allowance'], 'allowance' => $v['allowance'], 'mealtransall' => $v['meal_transport_allowance'], 'bank_account' => $v['bank_account'], 'hp' => $v['hp'], 'telp_1' => $v['telp_1'], 'telp_2' => $v['telp_2'] ];

               $insert[] = ['nik' => $v['nik'], 'employeename' => $v['employee_name'], 'basic' => $v['basic'] ];
               $insertlog[] = ['nik' => $v['nik'], 'employeename' => $v['employee_name'], 'basic' => $v['basic'], 'basiclogtype' => 'IMPORT FROM EXCEL', 'created_by' => ''.Auth::id().'', 'created_at' => ''.Carbon::now().'' ];
            }
          }
        } 

        if(!empty($insert)){
          Employeetemp::insert($insert);
          Basiclog::insert($insertlog);
          DB::insert("UPDATE employee
                      INNER JOIN (
                        SELECT
                          employeetemp.nik,
                          employeetemp.identityno,
                          employeetemp.employeename,
                          employeetemp.nickname,
                          employeetemp.placebirth,
                          employeetemp.datebirth,
                          employeetemp.address,
                          employeetemp.npwp,
                          employeetemp.tax_status,
                          employeetemp.joindate,
                          employeetemp.termdate,
                          employeetemp.bankname,
                          employeetemp.bankbranch,
                          employeetemp.bankan,
                          employeetemp.sex,
                          employeetemp.basic,
                          employeetemp.rt,
                          employeetemp.rw,
                          employeetemp.kelurahan,
                          employeetemp.kecamatan,
                          employeetemp.blood,
                          employeetemp.pensiondate,
                          employeetemp.insuranceno,
                          employeetemp.postall,
                          employeetemp.allowance,
                          employeetemp.mealtransall,
                          employeetemp.bank_account,
                          employeetemp.hp,
                          employeetemp.telp_1,
                          employeetemp.telp_2,
                          employeetemp.bpjs_tk_no,
                          employeetemp.bpjs_kesehatan_no
                        FROM
                          employeetemp
                      ) AS employeetemp SET
                       employee.employeename = employeetemp.employeename,
                       employee.basic = employeetemp.basic  
                      WHERE
                        employee.nik = employeetemp.nik");
          return back()->with('success','Insert Record successfully.');
        }
      }
    }
    return back()->with('error','Please Check your file, Something is wrong there.');
  }
}
