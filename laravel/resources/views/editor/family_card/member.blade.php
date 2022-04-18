@extends('layouts.editor.template')
@section('title', 'Edit Anggota Keluarga') 
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Edit Anggota Keluarga</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                  <li class="active">Edit Anggota Keluarga</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body"> 
                            {{ csrf_field() }}
                            <div class="form-body"> 
                                <section>
                                  <div class="row"> 
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('full_name', 'Nama Lengkap') }}
                                            {{ Form::text('full_name', old('full_name'), array('class' => 'form-control', 'placeholder' => 'Nama Lengkap*', 'required' => 'true', 'id' => 'full_name')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('nik', 'NIK') }}
                                            {{ Form::text('nik', old('nik'), array('class' => 'form-control', 'placeholder' => 'NIK', 'required' => 'true', 'id' => 'nik')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('gender', 'Jenis Kelamin') }}
                                            {{ Form::text('gender', old('gender'), array('class' => 'form-control', 'placeholder' => 'Jenis Kelamin', 'required' => 'true', 'id' => 'gender')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('place_birth', 'Tempat Lahir') }}
                                            {{ Form::text('place_birth', old('place_birth'), array('class' => 'form-control', 'placeholder' => 'Tempat Lahir', 'required' => 'true', 'id' => 'place_birth')) }}
                                        </div>
                                      </div> 
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('employeeid', 'Tanggal Lahir') }}
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>   
                                                {{ Form::text('family_card_date', date("Y-m-d", strtotime($family_card->family_card_date)), array('class' => 'form-control', 'placeholder' => 'Date Trans', 'required' => 'true', 'id' => 'date_birth', 'class' => 'form-control datepicker')) }}
                                            </div><!-- /.input group --> 
                                        </div> 
                                      </div> 
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('religion', 'Agama') }}
                                            {{ Form::text('religion', old('religion'), array('class' => 'form-control', 'placeholder' => 'Agama', 'required' => 'true', 'id' => 'religion')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('education', 'Pendidikan') }}
                                            {{ Form::text('education', old('education'), array('class' => 'form-control', 'placeholder' => 'Pendidikan', 'required' => 'true', 'id' => 'education')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('job', 'Jenis Pekerjaan') }}
                                            {{ Form::text('job', old('job'), array('class' => 'form-control', 'placeholder' => 'Jenis Pekerjaan', 'required' => 'true', 'id' => 'job')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('blood', 'Golongan Darah') }}
                                            {{ Form::text('blood', old('blood'), array('class' => 'form-control', 'placeholder' => 'Golongan Darah', 'required' => 'true', 'id' => 'blood')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('marital_status', 'Status Perkawinan') }}
                                            {{ Form::text('marital_status', old('marital_status'), array('class' => 'form-control', 'placeholder' => 'Status Perkawinan', 'required' => 'true', 'id' => 'marital_status')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('employeeid', 'Tanggal Perkawinan') }}
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>   
                                                {{ Form::text('marital_date', date("Y-m-d", strtotime($family_card->marital_date)), array('class' => 'form-control', 'placeholder' => 'Date Trans', 'required' => 'true', 'id' => 'marital_date', 'class' => 'form-control datepicker')) }}
                                            </div><!-- /.input group --> 
                                        </div> 
                                      </div> 
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('family_relation', 'Status Hub Keluarga') }}
                                            {{ Form::text('family_relation', old('family_relation'), array('class' => 'form-control', 'placeholder' => 'Status Hub Keluarga', 'required' => 'true', 'id' => 'family_relation')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('cityzen', 'Kewarganegaraan') }}
                                            {{ Form::text('cityzen', old('cityzen'), array('class' => 'form-control', 'placeholder' => 'Kewarganegaraan', 'required' => 'true', 'id' => 'cityzen')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('paspor_no', 'No Paspor') }}
                                            {{ Form::text('paspor_no', old('paspor_no'), array('class' => 'form-control', 'placeholder' => 'No Paspor', 'required' => 'true', 'id' => 'paspor_no')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('kit_no', 'No KITAP') }}
                                            {{ Form::text('kit_no', old('kit_no'), array('class' => 'form-control', 'placeholder' => 'No KITAP', 'required' => 'true', 'id' => 'kit_no')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('father', 'Ayah') }}
                                            {{ Form::text('father', old('father'), array('class' => 'form-control', 'placeholder' => 'Ayah', 'required' => 'true', 'id' => 'father')) }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('mother', 'Ibu') }}
                                            {{ Form::text('mother', old('mother'), array('class' => 'form-control', 'placeholder' => 'Ibu', 'required' => 'true', 'id' => 'mother')) }}
                                        </div>
                                      </div>

                                      <div class="col-md-12">
                                        <div class="box-footer with-border">
                                            <a href="#" onclick="saveDetail();" class="btn btn-success btn-flat pull-right"><i class="fa fa-save"></i> Simpan</a>
                                            <a href="{{ URL::route('editor.family-card.index', ['status' => '0']) }}" type="button" class="btn btn-default btn-flat pull-right" style="margin-left: 2px; margin-right: 2px"> <i class="fa fa-close"></i> Tutup</a> &nbsp; &nbsp;
                                        </div>
                                      </div>
                                </div>
                                <br>
                               </div>
                                   <div class="box-body">  
                                     <table id="dtTable" class="table table-hover" style="width:300%">
                                        <thead>
                                        <tr>   
                                            <th>Nama Lengkap</th> 
                                            <th>NIK</th> 
                                            <th>Jenis Kelamin</th> 
                                            <th>Tempat Lahir</th> 
                                            <th>Tanggal Lahir</th> 
                                            <th>Agama</th> 
                                            <th>Pendidikan</th> 
                                            <th>Jenis Pekerjaan</th> 
                                            <th>Golongan Darah</th> 
                                            <th>Status Perkawinan</th>
                                            <th>Tanggal Perkawinan</th> 
                                            <th>Status Hub Keluarga</th> 
                                            <th>Kewarganegaraan</th> 
                                            <th>No Paspor</th> 
                                            <th>No KITAP</th> 
                                            <th>Ayah</th> 
                                            <th>Ibu</th> 
                                            <th>Aksi</th> 
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table> 
                                  </div>   
                                </section>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@stop

@section('scripts') 
<script type="text/javascript">  
  var table;
  $(document).ready(function() {
      //datatables
      table = $('#dtTable').DataTable({ 
        processing: true,
        serverSide: true,
        "autoWidth": true,
        "initComplete": function (settings, json) {  
          $("#dtTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
       },
        ajax: "{{ url('editor/family-card/data-member') }}/{{$family_card->id}}", 
        columns: [    
        { data: 'full_name', name: 'full_name' },
        { data: 'nik', name: 'nik' },
        { data: 'gender', name: 'gender' },
        { data: 'place_birth', name: 'place_birth' },
        { data: 'date_birth', name: 'date_birth' },
        { data: 'religion', name: 'religion' },
        { data: 'education', name: 'education' },
        { data: 'job', name: 'job' },
        { data: 'blood', name: 'blood' },
        { data: 'marital_status', name: 'marital_status' },
        { data: 'marital_date', name: 'marital_date' },
        { data: 'family_relation', name: 'family_relation' },
        { data: 'cityzen', name: 'cityzen' },
        { data: 'paspor_no', name: 'paspor_no' },
        { data: 'kit_no', name: 'kit_no' },
        { data: 'father', name: 'father' },
        { data: 'mother', name: 'mother' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
      }); 
    });
    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function add()
    {
     $("#btnSave").attr("onclick","save()");
     $("#btnSaveAdd").attr("onclick","saveadd()");

     $('.errorMaterial UsedName').addClass('hidden');

     save_method = 'add'; 
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Asset Request'); // Set Title to Bootstrap modal title
    }  


    function saveDetail(id)
    {
     var full_name = $('#full_name').val();
     var nik =   $('#nik').val();
     var gender =   $('#gender').val(); 
     var place_birth =   $('#place_birth').val(); 
     var date_birth =   $('#date_birth').val(); 
     var religion =   $('#religion').val(); 
     var education =   $('#education').val(); 
     var job =   $('#job').val(); 
     var blood =   $('#blood').val(); 
     var marital_status =   $('#marital_status').val(); 
     var marital_date =   $('#marital_date').val(); 
     var family_relation =   $('#family_relation').val(); 
     var cityzen =   $('#cityzen').val(); 
     var paspor_no =   $('#paspor_no').val(); 
     var kit_no =   $('#kit_no').val(); 
     var father =   $('#father').val(); 
     var mother =   $('#mother').val(); 

     if(full_name == ''){
      alert("Error validarion!");
     }else{
      save_method = 'update';  

      //Ajax Load data from ajax
      $.ajax({
        url: '../../family-card/store-member/{{$family_card->id}}' ,
        type: "POST",
        data: {
          '_token': $('input[name=_token]').val(), 
          'full_name': $('#full_name').val(),
          'nik': $('#nik').val(), 
          'gender': $('#gender').val(), 
          'place_birth': $('#place_birth').val(), 
          'date_birth': $('#date_birth').val(), 
          'religion': $('#religion').val(), 
          'education': $('#education').val(), 
          'job': $('#job').val(), 
          'blood': $('#blood').val(), 
          'marital_status': $('#marital_status').val(), 
          'marital_date': $('#marital_date').val(), 
          'family_relation': $('#family_relation').val(), 
          'cityzen': $('#cityzen').val(), 
          'paspor_no': $('#paspor_no').val(), 
          'kit_no': $('#kit_no').val(), 
          'father': $('#father').val(),
          'mother': $('#mother').val()
        },
        success: function(data) { 
          location.reload();
        },
      })
    }
  };
 
  function reload_table_detail()
  {
    table_detail.ajax.reload(null, false); //reload datatable ajax 
  }

  function update_id(str, cp_d_id, debt, credit, coa_id)
  {
      clear_detail();
      console.log(debt); 

      var description = $(str).closest('tr').find('td:eq(0)').text(); 
      //var coa_id = $(str).closest('tr').find('td:eq(1)').text();  
      var debt_show = $(str).closest('tr').find('td:eq(3)').text(); 
      var credit_show = $(str).closest('tr').find('td:eq(2)').text();  

      $("#cp_d_id").val(cp_d_id);
      $("#description").val(description);
      $("#account_d_id").val(coa_id);
      $("#debt").val(debt); 
      $("#credit").val(credit); 
      $("#debt_show").val(debt_show); 
      $("#credit_show").val(credit_show);  
      $('#btn_add_detail').hide(100);
      $('#btn_update_detail').show(100); 
  };

  function delete_id(id)
  {
      //console.log(id);
      var r = confirm("Delete this data?");
      if (r == true) {   
       $.ajax({
        url : '../../family-card/delete-member/' + id,
        type: "DELETE",
        data: {
          '_token': $('input[name=_token]').val() 
        },
        success: function(data)
        { 
          var options = { 
            "positionClass": "toast-bottom-right", 
            "timeOut": 1000, 
          }; 
          reload_table();
        }, 
        error: function (jqXHR, textStatus, errorThrown)
        { 
        },
      }) 
     }
   };

   function cancel(id)
   {
    var status = {{$family_card->status}};
    if(status == 9)
    {
     var r = confirm("Open this transaction?");
   }else{
     var r = confirm("Archive this transaction?");
   };

   if (r == true) { 
    save_method = 'post';  

      //Ajax Load data from ajax
      $.ajax({
       url: '../family-card/cancel/{{$family_card->id}}' ,
       type: "POST",
       data: {
        '_token': $('input[name=_token]').val()
      },
      success: function(data) {  
          //var loc = 'cashpayment';
          if ((data.errors)) { 
            alert("Archive error!");
          } else{
            window.location.href = "{{ URL::route('editor.family-card.index', ['status' => '0']) }}";
          }
        },
      })
    }
  };

  function closetr(id)
  { 

   var r = confirm("Close this transaction?"); 
   if (r == true) { 
    save_method = 'post';  

      //Ajax Load data from ajax
      $.ajax({
       url: '../../cashpayment/close/{{$family_card->id}}' ,
       type: "POST",
       data: {
        '_token': $('input[name=_token]').val()
      },
      success: function(data) {  
          //var loc = 'cashpayment';
          if ((data.errors)) { 
            alert("Cancel error!");
          } else{
            window.location.href = "{{ URL::route('editor.family-card.index') }}";
          }
        },
      })
    }
  };

</script>

<script src="{{Config::get('constants.path.plugin')}}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
  jQuery('.mydatepicker, #date_birth').datepicker({ format: 'yyyy-mm-dd' });
  jQuery('.mydatepicker, #marital_date').datepicker({ format: 'yyyy-mm-dd' });
</script>
@stop