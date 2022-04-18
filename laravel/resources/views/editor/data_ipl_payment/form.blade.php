@extends('layouts.editor.template')
@if(isset($data_header_ipl))
@section('title', 'Pembayaran IPL') 
@else
@section('title', 'Pembayaran IPL') 
@endif
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Transaksi</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Transaksi</a></li>
                  <li class="active">Pembayaran IPL</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        @if(isset($data_header_ipl))
                        {!! Form::model($data_header_ipl, array('route' => ['editor.data-ipl.update', $data_header_ipl->id], 'method' => 'PUT', 'files' => 'true'))!!}
                        @else
                        {!! Form::open(array('route' => 'editor.data-ipl.store', 'files' => 'true'))!!}
                        @endif
                        {{ csrf_field() }}
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('ipl_id', 'ID IPL') }}
                                                    {{ Form::text('ipl_id', old('ipl_id'), array('class' => 'form-control', 'placeholder' => 'ID IPL *', 'required' => 'true', 'id' => 'no', 'readonly')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('name', 'Nama', ['class' => 'control-label']) }}
                                                    {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Nama *', 'id' => 'name', 'required' => 'true', 'readonly']) }}
                                                </div>
                                            </div>
                                            <!--/span--> 
                                        </div> 
                                        <div class="row">

                                             <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('block', 'Blok') }}
                                                    {{ Form::text('block', old('block'), array('class' => 'form-control', 'placeholder' => 'Blok *', 'id' => 'block', 'required' => 'true', 'readonly')) }} 
                                                </div>
                                            </div> 

                                             <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('tunggakan', 'Tunggakan') }}
                                                    {{ Form::text('tunggakan', old('tunggakan'), array('class' => 'form-control', 'placeholder' => 'Tunggakan *', 'id' => 'tunggakan', 'required' => 'true', 'readonly')) }} 
                                                </div>
                                            </div> 

                                             <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('ipl_tarif', 'IPL Bulanan') }}
                                                    {{ Form::text('ipl_tarif', old('ipl_tarif'), array('class' => 'form-control', 'placeholder' => 'IPL Bulanan *', 'id' => 'address', 'required' => 'true', 'readonly')) }} 
                                                </div>
                                            </div>  

                                             <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('total_tarif_ipl', 'Total Tunggakan') }}
                                                    {{ Form::text('total_tarif_ipl', old('total_tarif_ipl'), array('class' => 'form-control', 'placeholder' => 'Total Tunggakan *', 'id' => 'address', 'required' => 'true', 'readonly')) }} 
                                                </div>
                                            </div>  

                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('ipl_tarif', 'Bukti Transfer') }}
                                                    {{ Form::file('image', old('image'), ['class' => 'form-control', 'placeholder' => 'Foto KK', 'id' => 'image']) }}
                                                </div>
                                            </div>  

                                            <div class="col-md-12">
                                                <hr>
                                                {{ Form::label('ipl_tarif', 'Periode Belum Dibayar') }}
                                                <br>
                                                @foreach($data_ipl AS $data_ipls)
                                                <label class="checkbox-inline"><input type="checkbox" value=""> {{ $data_ipls->period_name }}</label> <br>
                                                @endforeach 
                                                <hr>
                                            </div>  
                                        </div>   
                                         
                                        <!--/row-->
                                        <button type="submit" class="btn btn-success btn-flat pull-right" value="save" name="save"><i class="fa fa-check"></i> Bayar</button> &nbsp;&nbsp;&nbsp;
                                        <a href="{{ URL::route('editor.data-ipl.index') }}" class="btn btn-default btn-flat pull-right" style="margin-right: 10px"><i class="fa fa-close"></i> Batal</a>
                                </section>
                                </div>
                                <section> 
                            {!! Form::close() !!}
                        </div>
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
