@extends('layouts.editor.template')
@section('module', 'Setting')   
@section('title', 'RT')   
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
                        @include('layouts.editor.template_button_master') 
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                      <th>Aksi</th> 
                                      <th>Nama RT</th> 
                                      <th>Ketua RT</th> 
                                      <th>Keterangan</th> 
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
            <label for="real_name" class="control-label">Status</label>
            <div class="col-sm-8 pull-right">
              <select class="form-control" name="status"  id="status">
               <option value="0">Active</option>
               <option value="1">Not Active</option>
             </select>
           </div>
         </div>
         <h4 class="modal-title">RT Form</h4>
       </div>
       <div class="modal-body"> 
         <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Nama RT</label>
              <div class="col-md-8">
                <input name="rt_name" id="rt_name" class="form-control" type="text">
                <small class="errorRTName hidden alert-danger"></small> 
              </div>
            </div> 

            <div class="form-group">
              <label class="control-label col-md-3">Ketua RT</label>
              <div class="col-md-8">
                  <select class="form-control" name="family_card_id"  id="family_card_id">
                    @foreach($family_card as $family_cards)
                      <option value="{{ $family_cards->id }}">{{ $family_cards->name }}</option>
                    @endforeach
                  </select>
              </div>
            </div> 
 
            <div class="form-group">
              <label class="control-label col-md-3">Keterangan</label>
              <div class="col-md-8">
                <input name="description" id="description" class="form-control" type="text">
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
        ajax: "{{ URL::route('editor.rt.data') }}",
        columns: [
        { data: 'action', name: 'action', orderable: false, searchable: false },
        { data: 'rt_name', name: 'rt_name' },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'mstatus', name: 'mstatus' }
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

      $( "#btnSave" ).prop( "disabled", false );
      $( "#btnSaveAdd" ).prop( "disabled", false );

      $('.@yield('required')').addClass('hidden');

      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
    }

    function save()
    {   
      var url;
      url = "{{ URL::route('editor.rt.store') }}";
      
      $.ajax({
        type: 'POST',
        url: url,
        data: {
          '_token': $('input[name=_token]').val(), 
          'rt_name': $('#rt_name').val(), 
          'family_card_id': $('#family_card_id').val(), 
          'description': $('#description').val(), 
          'status': $('#status').val()
        },
        success: function(data) { 

          $('.errorRTName').addClass('hidden');

          if ((data.errors)) {
            var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.error('Data is required!', 'Error Validation', options);
            
            if (data.errors.rt_name) {
                $('.errorRTName').removeClass('hidden');
                $('.errorRTName').text(data.errors.rt_name);
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
        url : 'rt/edit/' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('[name="id_key"]').val(data.id); 
          $('[name="rt_name"]').val(data.rt_name);
          $('[name="family_card_id"]').val(data.family_card_id);
          $('[name="description"]').val(data.description);
          $('[name="status"]').val(data.status);
          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Edit RT'); // Set title to Bootstrap modal title
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
        url: 'rt/edit/' + id,
        type: "PUT",
        data: {
          '_token': $('input[name=_token]').val(), 
          'rt_name': $('#rt_name').val(), 
          'family_card_id': $('#family_card_id').val(), 
          'description': $('#description').val(), 
          'status': $('#status').val()
        },
        success: function(data) {  
          $('.errorRTName').addClass('hidden');

          if ((data.errors)) {
            var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.error('Data is required!', 'Error Validation', options);
            
            if (data.errors.rt_name) {
              $('.errorRTName').removeClass('hidden');
              $('.errorRTName').text(data.errors.rt_name);
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


    function delete_id(id, rt_name)
    {
      //var varnamre= $('#rt_name').val();
      var rt_name = rt_name.bold();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete ' + rt_name + ' data?',
        type: 'red',
        typeAnimated: true,
        buttons: {
          cancel: {
            action: function () { 
            }
          },
          confirm: {
          text: 'DELETE',
          btnClass: 'btn-red',
          action: function () {
            $.ajax({
            url : 'rt/delete/' + id,
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
              toastr.success('Successfully deleted data!', 'Success Alert', options);
              reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
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

    function bulk_delete()
    {
      var list_id = [];
      $(".data-check:checked").each(function() {
        list_id.push(this.value);
      });
      if(list_id.length > 0)
      {
        $.confirm({
          title: 'Confirm!',
          content: 'Are you sure to delete '+list_id.length+' data?',
          type: 'red',
          typeAnimated: true,
          buttons: {
            cancel: {
              action: function () {

              }
            },
            confirm: {
            text: 'DELETE',
            btnClass: 'btn-red',
            action: function () {
              $.ajax({
                data: {
                '_token': $('input[name=_token]').val(),
                'idkey': list_id,
              }, 
              url: "city/deletebulk",
              type: "POST", 
              dataType: "JSON",
              success: function(data)
              {
                if(data.status)
                {
                  reload_table();
                }
                else
                {
                  alert('Failed.');
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
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
      }
      else
      {
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
