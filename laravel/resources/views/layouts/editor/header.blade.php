{{-- Preloader --}}
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
</div>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse"
                data-target=".navbar-collapse"><i class="ti-menu"></i></a>
            <div class="top-left-part"><a class="logo" href="{{ url('/editor') }}"><b>EZ</b><span
                        class="hidden-xs">KAS WARGA</span></a></div>
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i
                            class="icon-arrow-left-circle ti-menu"></i></a></li>
                {{-- <li>
                    <form role="search" class="app-search hidden-xs">
                        <input type="text" placeholder="Search..." class="form-control">
                        <a href=""><i class="fa fa-search"></i></a>
                    </form>
                </li> --}}

            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right">
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-envelope"></i>
                      <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                      </a>
                        <ul class="dropdown-menu mailbox scale-up">
                            <li>
                                <div class="drop-title">Anda tidak ada tugas hari ini</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <a href="#">
                                        <div class="mail-contnet" style="width: 50%;">
                                            <img src="{{ Config::get('constants.path.plugin') }}/images/notif.png" alt="home" />
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                {{-- <a class="text-center" href="javascript:void(0);"> <strong>Lihat semua tugas</strong> <i class="fa fa-angle-right"></i> </a> --}}
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-note"></i>
                    <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                     </a>
                        <ul class="dropdown-menu dropdown-tasks scale-up">
                            <li>
                                <div class="drop-title">Tidak ada pemberitahuan hari ini</div>
                            </li>
                            <li>
                                <a href="#">
                                    <div>
                                         <a href="#">
                                                <div class="mail-contnet" style="width: 50%;">
                                                    <img src="{{ Config::get('constants.path.plugin') }}/images/task.png" alt="home" />
                                                </div>
                                            </a>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- .Megamenu -->
                    <li class="mega-dropdown">
                        {{-- <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><span class="hidden-xs">Mega</span> <i class="icon-options-vertical"></i></a> --}}
                        <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Forms Elements</li>
                                    <li><a href="form-basic.html">Basic Forms</a></li>
                                    <li><a href="form-layout.html">Form Layout</a></li>
                                    <li><a href="form-advanced.html">Form Addons</a></li>
                                    <li><a href="form-material-elements.html">Form Material</a></li>
                                    <li><a href="form-float-input.html">Form Float Input</a></li>
                                    <li><a href="form-upload.html">File Upload</a></li>
                                    <li><a href="form-mask.html">Form Mask</a></li>
                                    <li><a href="form-img-cropper.html">Image Cropping</a></li>
                                    <li><a href="form-validation.html">Form Validation</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Advance Forms</li>
                                    <li><a href="form-dropzone.html">File Dropzone</a></li>
                                    <li><a href="form-pickers.html">Form-pickers</a></li>
                                    <li><a href="icheck-control.html">Icheck Form Controls</a></li>
                                    <li><a href="form-wizard.html">Form-wizards</a></li>
                                    <li><a href="form-typehead.html">Typehead</a></li>
                                    <li><a href="form-xeditable.html">X-editable</a></li>
                                    <li><a href="form-summernote.html">Summernote</a></li>
                                    <li><a href="form-bootstrap-wysihtml5.html">Bootstrap wysihtml5</a></li>
                                    <li><a href="form-tinymce-wysihtml5.html">Tinymce wysihtml5</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Table Example</li>
                                    <li><a href="basic-table.html">Basic Tables</a></li>
                                    <li><a href="table-layouts.html">Table Layouts</a></li>
                                    <li><a href="data-table.html">Data Table</a></li>
                                    <li class="hidden"><a href="crud-table.html">Crud Table</a></li>
                                    <li><a href="bootstrap-tables.html">Bootstrap Tables</a></li>
                                    <li><a href="responsive-tables.html">Responsive Tables</a></li>
                                    <li><a href="editable-tables.html">Editable Tables</a></li>
                                    <li><a href="foo-tables.html">FooTables</a></li>
                                    <li><a href="jsgrid.html">JsGrid Tables</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Charts</li>
                                    <li> <a href="flot.html">Flot Charts</a> </li>
                                    <li><a href="morris-chart.html">Morris Chart</a></li>
                                    <li><a href="chart-js.html">Chart-js</a></li>
                                    <li><a href="peity-chart.html">Peity Charts</a></li>
                                    <li><a href="knob-chart.html">Knob Charts</a></li>
                                    <li><a href="sparkline-chart.html">Sparkline charts</a></li>
                                    <li><a href="extra-charts.html">Extra Charts</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-12 m-t-40 demo-box">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-purple"><a
                                                href="../eliteadmin-inverse/index.html" target="_blank"
                                                class="text-white"><i class="linea-icon linea-basic fa-fw"
                                                    data-icon="v"></i><br />Demo 1</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-success"><a href="../eliteadmin/index.html"
                                                target="_blank" class="text-white"><i
                                                    class="linea-icon linea-basic fa-fw" data-icon="v"></i><br />Demo
                                                2</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-info"><a
                                                href="../eliteadmin-ecommerce/index.html" target="_blank"
                                                class="text-white"><i class="linea-icon linea-basic fa-fw"
                                                    data-icon="v"></i><br />Demo 3</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-inverse"><a
                                                href="../eliteadmin-horizontal-navbar/index3.html" target="_blank"
                                                class="text-white"><i class="linea-icon linea-basic fa-fw"
                                                    data-icon="v"></i><br />Demo 4</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-warning"><a
                                                href="../eliteadmin-iconbar/index4.html" target="_blank"
                                                class="text-white"><i class="linea-icon linea-basic fa-fw"
                                                    data-icon="v"></i><br />Demo 5</a></div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="white-box text-center bg-danger"><a
                                                href="https://themeforest.net/item/elite-admin-responsive-web-app-kit-/16750820"
                                                target="_blank" class="text-white"><i
                                                    class="linea-icon linea-ecommerce fa-fw" data-icon="d"></i><br />Buy
                                                Now</a></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                src="{{ Config::get('constants.path.uploads') }}/user/{{ Auth::user()->username }}/thumbnail/{{ Auth::user()->filename }}"
                                alt="" width="36" class="img-circle"><b
                                class="hidden-xs">{{ Auth::user()->first_name }}</b> </a>
                        <ul class="dropdown-menu dropdown-user scale-up">
                            <li><a href="{{ URL::route('editor.profile.show') }}"><i class="ti-user"></i>
                                    Profil Saya</a></li>
                            {{-- <li><a href="https://api.whatsapp.com/send?phone=6287717696997&text=Saya%20Pengguna%20Spinel%20"
                                    target="_blank"><i class="zmdi zmdi-whatsapp text-success"></i> Dukungan</a></li> --}}
                            <li><a href="#" onclick="log_out();"><i class="ti-power-off text-danger"></i> Keluar</a>
                            </li>
                            <form action="{{ url('/logout') }}" id="form_logout" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <button style="margin-left: 10px" class="btn btn-danger btn-flat"><i
                                        class="fa fa-sign-out"></i> Keluar</button>
                            </form>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- Left navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse slimscrollsidebar">
            <ul class="nav" id="side-menu">
                <li class="user-pro">
                    <a href="#" class="waves-effect"> <i class="ti-user"></i> <span class="hide-menu">
                            {{ Auth::user()->first_name }}<span class="fa arrow"></span></span>
                    </a>
                </li>
                <li class="nav-small-cap m-t-10">--- Transaksi Keuangan</li>
                <li>
                    <a href="{{ URL::route('editor.data-ipl.index') }}"> <i
                            class="zmdi zmdi-assignment-alert zmdi-hc-fw fa-fw"></i> Konfirmasi Bayar</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.payment-invoice.index') }}"> <i
                            class="zmdi zmdi-money-box zmdi-hc-fw fa-fw"></i> Kwitansi Bayar</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.ipl-period.index') }}"> <i
                            class="zmdi zmdi-money-off zmdi-hc-fw fa-fw"></i> Buat Tagihan IPL</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.send-message.index') }}"> <i
                            class="zmdi zmdi-mail-send zmdi-hc-fw fa-fw"></i> Kirim Tagihan IPL</a>
                </li>

                <li>
                    <a href="{{ URL::route('editor.edit-ipl.index') }}"> <i
                            class="zmdi zmdi-money-off zmdi-hc-fw fa-fw"></i> Edit Tagihan IPL</a>
                </li>

                <li class="nav-small-cap m-t-10">--- Laporan Keuangan</li>
                <li>
                    <a href="{{ URL::route('editor.monthly-report.index') }}"> <i
                            class="zmdi zmdi-account-calendar zmdi-hc-fw fa-fw"></i> Pemasukan Bulanan</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.out.index') }}"> <i
                            class="zmdi zmdi-account-calendar zmdi-hc-fw fa-fw"></i> Pengeluaran Bulanan</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.payment-arrears-report.index') }}"> <i
                            class="zmdi zmdi-money-off zmdi-hc-fw fa-fw"></i> Pemasukan/Tunggakan</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.data-ipl-arrears.index') }}"> <i
                            class="zmdi zmdi-accounts-alt zmdi-hc-fw fa-fw"></i> List Penunggak</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.data-ipl-payment.index') }}"> <i
                            class="zmdi zmdi-collection-text zmdi-hc-fw fa-fw"></i> Riwayat Pembayaran</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.ipl-chart.index') }}"> <i
                            class="zmdi zmdi-chart zmdi-hc-fw fa-fw"></i> Chart IPL</a>
                </li>

                <li class="nav-small-cap m-t-10">--- Data Struktur </li>

                <li>
                    <a href="{{ URL::route('editor.family-card.index') }}"> <i
                            class="zmdi zmdi-accounts zmdi-hc-fw fa-fw"></i> Penduduk</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.rt.index') }}"> <i
                            class="zmdi zmdi-account-box-mail zmdi-hc-fw fa-fw"></i> Data RT</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.year.index') }}"> <i
                            class="zmdi zmdi-calendar zmdi-hc-fw fa-fw"></i> Tahun</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.payment-type.index') }}"> <i
                            class="zmdi zmdi-receipt zmdi-hc-fw fa-fw"></i> Jenis Pembayaran</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.house-type.index') }}"> <i
                            class="zmdi zmdi-home zmdi-hc-fw fa-fw"></i> Tipe Rumah</a>
                </li>
                <li>
                    <a href="{{ URL::route('editor.sms-template.index') }}"> <i
                            class="zmdi zmdi-phone-msg zmdi-hc-fw fa-fw"></i> Tagihan Template</a>
                </li>

                <li class="nav-small-cap m-t-10">--- Manajamen Pengguna</li>
                <li> <a href="#" class="waves-effect"><i class="zmdi zmdi-accounts-list-alt zmdi-hc-fw fa-fw"></i>
                        <span class="hide-menu">User</span><span class="hide-menu"><span
                                class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li> <a href="{{ URL::route('editor.user.index') }}">User</a></li>
                        <li> <a href="{{ URL::route('editor.module.index') }}">Modul</a></li>
                        <li> <a href="{{ URL::route('editor.privilege.index') }}">Hak Akses</a></li>
                        <!-- <li> <a href="{{ URL::route('editor.action.index') }}">Tindakan</a></li> -->
                    </ul>
                </li>
                <li>
                    <a href="{{ URL::route('editor.preference.edit', 1) }}" class="waves-effect"><i
                            class="linea-icon linea-basic fa-fw" data-icon="&#xe011;"></i> <span
                            class="hide-menu">Preferensi</span></a>
                </li>
            </ul>
        </div>
    </div>
