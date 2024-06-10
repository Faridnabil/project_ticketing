<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== GOOGLE FONTS ===============-->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <title>{{ trans('panel.site_title') }}</title>
    <link rel="icon" type="image" href="{{ asset('img/logos/dev-icon.jpeg') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/animation-custom.css') }}" rel="stylesheet" />
    @yield('styles')
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
  <section class="background-radial-gradient overflow-hidden">
      <div class="app flex-row align-items-center">
          <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
              <div class="row gx-lg-5 align-items-center mb-5">
                  <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                      <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                          Support Ticketing System <br />
                      </h1>
                      <div class="bird-wrapper mt-5">
                          <div class="bird-container ">
                              <div class="bird-body"></div>
                              <div class="bird-mouth"></div>
                              <div class="bird-beak"></div>
                              <div class="bird-feather"></div>
                              <div class="bird-tail"></div>
                              <div class="bird-leg"></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                      <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                      <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                      @yield("content")
                  </div>
              </div>
          </div>
      </div>
      @yield('scripts')
      <!-- ===============================================-->
      <!--    JavaScripts-->
      <!-- ===============================================-->
      <script src="{{ asset('js/main.js') }}"></script>
  </section>
</body>

</html>
