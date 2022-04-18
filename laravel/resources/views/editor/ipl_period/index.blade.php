@extends('layouts.editor.template')
@if(isset($data_header_ipl))
@section('title', 'Buat Tagihan IPL') 
@else
@section('title', 'Buat Tagihan IPL') 
@endif
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Buat Tagihan IPL</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Karyawan & Aktivitas</a></li>
                  <li class="active">Buat Tagihan IPL</li> 
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
                                                    {{ Form::label('ipl_id', 'Bulan') }}
                                                    <select class="form-control" name="month"  id="month">
                                                        <option value="1">Januari</option>
                                                        <option value="2">Fabruari</option>
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

                                                <div class="form-group">
                                                    {{ Form::label('ipl_id', 'Tahun') }}
                                                    <select class="form-control" name="year"  id="year">
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
                                        <button onclick="CreatePeriod();" class="btn btn-success btn-flat pull-right" value="save" name="save"><i class="fa fa-check"></i> Buat Tagihan</button> &nbsp;&nbsp;&nbsp;
                                </section>
                                </div>
                                <section> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x">
            </span>
        </div>
    </div>
    <p> Sedang proses data, jangan reload atau menutup aplikasi </p>
</div>
  
 <script src="{{Config::get('constants.path.js')}}/cbpFWTabs.js"></script>
 <script type="text/javascript">
 (function() {

    [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
        new CBPFWTabs(el);
    });

 })();


function CreatePeriod()
{
    $.confirm({
    title: 'Konfirmasi!',
    content: 'Pembuatan tagihan tidak bisa diundo dan akan otomatis ditagihkan ke semua warga yang terdaftar, apakah anda takin?',
    type: 'red',
        typeAnimated: true,
        buttons: {
            cancel: {
            action: function () { 
            }
            },
            confirm: {
            text: 'BUAT',
            btnClass: 'btn-red',
            action: function () {

            $('.modal').modal('show');
                
            $.ajax({
            url : 'ipl-period/create',
            type: "POST",
            data: {
                '_token': $('input[name=_token]').val(),
                'month': $('#month').val(),
                'year': $('#year').val(),
            },
            success: function(data)
            { 
                $.alert({
                  type: 'green',
                  icon: 'fa fa-green', // glyphicon glyphicon-heart
                  title: 'Informasi',
                  content: data,
                });

                var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
                };
                toastr.success(data, 'Success Alert', options);
                $('.modal').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $.alert({
                type: 'red',
                icon: 'fa fa-danger', // glyphicon glyphicon-heart
                title: 'Warning',
                content: 'Pembuatan tagihan IPL Error!',
                });
            }
            });
            }
        },
        }
        });
    }


 
 </script>
@stop
