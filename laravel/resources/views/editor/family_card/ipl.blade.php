@extends('layouts.editor.template')
@if(isset($data_header_ipl))
@section('title', 'Data IPL Warga') 
@else
@section('title', 'Data IPL Warga') 
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
                  <li class="active">Data IPL Warga</li> 
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
                        {!! Form::model($family_card, array('route' => ['editor.family-card.store-ipl', $family_card->id], 'method' => 'PUT', 'id' => 'payment_form', 'files' => 'true'))!!}
                        {{ csrf_field() }}
                            <div class="form-body"> 
                                <section>
                                <div class="sttabs tabs-style-bar">
                                    <nav style="display: none">
                                        <ul>
                                            @if(isset($family_card))
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
                                                    {{ Form::hidden('family_card_id', old('family_card_id'), array('class' => 'form-control', 'required' => 'true', 'id' => 'no', 'readonly')) }} 
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
                                                    {{ Form::label('ipl_tarif', 'Tarif') }}
                                                    {{ Form::text('ipl_tarif', old('ipl_tarif'), array('class' => 'form-control', 'placeholder' => 'Tarif *', 'id' => 'ipl_tarif', 'required' => 'true', 'readonly')) }} 
                                                </div>
                                            </div> 

                                            <div class="col-md-12">
                                                <hr>
                                                <div class="col-md-12">
                                                    <div class="form-group"> 
                                                        {{ Form::label('ipl_tarif', 'IPL Belum Terdaftar') }}
                                                        <select name="period_id" id="period_id" class="form-control">
                                                          @foreach($data_ipl_period as $data_ipl_periods)
                                                            <option value="{{ $data_ipl_periods->id }}">{{ $data_ipl_periods->period_name }}</option>
                                                          @endforeach
                                                        </select>
                                                    </div>
                                                </div> 
                                                <a href="#" onclick="submitForm();" class="btn btn-success btn-flat pull-right" value="save" name="save"><i class="fa fa-check"></i> Daftarkan</a> &nbsp;&nbsp;&nbsp;
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                            <h3> IPL Terdaftar </h3>

                                            </div>

                                                <br>
                                                @foreach($data_ipl AS $data_ipls)
                                                    <div class="col-lg-6 col-sm-6 col-xs-6">
                                                        <div class="white-box">
                                                            <h3 class="box-title">{{ $data_ipls->period_name }}</h3>
                                                            <ul class="list-inline two-part">
                                                                <li><i class="icon-wallet text-success"></i>
                                                                </li>
                                                                @if($data_ipls->status == 1)
                                                                <p> Sudah Dibayar </p>
                                                                @else
                                                                <p> Belum Dibayar</p>
                                                                @endif
                                                            </ul>
                                                            <hr>
                                                            <p> Tarif : Rp {{ $data_ipls->ipl_tarif }} </p>
                                                        </div>
                                                    </div>
                                                @endforeach 
                                            </div>  
                                            <hr>
                                        <!--/row-->
                                        <a href="{{ URL::route('editor.data-ipl.index') }}" class="btn btn-default btn-flat pull-right" style="margin-right: 10px"><i class="fa fa-close"></i> Tutup</a>
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


<script>
    function submitForm() {

        $.confirm({
        title: 'Confirm!',
        content: 'Pendaftaran periode IPL akan otomatis membuat tagihan di periode tersebut, apakah anda yakin?',
        type: 'blue',
        typeAnimated: true,
        buttons: {
            cancel: {
            action: function () { 
            }
            },
            confirm: {
            text: 'DAFTARKAN',
            btnClass: 'btn-blue',
            action: function () {
                $("#payment_form").submit()  
            }
        },
      }
    });
}
</script>
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
