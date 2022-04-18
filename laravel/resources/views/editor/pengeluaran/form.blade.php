@extends('layouts.editor.template')
@if (isset($out))
    @section('title', 'Edit Pengeluaran')
@else
    @section('title', 'Add New Pengeluaran')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($out))
                            Edit
                        @else
                            Tambah Baru
                        @endif Pengeluaran
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">Pengeluaran & Aktivitas</a></li>
                        <li class="active">
                            @if (isset($out))
                                Edit
                            @else
                                Tambah Baru
                            @endif Pengeluaran
                        </li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                @if (isset($out))
                                    {!! Form::model($out, ['route' => ['editor.out.update', $out->id], 'method' => 'PUT', 'files' => 'true']) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.out.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <div class="sttabs tabs-style-bar">
                                            <nav style="display: none">
                                                <ul>
                                                    @if (isset($out))
                                                        <li><a href="#section-bar-1"
                                                                class="sticon ti-home"><span>Home</span></a></li>
                                                        <li><a href="#section-bar-2"
                                                                class="sticon ti-id-badge"><span>Phone</span></a></li>
                                                        <li><a href="#section-bar-3"
                                                                class="sticon ti-gift"><span>Birthday</span></a></li>
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
                                                                {{ Form::label('nama', 'Nama Pengeluaran*') }}
                                                                {{ Form::text('nama', old('nama'), ['class' => 'form-control','placeholder' => 'Nama Pengeluaran *','required' => 'true','id' => 'nama']) }}
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                {{ Form::label('jumlah', 'Jumlah Pengeluaran *', ['class' => 'control-label']) }}
                                                                {{ Form::text('jumlah', old('jumlah'), ['class' => 'form-control','placeholder' => 'Jumlah dalam rupiah *','id' => 'jumlah','required' => 'true']) }}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                {{ Form::label('status', 'status Pengeluaran *') }}
                                                                {{ Form::number('status', old('status'), ['class' => 'form-control','placeholder' => ' 1 = CASH || 0 = NOT CASH *','id' => 'status','required' => 'true']) }}
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-md-12">
                                                            <div class="form-group">
                                                                {{ Form::label('created_at', 'tanggal Pengeluaran *', ['class' => 'control-label']) }}
                                                                {{ Form::datepicker('created_at', old('created_at'), ['class' => 'form-control','placeholder' => 'NIP *','id' => 'nip','required' => 'true']) }}
                                                            </div>
                                                        </div> --}}
                                                        <!--/span-->
                                                    </div>
                                                    <div class="row">
                                                        <button type="submit" class="btn btn-success btn-flat pull-right"
                                                            value="save" name="save"><i class="fa fa-check"></i>
                                                            Simpan</button> &nbsp;&nbsp;&nbsp;
                                                        <a href="{{ URL::route('editor.out.index') }}"
                                                            class="btn btn-default btn-flat pull-right"
                                                            style="margin-right: 10px"><i class="fa fa-close"></i>
                                                            Tutup</a>
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


        <script
                src="{{ Config::get('constants.path.plugin') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js">
        </script>
        <script type="text/javascript">
            jQuery('.mydatepicker, #date_birth').datepicker();
            jQuery('.mydatepicker, #term_date').datepicker();
            jQuery('.mydatepicker, #join_date').datepicker();
            jQuery('.mydatepicker, #pension_date').datepicker();

            $('#date_birth').datepicker({
                format: 'dd-mm-yyyy'
            });
            $('#term_date').datepicker({
                format: 'dd-mm-yyyy'
            });
            $('#join_date').datepicker({
                format: 'dd-mm-yyyy'
            });
            $('#pension_date').datepicker({
                format: 'dd-mm-yyyy'
            });
        </script>

        <!-- Add fancyBox -->
        <link rel="stylesheet" href="{{ Config::get('constants.path.plugin') }}/fancybox/jquery.fancybox.css?v=2.1.5"
            type="text/css" media="screen" />
        <script type="text/javascript"
                src="{{ Config::get('constants.path.plugin') }}/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".fancybox").fancybox();
            });
        </script>
        <script src="{{ Config::get('constants.path.js') }}/cbpFWTabs.js"></script>
        <script type="text/javascript">
            (function() {

                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
                    new CBPFWTabs(el);
                });

            })();
        </script>
    @stop
