<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="#">
    <meta charset="utf-8" />
    <title>Ticketing</title>
    <meta name="keywords"
        content="Metronic, bootstrap, bootstrap 5, Angular 11, VueJs, React, Laravel, admin themes, web design, figma, web development, ree admin themes, bootstrap admin, bootstrap dashboard" />
    <link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('template/dist/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('template/dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    
    <!--end::Global Stylesheets Bundle-->
    <style>
        /* Custom styles to make the background cover the full viewport */
        .bgi-full {
            background-size: cover;
            height: 100vh;
            /* Full viewport height */
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-white">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-attachment-fixed bgi-full"
            style="background-image: url({{ asset('template/dist/assets/media/illustrations/progress-hd.jpg') }})">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Wrapper-->
                <div class="rounded shadow-sm p-5 p-lg-5 mx-auto"
                    style="background-color: rgba(237, 237, 237, 0.454); width: 60%;">
                    @yield('content')
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Main-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('template/dist/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('template/dist/assets/js/custom/authentication/sign-in/general.js') }}"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
