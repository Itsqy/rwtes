@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Pengeluaran')
@section('required', 'errorout')
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
                                @include('layouts.editor.template_button_master') 
                                {{-- <div class="button-box">
                                    <a href="{{ URL::route('editor.out.create') }}" type="button"
                                        class="fcbtn btn btn-primary btn-outline btn-1b waves-effect">Tambah Baru</a>
                                    <a href="#" onClick="history.back()" type="button"
                                        class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Kembali</a>
                                    <a href="#" onClick="reload_table()" type="button"
                                        class="fcbtn btn btn-success btn-outline btn-1b waves-effect">Refresh</a>
                                    <a href="#" onClick="showslip('family-card');" type="button"
                                        class="fcbtn btn btn-warning btn-outline btn-1b waves-effect pull-right">?</a>
                                </div> --}}
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>nomer pengeluaran</th>
                                                <th>Keterangan</th>
                                                <th>Jumlah</th>
                                                <th>tanggal Pembayaran</th>
                                                <th>update Pembayaran</th>
                                                <th>Status</th>
                                               
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                       <tfoot class="ms-auto">
                                           <tr>
                                               <th>Total pengeluaran :</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                           <th>Rp. {{ number_format($total) }}</th>
                                        </tr>
                                       </tfoot>
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
                <label for="real_name" class="control-label">Methode</label>
                <div class="col-sm-8 pull-right">
                    <select class="form-control" name="status" id="status">
                        <option value="0">CASH</option>
                        <option value="1">CREDIT</option>
                    </select>
                </div>
            </div>
            <h4 class="modal-title">Pengeluaran Form</h4>
        </div>
        <div class="modal-body"> 
            <div class="form-body">
             
              
               <div class="form-group">
                 <label class="control-label col-md-3">Nama Pengeluaran</label>
                 <div class="col-md-8">
                   <input name="nama" id="nama" class="form-control" type="text">
                 </div>
               </div> 
               <div class="form-group">
                 <label class="control-label col-md-3">Jumlah Pengeluaran</label>
                 <div class="col-md-8">
                   <input name="jumlah" id="jumlah" class="form-control" type="text">
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
                fixedColumns: {
                    leftColumns: 6
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                ajax: "{{ URL::route('editor.out.data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'mstatus',
                        name: 'mstatus'
                    }
                    // {
                    //     data: 'total',
                    //     name: 'total'
                    // }
                ]
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function add() {
            $("#btnSave").attr("onclick","save()");
            $("#btnSaveAdd").attr("onclick","saveadd()");

            $("#btnSave").prop("disabled",false);
            $("#btnSaveAdd").prop("disabled",false);

            $('.@yield('required')').addClass('hidden');

            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
        }

        function save() {

            var url;
            url = "{{ URL::route('editor.out.store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nama': $('#nama').val(),
                    'jumlah': $('#jumlah').val(),
                    'status': $('#status').val()
                },
                success: function(data) {

                    $('.errorout').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.nama) {
                            $('.errorout').removeClass('hidden');
                            $('.errorout').text(data.errors.nama);
                        }
                    } else {

                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully added data!', 'Success Alert', options);
                        $('#modal_form').modal('hide');
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                    }
                },
            })
        };


        function edit(id) {

            $("#btnSaveAdd").prop("disabled", false);

            $('.@yield('required')').addClass('hidden');

            $("#btnSave").attr("onclick","update("+id+")");

            $("#btnSaveAdd").attr("onclick","updateadd("+id+")");

            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({

                url: 'dudu/edit/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id_key"]').val(data.id);
                    $('[name="nama"]').val(data.nama);
                    $('[name="jumlah"]').val(data.jumlah);
                    $('[name="status"]').val(data.status);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit pengeluaran'); // Set title to Bootstrap modal title
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function update(id) {
            save_method = 'update';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'dudu/update/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nama': $('#nama').val(),
                    'jumlah': $('#jumlah').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.errorout').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.nama) {
                            $('.errorout').removeClass('hidden');
                            $('.errorout').text(data.errors.nama);
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


        function delete_id(id, nama) {
            //var varnamre= $('#rt_name').val();
            var nama = nama.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + nama + ' data?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    cancel: {
                        action: function() {}
                    },
                    confirm: {
                        text: 'DELETE',
                        btnClass: 'btn-red',
                        action: function() {
                            $.ajax({
                                url: 'dudu/delete/' + id,
                                type: "DELETE",
                                data: {
                                    '_token': $('input[name=_token]').val()
                                },
                                success: function(data) {
                                    var options = {
                                        "positionClass": "toast-bottom-right",
                                        "timeOut": 1000,
                                    };
                                    toastr.success('Successfully deleted data!', 'Success Alert',
                                        options);
                                    reload_table();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    $.alert({
                                        type: 'red',
                                        icon: 'fa fa-danger', // glyphicon glyphicon-heart
                                        title: 'Warning',
                                        content: 'Error deleteing data!',
                                    });
                                }
                            });
                        }
                    },
                }
            });
        }

        function bulk_delete() {
            var list_id = [];
            $(".data-check:checked").each(function() {
                list_id.push(this.value);
            });
            if (list_id.length > 0) {
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure to delete ' + list_id.length + ' data?',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        cancel: {
                            action: function() {

                            }
                        },
                        confirm: {
                            text: 'DELETE',
                            btnClass: 'btn-red',
                            action: function() {
                                $.ajax({
                                    data: {
                                        '_token': $('input[name=_token]').val(),
                                        'idkey': list_id,
                                    },
                                    url: "dudu/deletebulk",
                                    type: "POST",
                                    dataType: "JSON",
                                    success: function(data) {
                                        if (data.status) {
                                            reload_table();
                                        } else {
                                            alert('Failed.');
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        $.alert({
                                            type: 'red',
                                            icon: 'fa fa-danger', // glyphicon glyphicon-heart
                                            title: 'Warning',
                                            content: 'Error deleting data!',
                                        });
                                    }
                                });
                            }
                        },
                    }
                });
            } else {
                $.alert({
                    type: 'orange',
                    icon: 'fa fa-warning', // glyphicon glyphicon-heart
                    title: 'Warning',
                    content: 'No data selected!',
                });
            }
        }
    </script>
@stop
