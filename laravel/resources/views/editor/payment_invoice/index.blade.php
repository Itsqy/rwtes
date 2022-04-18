@extends('layouts.editor.template')
@section('module', 'Setting')   
@section('title', 'Kwitansi Pembayaran')   
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
                                      <th>Status</th> 
                                      <th>No Kwitansi</th> 
                                      <th>Tanggal Kwintansi</th> 
                                      <th>ID IPL</th> 
                                      <th>Nama KK</th> 
                                      <th>Blok</th> 
                                      <th>Keterangan</th> 
                                      <th>Bukti Bayar</th> 
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
@section('scripts')
<script>
  var table;
    $(document).ready(function() {
        //datatables
        table = $('#dtTable').DataTable({
        processing: true,
        serverSide: true,
        order: [[ 2, "desc" ]],
        fixedColumns:   {
          leftColumns: 4
        },
        dom: 'Bfrtip',
        buttons: [
              'copy', 'excel', 'print'
        ],
        ajax: "{{ URL::route('editor.payment-invoice.data') }}",
        columns: [
        { data: 'action', name: 'action', orderable: false, searchable: false },
        { data: 'mstatus', name: 'mstatus' },
        { data: 'transaction_no', name: 'transaction_no' },
        { data: 'transaction_date', name: 'transaction_date' },
        { data: 'ipl_id', name: 'ipl_id' },
        { data: 'name', name: 'name' },
        { data: 'block', name: 'block' },
        { data: 'description', name: 'description' },
        { data: 'image', name: 'image' },
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
        url : 'data-ipl/edit/' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('[name="id_key"]').val(data.id); 
          $('[name="house_type_name"]').val(data.house_type_name);
          $('[name="ipl_tarif"]').val(data.ipl_tarif);
          $('[name="description"]').val(data.description);
          $('[name="status"]').val(data.status);
          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Edit Kwitansi Pembayaran'); // Set title to Bootstrap modal title
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
        url: 'data-ipl/edit/' + id,
        type: "PUT",
        data: {
          '_token': $('input[name=_token]').val(), 
          'house_type_name': $('#house_type_name').val(), 
          'ipl_tarif': $('#ipl_tarif').val(), 
          'description': $('#description').val(), 
          'status': $('#status').val()
        },
        success: function(data) {  
          $('.errorKwitansi PembayaranName').addClass('hidden');

          if ((data.errors)) {
            var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.error('Data is required!', 'Error Validation', options);
            
            if (data.errors.house_type_name) {
              $('.errorKwitansi PembayaranName').removeClass('hidden');
              $('.errorKwitansi PembayaranName').text(data.errors.house_type_name);
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
