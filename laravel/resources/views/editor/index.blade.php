@extends('layouts.editor.template')
@section('title', 'Halaman Depan')
@section('content')
    <style type="text/css">
        .jq-icon-info {
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR…b0vjdyFT4Cxk3e/kIqlOGoVLwwPevpYHT+00T+hWwXDf4AJAOUqWcDhbwAAAAASUVORK5CYII=);
            background-color: #31708f;
            color: #fff;
            border-color: #bce8f1;
        }

    </style>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Halaman Depan</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Depan</a></li>
                        <li class="active">Halaman Depan</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <h4>Dashboard{{-- <a class="get-code" data-toggle="collapse" href="#pgr1" aria-expanded="true"><i class="fa fa-code" title="Get Code" data-toggle="tooltip"></i></a> --}}</h4>
                    <div class="collapse m-t-15" id="pgr1" aria-expanded="true">
                        <pre class="line-numbers language-javascript m-t-0"><code><b>Use below code & put in column</b><br/>
                &lt;div class="white-box"&gt;
                    &lt;h3 class="box-title"&gt;NEW CLIENTS&lt;/h3&gt;
                    &lt;ul class="list-inline two-part"&gt;
                    &lt;li&gt;&lt;i class="icon-people text-info"&gt;&lt;/i&gt;&lt;/li&gt;
                    &lt;li class="text-right"&gt;&lt;span class="counter"&gt;23&lt;/span&gt;&lt;/li&gt;
                    &lt;/ul&gt;
                &lt;/div&gt;</code></pre>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-3 col-xs-6">
                            <div class="white-box">
                                <h3 class="box-title">JUMLAH KEPALA KELUARGA</h3>
                                <ul class="list-inline two-part">
                                    <li><i class="icon-people text-info"></i></li>
                                    @if (isset($count_family_card))
                                        <li class="text-right"><span style="font-size: 15px !important"
                                                class="counter">{{ $count_family_card->count_family_card }}</span>
                                        </li>
                                    @else
                                        <li class="text-right"><span style="font-size: 15px !important"
                                                class="counter">-</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-xs-6">
                            <div class="white-box">
                                <h3 class="box-title">PERIODE BERJALAN</h3>
                                <ul class="list-inline two-part">
                                    <li><i class="icon-folder text-purple"></i></li>
                                    @if (isset($period))
                                        <li class="text-right"><span style="font-size: 15px !important"
                                                class="counter">{{ $period->count_period }} BULAN</span></li>
                                    @else
                                        <li class="text-right"><span style="font-size: 15px !important"
                                                class="counter">-</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-xs-6">
                            <div class="white-box">
                                <h3 class="box-title">BELUM DIBAYAR</h3>
                                <ul class="list-inline two-part">
                                    <li><i class="icon-folder-alt text-danger"></i></li>
                                    @if (isset($outstranding))
                                        <li class="text-right"><span style="font-size: 15px !important"
                                                class="counter">{{ number_format($outstranding->ipl_tarif) }}</span>
                                        </li>
                                    @else
                                        <li class="text-right"><span style="font-size: 15px !important"
                                                class="counter">-</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-xs-6">
                            <div class="white-box">
                                <h3 class="box-title">SUDAH DIBAYAR</h3>
                                <ul class="list-inline two-part">
                                    <li><i class="ti-wallet text-success"></i></li>
                                    @if (isset($payment))
                                        <li class="text-right"><span style="font-size: 15px !important"
                                                class="counter">{{ number_format($payment->ipl_tarif) }}</span>
                                        </li>
                                    @else
                                        <li class="text-right"><span style="font-size: 15px !important"
                                                class="counter">0</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->

        <div class="row">

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
    </div>
@stop


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $.toast({
                heading: 'Selamat datang di RW Kita',
                text: '{{ Auth::user()->first_name }}, kami siap membantu anda.',
                position: 'top-right',
                loaderBg: '#ff6849',
                icon: 'info',
                hideAfter: 7000,

                stack: 6
            })
        });
    </script>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('#myModal').modal('show');
        });
    </script>

@stop
