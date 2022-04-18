@extends('layouts.editor.template')
@if(isset($data_header_ipl))
@section('title', 'Grafik Collection IPL') 
@else
@section('title', 'Grafik Collection IPL') 
@endif
@section('content')



 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Grafik Collection IPL</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Karyawan & Aktivitas</a></li>
                  <li class="active">Grafik Collection IPL</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body"> 
                        {!! Form::open(array('route' => 'editor.ipl-chart.view', 'files' => 'true'))!!}
                            <div class="form-body"> 
                                <section>
                                <div class="sttabs tabs-style-bar">
                                    <nav style="display: none">
                                        <ul>
                                            @if(isset($data_header_ipl))
                                            <li><a href="#section-bar-1" class="sticon ti-home"><span>Home</span></a></li>
                                            <li><a href="#section-bar-2" class="sticon ti-id-badge"><span>Phone</span></a></li>
                                            <li><a href="#section-bar-3" class="sticon ti-gift"><span>Birthday</span></a></li> 
                                            @else
                                            <li></li>
                                            @endif
                                        </ul>
                                    </nav>
                                    <div class="content-wrap">
                                        <section id="section-bar-1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {{ Form::label('ipl_id', 'Dari Tahun') }}
                                                    <select class="form-control" name="from_year"  id="from_year" onchange="reload_table();">
                                                        @forEach($year as $years)
                                                        <option value="{{$years->year_name}}">{{$years->year_name}}</option> 
                                                        @endforeach
                                                    </select> 
                                                </div>

                                                <div class="form-group">
                                                    {{ Form::label('ipl_id', 'Sampai Tahun') }}
                                                    <select class="form-control" name="to_year"  id="to_year" onchange="reload_table();">
                                                        @forEach($year as $years)
                                                        <option value="{{$years->year_name}}">{{$years->year_name}}</option> 
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                            <!--/span--> 
                                        </div>  
                                        </div>   
                                         
                                        <!--/row-->
                                        <a href="{{ URL::route('editor.ipl-chart.view') }}" class="btn btn-success btn-flat pull-right" value="save" name="save"><i class="fa fa-bar-chart-o"></i> Lihat Grafik</a> &nbsp;&nbsp;&nbsp;
                                </section>
                                </div>
                                <section> 
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<script src="{{Config::get('constants.path.plugin')}}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
  jQuery('.mydatepicker, #date_birth').datepicker();
  jQuery('.mydatepicker, #term_date').datepicker();
  jQuery('.mydatepicker, #join_date').datepicker();
  jQuery('.mydatepicker, #pension_date').datepicker();

  $('#date_birth').datepicker({ format: 'dd-mm-yyyy' });
  $('#term_date').datepicker({ format: 'dd-mm-yyyy' });
  $('#join_date').datepicker({ format: 'dd-mm-yyyy' });
  $('#pension_date').datepicker({ format: 'dd-mm-yyyy' });
</script>

 <!-- Add fancyBox -->
 <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
 <script type="text/javascript" src="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
 <script type="text/javascript">
  $(document).ready(function() {
    $(".fancybox").fancybox();
  });
 </script>
 <script src="{{Config::get('constants.path.js')}}/cbpFWTabs.js"></script>
 <script type="text/javascript">
 (function() {

    [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
        new CBPFWTabs(el);
    });

 })();
 </script>
@stop
