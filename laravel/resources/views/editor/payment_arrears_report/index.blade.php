@extends('layouts.editor.template')
@section('title', 'Pembayaran & Tunggakan')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <h4 class="page-title">Pembayaran & Tunggakan</h4>
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Laporan</a></li>
                  <li class="active">Pembayaran & Tunggakan</li>
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
                                    <div class="col-md-3 pull-left">
                                        <select class="form-control" name="year_name"  id="year_name" onchange="reload_table();">
                                            @forEach($year as $years)
                                            <option value="{{$years->year_name}}">{{$years->year_name}}</option> 
                                            @endforeach
                                        </select> 
                                    </div>
                                    <label class="control-label col-md-1 pull-left">Bulan</label>
                                    <div class="col-md-3 pull-left">
                                        <select class="form-control" name="month_name"  id="month_name" onchange="reload_table();">
                                            <option value="1">Januari</option> 
                                            <option value="2">Februari</option> 
                                            <option value="3">Maret</option>  
                                            <option value="4">April</option>  
                                            <option value="5">Mei</option>  
                                            <option value="6">Juni</option>  
                                            <option value="7">Juli</option>  
                                            <option value="8">Agustus</option>  
                                            <option value="9">September</option>  
                                            <option value="10">Oktober</option>  
                                            <option value="11">November</option>  
                                            <option value="12">Desember</option>  
                                        </select> 
                                    </div>
                                    <div class="col-lg-2 pull-left">
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
                                        <th rowspan="2">RT</th>  
                                        <th rowspan="2">JUMLAH RUMAH</th>
                                        <th colspan="5"><center>IPL BULAN BERJALAN</center></th>   
                                        <th rowspan="2">PENERIMAAN <br> SELURUHNYA</th>
                                        <th rowspan="2">COLLECTABILITY <br> RATIO</th>
                                        <th rowspan="2">SALDO TUNGGAKAN<br> PERIODE<br>SEBELUMNYA</th>
                                        <th rowspan="2">SALDO TUNGGAKAN<br> PERIODE<br>INI</th>
                                        <th rowspan="2">RATA-RATA<br> TUNGGAKAN<br>PER KK</th>
                                    </tr>
                                    <tr> 
                                        <th>TAGIHAN</th>  
                                        <th>PEMBAYARAN</th>  
                                        <th>%</th>  
                                        <th>SISA</th>  
                                        <th>%</th>  
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
            url: "{{ URL::route('editor.payment-arrears-report.data') }}", 
            type : "POST",
            headers : {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function (d) {
                d.year = $('#year_name').val(); 
                d.month = $('#month_name').val(); 
            }
        },
       columns: [  
       { data: 'rt_name', name: 'rt_name', "width": "5%" }, 
       { data: 'jumlah_rumah', name: 'jumlah_rumah', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'tagihan_periode', name: 'tagihan_periode', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'pembayaran_periode', name: 'pembayaran_periode', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },   
       { data: 'persen_bayar_period', name: 'persen_bayar_period', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },   
       { data: 'sisa_period', name: 'sisa_period', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },  
       { data: 'persen_sisa_period', name: 'persen_sisa_period', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },   
       { data: 'pembayaran', name: 'pembayaran', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },   
       { data: 'collectability_ratio', name: 'collectability_ratio', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },   
       { data: 'tunggakan_periode_sebelumnya', name: 'tunggakan_periode_sebelumnya', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },   
       { data: 'tagihan', name: 'tagihan', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },   
       { data: 'rata_rata', name: 'rata_rata', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },   
       ]
     });
    });

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
 
</script> 

@stop
