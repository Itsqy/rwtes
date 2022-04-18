@extends('layouts.editor.template')
@if (isset($family_card))
    @section('title', 'Edit Data Warga')
@else
    @section('title', 'Add New Data Warga')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($family_card))
                            Edit
                        @else
                            Tambah Baru
                        @endif Data Warga
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">Data Warga & Aktivitas</a></li>
                        <li class="active">
                            @if (isset($family_card))
                                Edit
                            @else
                                Tambah Baru
                            @endif Data Warga
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
                                @if (isset($family_card))
                                    {!! Form::model($family_card, ['route' => ['editor.family-card.update', $family_card->id], 'method' => 'PUT', 'files' => 'true']) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.family-card.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <div class="sttabs tabs-style-bar">
                                            <nav style="display: none">
                                                <ul>
                                                    @if (isset($family_card))
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
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('no', 'No KK *') }}
                                                                {{ Form::text('no', old('no'), ['class' => 'form-control','placeholder' => 'No KK *','required' => 'true','id' => 'no']) }}
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('nip', 'NIP *', ['class' => 'control-label']) }}
                                                                {{ Form::text('nip', old('nip'), ['class' => 'form-control','placeholder' => 'NIP *','id' => 'nip','required' => 'true']) }}
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <div class="row">

                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('name', 'Nama KK *') }}
                                                                {{ Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Nama KK *','id' => 'name','required' => 'true']) }}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('hp', 'HP *') }}
                                                                {{ Form::text('hp', old('hp'), ['class' => 'form-control','placeholder' => 'HP *','id' => 'hp','required' => 'true']) }}
                                                            </div>
                                                        </div>

                                                        <!--/span-->
                                                        {{-- <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('address', 'Alamat *') }}
                                                    {{ Form::text('address', old('address'), array('class' => 'form-control', 'placeholder' => 'Alamat *', 'id' => 'address', 'required' => 'true')) }} 
                                                </div>
                                            </div> --}}

                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('block', 'Blok *') }}
                                                                {{ Form::text('block', old('block'), ['class' => 'form-control','placeholder' => 'Blok *','id' => 'block','required' => 'true']) }}
                                                            </div>
                                                        </div>


                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('ipl_id', 'IPL ID *') }}
                                                                {{ Form::text('ipl_id', old('ipl_id'), ['class' => 'form-control','placeholder' => 'IPL ID *','id' => 'address','required' => 'true']) }}
                                                            </div>
                                                        </div>

                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('ipl_tarif', 'Tarif IPL *') }}
                                                                {{ Form::number('ipl_tarif', old('ipl_tarif'), ['class' => 'form-control','placeholder' => 'Tarif IPL *','id' => 'address','required' => 'true']) }}
                                                            </div>
                                                        </div>

                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('address', 'Alamat *') }}
                                                                {{ Form::text('address', old('address'), ['class' => 'form-control','placeholder' => 'Alamat *','id' => 'address','required' => 'true']) }}
                                                            </div>
                                                        </div>

                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('rt_id', 'RT') }}
                                                                {{ Form::select('rt_id', $rt_list, old('rt_id'), ['class' => 'form-control','placeholder' => 'Pilih RT','id' => 'rt_id']) }}
                                                            </div>
                                                        </div>

                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('house_type_id', 'Tipe Rumah') }}
                                                                {{ Form::select('house_type_id', $house_type_list, old('house_type_id'), ['class' => 'form-control','placeholder' => 'Pilih Tipe Rumah','id' => 'house_type_id']) }}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('village', 'Desa/Keluarahan') }}
                                                                {{ Form::text('village', old('village'), ['class' => 'form-control','placeholder' => 'Desa/Keluarahan','id' => 'village']) }}
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('sub_district', 'Kecamatan') }}
                                                                {{ Form::text('sub_district', old('sub_district'), ['class' => 'form-control','placeholder' => 'Kecamatan','id' => 'sub_district']) }}
                                                            </div>
                                                        </div>
                                                        <!--/span-->

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('city', 'Kota') }}
                                                                {{ Form::text('city', old('city'), ['class' => 'form-control', 'placeholder' => 'Kota', 'id' => 'city']) }}
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('pos_code', 'Kode POS') }}
                                                                {{ Form::text('pos_code', old('pos_code'), ['class' => 'form-control','placeholder' => 'Kode POS','id' => 'pos_code']) }}
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('province', 'Provinsi') }}
                                                                {{ Form::text('province', old('province'), ['class' => 'form-control','placeholder' => 'Provinsi','id' => 'province']) }}
                                                            </div>
                                                        </div>

                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('bill_2019', 'Tagihan Tahun 2019') }}
                                                                {{ Form::number('bill_2019', old('bill_2019'), ['class' => 'form-control','placeholder' => 'Provinsi','id' => 'bill_2019']) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h3 class="box-title m-t-40">Foto</h3>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('image', 'Foto 1', ['class' => 'control-label']) }}
                                                                {{ Form::file('image', old('image'), ['class' => 'form-control', 'placeholder' => 'Foto 1', 'id' => 'image']) }}
                                                                <p>.jpeg / .png file only</p>
                                                                <br>
                                                                {{ Form::text('description_image', old('description_image'), ['class' => 'form-control','placeholder' => 'Keterangan Foto 1','id' => 'description_image']) }}
                                                                <br>
                                                                <div class="col-sm-3">
                                                                    @if (isset($family_card->image))
                                                                        <a class="image-popup-vertical-fit"
                                                                            href="../../../uploads/family-card/{{ $family_card->image }}"
                                                                            title=""><img
                                                                                src="../../../uploads/family-card/{{ $family_card->image }}"
                                                                                class="img-responsive" /></a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('image2', 'Foto 2', ['class' => 'control-label']) }}
                                                                {{ Form::file('image2', old('image2'), ['class' => 'form-control','placeholder' => 'Foto 2','id' => 'image2']) }}
                                                                <p>.jpeg / .png file only</p>
                                                                <br>
                                                                {{ Form::text('description_image2', old('description_image2'), ['class' => 'form-control','placeholder' => 'Keterangan Foto 2','id' => 'description_image2']) }}
                                                                <br>
                                                                <div class="col-sm-3">
                                                                    @if (isset($family_card->image))
                                                                        <a class="image-popup-vertical-fit"
                                                                            href="../../../uploads/family-card/{{ $family_card->image2 }}"
                                                                            title=""><img
                                                                                src="../../../uploads/family-card/{{ $family_card->image2 }}"
                                                                                class="img-responsive" /></a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('image3', 'Foto 3', ['class' => 'control-label']) }}
                                                                {{ Form::file('image3', old('image3'), ['class' => 'form-control','placeholder' => 'Foto 3','id' => 'image3']) }}
                                                                <p>.jpeg / .png file only</p>
                                                                <br>
                                                                {{ Form::text('description_image3', old('description_image3'), ['class' => 'form-control','placeholder' => 'Keterangan Foto 3','id' => 'description_image3']) }}
                                                                <br>
                                                                <div class="col-sm-3">
                                                                    @if (isset($family_card->image))
                                                                        <a class="image-popup-vertical-fit"
                                                                            href="../../../uploads/family-card/{{ $family_card->image3 }}"
                                                                            title=""><img
                                                                                src="../../../uploads/family-card/{{ $family_card->image3 }}"
                                                                                class="img-responsive" /></a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->

                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('image4', 'Foto 4', ['class' => 'control-label']) }}
                                                                {{ Form::file('image4', old('image4'), ['class' => 'form-control','placeholder' => 'Foto 4','id' => 'image4']) }}
                                                                <p>.jpeg / .png file only</p>
                                                                <br>
                                                                {{ Form::text('description_image4', old('description_image4'), ['class' => 'form-control','placeholder' => 'Keterangan Foto 4','id' => 'description_image4']) }}
                                                                <div class="col-sm-3">
                                                                    @if (isset($family_card->image))
                                                                        <a class="image-popup-vertical-fit"
                                                                            href="../../../uploads/family-card/{{ $family_card->image4 }}"
                                                                            title=""><img
                                                                                src="../../../uploads/family-card/{{ $family_card->image4 }}"
                                                                                class="img-responsive" /></a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('image5', 'Foto 5', ['class' => 'control-label']) }}
                                                                {{ Form::file('image5', old('image5'), ['class' => 'form-control','placeholder' => 'Foto 5','id' => 'image5']) }}
                                                                <p>.jpeg / .png file only</p>
                                                                <br>
                                                                {{ Form::text('description_image5', old('description_image5'), ['class' => 'form-control','placeholder' => 'Keterangan Foto 5','id' => 'description_image5']) }}
                                                                <br>
                                                                <div class="col-sm-3">
                                                                    @if (isset($family_card->image))
                                                                        <a class="image-popup-vertical-fit"
                                                                            href="../../../uploads/family-card/{{ $family_card->image5 }}"
                                                                            title=""><img
                                                                                src="../../../uploads/family-card/{{ $family_card->image5 }}"
                                                                                class="img-responsive" /></a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('image6', 'Foto 6', ['class' => 'control-label']) }}
                                                                {{ Form::file('image6', old('image6'), ['class' => 'form-control','placeholder' => 'Foto 6','id' => 'image6']) }}
                                                                <p>.jpeg / .png file only</p>
                                                                <br>
                                                                {{ Form::text('description_image6', old('description_image6'), ['class' => 'form-control','placeholder' => 'Keterangan Foto 6','id' => 'description_image6']) }}
                                                                <br>
                                                                <div class="col-sm-3">
                                                                    @if (isset($family_card->image))
                                                                        <a class="image-popup-vertical-fit"
                                                                            href="../../../uploads/family-card/{{ $family_card->image6 }}"
                                                                            title=""><img
                                                                                src="../../../uploads/family-card/{{ $family_card->image6 }}"
                                                                                class="img-responsive" /></a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->
                                                    <button type="submit" class="btn btn-success btn-flat pull-right"
                                                        value="save" name="save"><i class="fa fa-check"></i>
                                                        Simpan</button> &nbsp;&nbsp;&nbsp;
                                                    <a href="{{ URL::route('editor.family-card.index') }}"
                                                        class="btn btn-default btn-flat pull-right"
                                                        style="margin-right: 10px"><i class="fa fa-close"></i> Tutup</a>
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
