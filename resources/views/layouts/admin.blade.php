<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="{{ asset('layouts/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
    <!--    Stylesheets-->
    <!-- ===============================================-->
    {{-- <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&amp;family=Rubik:ital,wght@0,300..900;1,300..900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    {{-- Baru --}}

    <!-- plugin css -->
    <link href="{{ asset('layouts/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Layout Js -->
    <script src="{{ asset('layouts/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('layouts/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('layouts/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('layouts/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('layouts/assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet"
        type="text/css">

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show" <div class="navbar-header"
   style="background: linear-gradient(to bottom, #1C1948, #393B92),  no-repeat center center fixed; background-size: cover;"
    <!-- Isi dari navbar -->

    <!-- Isi dari body -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header" style="background-color: #1C1948;">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/img/logos/logos.png') }}" alt="logo-sm-dark" height="24">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/img/logos/logos.png') }}" alt="logo-dark" height="25">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/img/logos/logos.png') }}" alt="logo-sm-light"
                                    height="24">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/img/logos/logos.png') }}" alt="logo-light" height="25">
                            </span>
                        </a>
                    </div>

                    <button type="button"
                        class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
                        id="vertical-menu-btn" style="color: #ffffff">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>


                </div>
                <!-- start page title -->

                <div style="display: flex; align-items: center; justify-content: space-between; margin-right: 20px;">
                    <h4 class="page-title mb-0" style="margin-right: 20px; color: #ffffff;">Support Ticketing</h4>
                </div>



                <!-- end page title -->

            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu" style="background-color: #393B92; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/img/logos/lg.png') }}" alt="logo-sm-dark" height="35px">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/img/logos/logos.png') }}" alt="logo-dark" height="50px">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/img/logos/lg.png') }}" alt="logo-sm-light" height="35px">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/img/logos/logos.png') }}" alt="logo-light" height="50px">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
                id="vertical-menu-btn", style="color: #ffffff">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <div data-simplebar class="vertical-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    @include('partials.menu')
                </div>

                <!-- Sidebar -->
            </div>
            <li class="metismenu list-unstyled" id="side-menu">
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();"
                    style=" color: red; height: 45px; line-height: 20px; padding-left: 20px;">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt" style="color: red; margin-right: 5px;"></i>
                    <span style="color: red; margin-left: 5px;">{{ trans('global.logout') }}</span>
                </a>
            </li>



            <ul></ul>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid" style="margin-top: -15px">

                    @if (session('message'))
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            </div>
                        </div>
                    @endif
                    @if ($errors->count() > 0)
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

            <footer class="footer"
                style="background: linear-gradient(to top right, #393B92, #393B92); padding: 10px 0; color: #ffffff;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © PLN ICON Plus.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                            </div>
                        </div>
                    </div>
                </div>
            </footer>



        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    {{-- JS Tambahan --}}

    <!-- JAVASCRIPT -->
    <script src="{{ asset('layouts/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('layouts/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('layouts/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('layouts/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('layouts/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('layouts/assets/js/app.js') }}"></script>

    <!-- /Right-bar -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="{{ asset('layouts/assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- ===============================================--><!--    JavaScripts--><!-- ===============================================-->
    <script src="{{ asset('js/popper/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/is/is.min.js') }}"></script>
    <script src="{{ asset('js/countup/countUp.umd.js') }}"></script>
    <script src="{{ asset('js/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/lodash/lodash.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

    <script src="{{ asset('layouts/assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ asset('layouts/assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>



    <script>
        $(function() {
            let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
            let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
            let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
            let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
            let printButtonTrans = '{{ trans('global.datatables.print') }}'
            let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'

            let languages = {
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
            };

            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
                className: 'btn'
            })
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }, {
                    orderable: false,
                    searchable: false,
                    targets: -1
                }],
                select: {
                    style: 'multi+shift',
                    selector: 'td:first-child'
                },
                order: [],
                scrollX: true,
                pageLength: 100,
                dom: 'lBfrtip<"actions">',
                buttons: [{
                        extend: 'copy',
                        className: 'btn-secondary',
                        text: copyButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn-secondary',
                        text: csvButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-secondary',
                        text: excelButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-secondary',
                        text: pdfButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-secondary',
                        text: printButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn-secondary',
                        text: colvisButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

            $.fn.dataTable.ext.classes.sPageButton = '';
        });
    </script>
    @yield('scripts')
</body>

</html>
