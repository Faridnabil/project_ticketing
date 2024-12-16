<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../">
    <meta charset="utf-8" />
    <title>Error 505 | Ticketing</title>
    <meta name="keywords"
        content="Metronic, bootstrap, bootstrap 5, Angular 11, VueJs, React, Laravel, admin themes, web design, figma, web development, ree admin themes, bootstrap admin, bootstrap dashboard" />
    <link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('template/dist/assets/media/logos/logos.png') }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('template/dist/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('template/dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-dark">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Error 500 -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
            style="background-image: url(template/dist/assets/media/illustrations/progress-hd.png)">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-20">
                <!--begin::Logo-->
                <a href="index.html" class="mb-10 pt-lg-20">
                    <img alt="Logo" src="{{ asset('template/dist/assets/media/logos/logo.png') }}"
                        class="h-50px mb-5" />
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="pt-lg-10">
                    <!--begin::Logo-->
                    <h1 class="fw-bolder fs-4x text-gray-700 mb-10">Sistem Error</h1>
                    <!--end::Logo-->
                    <!--begin::Message-->
                    <div class="fw-bold fs-3 text-gray-400 mb-15">Telah Terjadi Kesalahan!
                        <br />Tolong Coba Ulang.
                    </div>
                    <!--end::Message-->
                    <!--begin::Action-->
                    <div class="text-center">
                        @auth
                            @if (Auth::user()->hasRole('Admin'))
                                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-lg btn-primary fw-bolder">
                                    Kembali Ke Dashboard
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('Helpdesk'))
                                <a href="{{ route('helpdesk.dashboard.index') }}" class="btn btn-lg btn-primary fw-bolder">
                                    Kembali Ke Dashboard
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('Koordinator'))
                                <a href="{{ route('koordinator.dashboard.index') }}"
                                    class="btn btn-lg btn-primary fw-bolder">
                                    Kembali Ke Dashboard
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('Staff Subdit'))
                                <a href="{{ route('staffSubdit.dashboard.index') }}"
                                    class="btn btn-lg btn-primary fw-bolder">
                                    Kembali Ke Dashboard
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('SIAK Dev'))
                                <a href="{{ route('siakDev.dashboard.index') }}" class="btn btn-lg btn-primary fw-bolder">
                                    Kembali Ke Dashboard
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('Pejabat'))
                                <a href="{{ route('pejabat.dashboard.index') }}" class="btn btn-lg btn-primary fw-bolder">
                                    Kembali Ke Dashboard
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('Teknisi Hardware'))
                                <a href="{{ route('teknisiHardware.dashboard.index') }}" class="btn btn-lg btn-primary fw-bolder">
                                    Kembali Ke Dashboard
                                </a>
                            @endif
                        @endauth
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Error 500-->
    </div>
    <!--end::Main-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('template/dist/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
