@extends('layouts.editor.template')
@section('module', 'Setting')   
@section('title', 'Histori')   
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
                                      <th>ID IPL</th> 
                                      <th>Nama</th> 
                                      <th>Pesan</th> 
                                      <th>Tanggal</th> 
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
        fixedColumns:   {
          leftColumns: 4
        },
        dom: 'Bfrtip',
        buttons: [
              'copy', 'excel', 'print'
        ],
        ajax: "{{ URL::route('editor.send-message.data') }}",
        columns: [
        { data: 'ipl_id', name: 'ipl_id' },
        { data: 'family_name', name: 'family_name' },
        { data: 'description', name: 'description' },
        { data: 'created_at', name: 'created_at' },
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
      url = "{{ URL::route('editor.sms-template.store') }}";
      
      $.ajax({
        type: 'POST',
        url: url,
        data: {
          '_token': $('input[name=_token]').val(), 
          'sms_template_name': $('#sms_template_name').val(), 
          // 'ipl_tarif': $('#ipl_tarif').val(), 
          'description': $('#description').val(), 
          'status': $('#status').val()
        },
        success: function(data) { 

          $('.errorHistoriName').addClass('hidden');

          if ((data.errors)) {
            var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.error('Data is required!', 'Error Validation', options);
            
            if (data.errors.sms_template_name) {
                $('.errorHistoriName').removeClass('hidden');
                $('.errorHistoriName').text(data.errors.sms_template_name);
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
        url : 'sms-template/edit/' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('[name="id_key"]').val(data.id); 
          $('[name="sms_template_name"]').val(data.sms_template_name);
          // $('[name="ipl_tarif"]').val(data.ipl_tarif);
          $('[name="description"]').val(data.description);
          $('[name="status"]').val(data.status);
          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Edit Histori'); // Set title to Bootstrap modal title
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
        url: 'sms-template/edit/' + id,
        type: "PUT",
        data: {
          '_token': $('input[name=_token]').val(), 
          'sms_template_name': $('#sms_template_name').val(), 
          // 'ipl_tarif': $('#ipl_tarif').val(), 
          'description': $('#description').val(), 
          'status': $('#status').val()
        },
        success: function(data) {  
          $('.errorHistoriName').addClass('hidden');

          if ((data.errors)) {
            var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.error('Data is required!', 'Error Validation', options);
            
            if (data.errors.sms_template_name) {
              $('.errorHistoriName').removeClass('hidden');
              $('.errorHistoriName').text(data.errors.sms_template_name);
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


    function delete_id(id, sms_template_name)
    {
      //var varnamre= $('#sms_template_name').val();
      var sms_template_name = sms_template_name.bold();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete ' + sms_template_name + ' data?',
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
            url : 'sms-template/delete/' + id,
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
