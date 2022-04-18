@extends('layouts.editor.template')
@section('module', 'Setting')   
@section('title', 'Edit Tagihan IPL')   
@section('required', 'errorHouseType')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">@yield('title')</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                  <li><a href="#">@yield('module')</a></li>
                  <li class="active">@yield('title')</li>
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>

      <!-- /row -->
      <div class="row">
          <div class="col-sm-12"> 
              <div class="table-responsive"> 
                <div class="col-sm-12">
                    <div class="white-box"> 
                      <div class="button-box">
                          <a href="#" onClick="history.back()" type="button" class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Kembali</a>
                          <a href="#" onClick="reload_table()" type="button" class="fcbtn btn btn-success btn-outline btn-1b waves-effect">Refresh</a> 

                          <a href="#" onClick="showslip('{{ Request::segment(2) }}');" type="button" class="fcbtn btn btn-warning btn-outline btn-1b waves-effect pull-right">?</a> 

                      </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                      <th>Aksi</th> 
                                      <th>Nama</th> 
                                      <th>Bulan</th> 
                                      <th>Tahun</th> 
                                      <th>Tarif IPL</th> 
                                      <th>Status</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </div>
</div>
@stop
@section('popup')
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" style="width:40% !important">
    <div class="modal-content">
      <form action="#" id="form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="modal-header">
          <div class="form-group pull-right">
            
         </div>
         <h4 class="modal-title">Edit IPL Form</h4>
       </div>
       <div class="modal-body"> 
         <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Nama</label>
              <div class="col-md-8">
                <input name="family_card_name" id="family_card_name" class="form-control" type="text" readonly>
                <small class="errorEditIPLName hidden alert-danger"></small> 
              </div>
            </div> 


            <div class="form-group">
              <label class="control-label col-md-3">Bulan</label>
              <div class="col-md-8">
                <input name="month" id="month" class="form-control" type="text" readonly>
              </div>
            </div> 

            <div class="form-group">
              <label class="control-label col-md-3">Tahun</label>
              <div class="col-md-8">
                <input name="year" id="year" class="form-control" type="text" readonly>
              </div>
            </div> 

            <div class="form-group">
              <label class="control-label col-md-3">Tarif IPL</label>
              <div class="col-md-8">
                <input name="ipl_tarif" id="ipl_tarif" class="form-control" type="number">
              </div>
            </div> 
        </div>
      </div>
    </form><br>
    <div class="modal-footer">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="button" id="btnSave" class="btn btn-primary pull-right" style="margin-left: 5px">  <i class="fa fa-save"></i> Save</button>
      </div>  
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
@stop
@section('scripts')
<script>
  var table;
    $(document).ready(function() {
        //datatables
        table = $('#dtTable').DataTable({
        processing: true,
        serverSide: true,
        fixedColumns:   {
          leftColumns: 4
        },
        dom: 'Bfrtip',
        buttons: [
              'copy', 'excel', 'print'
        ],
        ajax: "{{ URL::route('editor.edit-ipl.data') }}",
        columns: [
        { data: 'action', name: 'action', orderable: false, searchable: false },
        { data: 'family_card_name', name: 'family_card_name' },
        { data: 'month', name: 'month' },
        { data: 'year', name: 'year' },
        { data: 'ipl_tarif', name: 'ipl_tarif', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },
        { data: 'mstatus', name: 'mstatus' }
        ]
      });
    });

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }


    function edit(id)
    { 

      $( "#btnSaveAdd" ).prop( "disabled", false );

      $('.@yield('required')').addClass('hidden');

      $("#btnSave").attr("onclick","update("+id+")");

      $("#btnSaveAdd").attr("onclick","updateadd("+id+")");

      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string

      //Ajax Load data from ajax
      $.ajax({
        url : 'edit-ipl/edit/' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('[name="id_key"]').val(data.id); 
          $('[name="family_card_name"]').val(data.family_card_name);
          $('[name="month"]').val(data.month);
          $('[name="year"]').val(data.year);
          $('[name="ipl_tarif"]').val(data.ipl_tarif);
          $('[name="status"]').val(data.status);
          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Edit Edit IPL'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get data from ajax');
        }
      });
    }

    function update(id)
    {
      save_method = 'update'; 
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string

      //Ajax Load data from ajax
      $.ajax({
        url: 'edit-ipl/edit/' + id,
        type: "PUT",
        data: {
          '_token': $('input[name=_token]').val(),  
          'ipl_tarif': $('#ipl_tarif').val() 
        },
        success: function(data) {  
          $('.errorEditIPLName').addClass('hidden');

          if ((data.errors)) {
            var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.error('Data is required!', 'Error Validation', options);
            
            if (data.errors.family_card_name) {
              $('.errorEditIPLName').removeClass('hidden');
              $('.errorEditIPLName').text(data.errors.family_card_name);
            }
          } else {
          var options = { 
            "positionClass": "toast-bottom-right", 
            "timeOut": 1000, 
          };
          toastr.success('Successfully updated data!', 'Success Alert', options);
          $('#modal_form').modal('hide');
          $('#form')[0].reset(); // reset form on modals
          reload_table(); 
        } 
      },
    })
    };

  </script> 
@stop
