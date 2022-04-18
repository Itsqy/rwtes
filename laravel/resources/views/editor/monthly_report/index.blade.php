@extends('layouts.editor.template')
@section('title', 'Pemasukan IPL Bulanan')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Pemasukan IPL Bulanan</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Laporan</a></li>
                  <li class="active">Pemasukan IPL Bulanan</li>
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
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label class="control-label col-md-1 pull-left">Tahun</label>
                                    <div class="col-md-4 pull-left">
                                        <select class="form-control" name="year_name"  id="year_name" onchange="reload_table();">
                                            @forEach($year as $years)
                                            <option value="{{$years->year_name}}">{{$years->year_name}}</option> 
                                            @endforeach
                                        </select> 
                                    </div>
                                    <div class="col-lg-4 pull-left">
                                        <a onClick="reload_table();" class="btn btn-success"> <i class="fa fa-refresh"></i>  Refresh</a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>RT</th>  
                                        <th>JANUARI</th>
                                        <th>FEBRUARI</th>
                                        <th>MARET</th>
                                        <th>APRIL</th>
                                        <th>MEI</th>
                                        <th>JUNI</th>
                                        <th>JULI</th>
                                        <th>AGUSTUS</th>
                                        <th>SEPTEMBER</th>
                                        <th>OKTOBER</th>
                                        <th>NOVEMBER</th>
                                        <th>DESEMBER</th>
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



{{-- @stop --}}
{{-- @section('scripts') --}}
<script> 
//   alert($('#year_name').val());
  var table;
  $(document).ready(function() {
      //datatables
      table = $('#dtTable').DataTable({ 
       processing: true,
       serverSide: true,
       fixedColumns:   {
        leftColumns: 4 
       },
       "initComplete": function (settings, json) {  
          $("#dtTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
       },
       order: [[ 0, 'asc' ]],
       dom: 'Bfrtip',
       buttons: [
            'copy', 'excel', 'print'
       ], 
       ajax: {
            url: "{{ URL::route('editor.monthly-report.data') }}", 
            type : "POST",
            headers : {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function (d) {
                d.year = $('#year_name').val(); 
            }
        },
       columns: [  
       { data: 'rt_name', name: 'rt_name', "width": "5%" }, 
       { data: 'januari', name: 'januari', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'februari', name: 'februari', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'maret', name: 'maret', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'april', name: 'april', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'mei', name: 'mei', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'juni', name: 'juni', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'juli', name: 'juli', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'agustus', name: 'agustus', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'september', name: 'september', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'oktober', name: 'oktober', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'november', name: 'november', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'desember', name: 'desember', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       ]
     });
    });

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
 
</script> 

@stop
