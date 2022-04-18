@extends('layouts.editor.template')
@if(isset($data_header_ipl))
@section('title', 'Kirim Tagihan IPL') 
@else
@section('title', 'Kirim Tagihan IPL') 
@endif
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Kirim Tagihan IPL</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Karyawan & Aktivitas</a></li>
                  <li class="active">Kirim Tagihan IPL</li> 
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
                        {!! Form::open(array('route' => 'editor.send-message.store', 'files' => 'true'))!!}
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
                                                    {{ Form::label('ipl_id', 'Filter Pemberitahuan') }}
                                                    <select class="form-control" name="tunggakan"  id="tunggakan">
                                                        <option value="1">Belum Bayar 1 Bulan</option>
                                                        <option value="2">Belum Bayar 2 Bulan</option>
                                                        <option value="3">Belum Bayar 3 Bulan</option>
                                                        <option value="4">Belum Bayar > 3 Bulan</option>
                                                    </select> 
                                                </div>
                                            </div>
                                            <!--/span--> 
                                        </div>  
                                        </div>   
                                         
                                        <!--/row-->
                                        <button type="submit" class="btn btn-success btn-flat pull-right" value="save" name="save"><i class="fa fa-check"></i> Kirim Pesan</button> &nbsp;&nbsp;&nbsp;
                                        <a href="{{ URL::route('editor.send-message.history') }}" class="btn btn-primary btn-flat pull-right" style="margin-right: 10px"><i class="fa fa-book"></i> Riwayat SMS</a>
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
