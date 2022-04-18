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
                        {!! Form::model($data_header_ipl, array('route' => ['editor.payment-invoice.update', $data_header_ipl->id], 'method' => 'PUT', 'id' => 'payment_form', 'files' => 'true'))!!}
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
                                                    {{ Form::label('transaction_no', 'No Kwitansi') }}
                                                    {{ Form::text('transaction_no', old('transaction_no'), array('class' => 'form-control', 'placeholder' => 'No Kwitansi *', 'required' => 'true', 'id' => 'no', 'readonly')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('transaction_date', 'Tanggal Kwitansi', ['class' => 'control-label']) }}
                                                    {{ Form::text('transaction_date', old('transaction_date'), ['class' => 'form-control', 'placeholder' => 'Tanggal Kwitansi *', 'id' => 'transaction_date', 'required' => 'true', 'readonly']) }}
                                                </div>
                                            </div>
                                            <!--/span--> 
                                        </div> 

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

                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('house_type_name', 'Tipe Rumah') }}
                                                    {{ Form::text('house_type_name', old('house_type_name'), array('class' => 'form-control', 'placeholder' => 'Tipe Rumah *', 'id' => 'house_type_name', 'required' => 'true', 'readonly')) }} 
                                                </div>
                                            </div> 

                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('payment_type_name', 'Jenis Pembayaran') }}
                                                    {{ Form::text('payment_type_name', old('payment_type_name'), array('class' => 'form-control', 'placeholder' => 'Jenis Pembayaran *', 'id' => 'payment_type_name', 'required' => 'true', 'readonly')) }} 
                                                </div>
                                            </div> 
  

                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('ipl_tarif', 'Bukti Transfer') }} <br>
                                                    @if(isset($data_header_ipl->image))
                                                        <a href="../../../uploads/ipl_payment/{{$data_header_ipl->image}}" target="_blank" class="btn btn-success btn-flat"><i class="fa fa-download"></i> Download</a> &nbsp;&nbsp;&nbsp;
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>  

                                            <div class="col-md-12">
                                                <div class="form-group"> 
                                                    {{ Form::label('description', 'Keterangan') }}
                                                    {{ Form::text('description', old('description'), array('class' => 'form-control', 'placeholder' => 'Keterangan *', 'id' => 'address', 'required' => 'true', 'readonly')) }} 
                                                </div>
                                            </div> 

                                            <div class="col-md-12">
                                                {{ Form::label('ipl_tarif', 'Periode Dibayar') }}
                                                <hr>
                                            </div>
                                                <br>
                                                @foreach($data_ipl AS $data_ipls)
                                                    <div class="col-lg-6 col-sm-6 col-xs-6">
                                                        <div class="white-box">
                                                            <h3 class="box-title">{{ $data_ipls->period_name }}</h3>
                                                            <ul class="list-inline two-part">
                                                                <li><i class="icon-wallet text-success"></i></li>
                                                                <li class="text-right">
                                                                    <span style="font-size: 15px !important" class="counter">
                                                                       Rp {{ $data_ipls->ipl_tarif }}
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach 
                                            </div>  
                                            <hr>
                                        <!--/row-->
                                        @if($data_header_ipl->status == 0)
                                        &nbsp;&nbsp;&nbsp; <a href="print" target="_blank" class="btn btn-success btn-flat pull-right" value="save" name="save"><i class="fa fa-print"></i> Cetak Kwitansi</a> &nbsp;&nbsp;&nbsp;
                                        <a href="#" onclick="submitForm();" class="btn btn-danger btn-flat pull-left" value="save" name="save"><i class="fa fa-close"></i> Batalkan</a> &nbsp;&nbsp;&nbsp;
                                        @endif
                                        <a href="{{ URL::route('editor.payment-invoice.index') }}" class="btn btn-default btn-flat pull-right" style="margin-right: 10px"><i class="fa fa-close"></i> Tutup</a>
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
        content: 'Apakah anda yakin akan membatalkan melakukan proses pembayaran?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            cancel: {
            action: function () { 
            }
            },
            confirm: {
            text: 'BATALKAN',
            btnClass: 'btn-red',
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
