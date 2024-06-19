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

<style>
    body-building {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #A8DADC;
        }

        svg-building {
            width: calc(68px * 3);
            height: calc(66px * 3);
        }

        /* ELEMENTS POSITIONS */
        #building_bottom,
        #window_01,
        #window_02,
        #door {
            transform: translateY(20px);
            z-index: 1;
        }

        #building_top,
        #balcony_01,
        #balcony_02,
        #balcony_03,
        #balcony_04,
        #balcony_05,
        #balcony_06 {
            transform: translateY(56px);
            z-index: -1;
        }

        #small_tree,
        #big_tree {
            transform: translateY(28px);
        }

        /* ELEMENTS ANIMATIONS */
        #building_bottom {
            animation: buildingBottom 1s ease-out forwards;
        }

        #window_01,
        #window_02,
        #door {
            animation: buildingBottom 1s 0.1s ease-in forwards;
        }

        #building_top {
            animation: buildingTop 1s 1.2s ease-out forwards;
        }

        #balcony_01,
        #balcony_02,
        #balcony_03 {
            animation: buildingTop 1s 1.4s ease-out forwards;
        }

        #balcony_04,
        #balcony_05,
        #balcony_06 {
            animation: buildingTop 1s 1.6s ease-out forwards;
        }

        #small_tree,
        #big_tree {
            animation: trees 1s 2s ease-out forwards;
        }

        #cloud_left {
            transform: translateX(-11px);
            animation: cloudLeft 20s 2s linear infinite;
        }

        #cloud_right {
            transform: translateX(72px);
            animation: cloudRight 15s 2s linear infinite;
        }

        /* ANIMATIONS */
        @keyframes buildingBottom {
            0% { transform: translateY(20px) }
            100% { transform: translateY(0) }
        }

        @keyframes buildingTop {
            0% { transform: translateY(56px); }
            100% { transform: translateY(0); }
        }

        @keyframes trees {
            0% { transform: translateY(28px); }
            100% { transform: translateY(0); }
        }

        @keyframes cloudLeft {
            0% { transform: translateX(-11px); }
            100% { transform: translateX(100px); }
        }

        @keyframes cloudRight {
            0% { transform: translateX(72px); }
            100% { transform: translateX(-100px); }
        }
</style>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
  <section class="background-radial-gradient overflow-hidden">
      <div class="app flex-row align-items-center">
          <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
              <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                        Support Ticketing System <br />
                    </h1>
                    <div class="svg-container">
                        <svg width="68" height="66" viewBox="0 0 68 66" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="art">
                                <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="68" height="66">
                                    <rect id="mask" width="68" height="66" fill="#C4C4C4"/>
                                </mask>
                                <g mask="url(#mask0)">
                                    <g id="composition">
                                        <rect id="background" x="2" y="2" width="50" height="50"/>
                                        <g id="cloud_left">
                                            <path id="cloud_left_2" d="M8 30C8 30.0422 7.99951 30.0844 7.99866 30.1264C8.31873 30.0439 8.65417 30 9 30C11.2091 30 13 31.7909 13 34C13 36.2091 11.2091 38 9 38H-4.5C-6.98523 38 -9 35.9853 -9 33.5C-9 31.0147 -6.98523 29 -4.5 29C-4.30457 29 -4.11194 29.0125 -3.9231 29.0367C-3.46216 26.1809 -0.98584 24 2 24C5.31372 24 8 26.6863 8 30Z" fill="#F1FAEE"/>
                                        </g>
                                        <g id="cloud_right">
                                            <path id="cloud_right_2" d="M77 10C77 10.0422 76.9995 10.0844 76.9987 10.1264C77.3187 10.0439 77.6542 10 78 10C80.2091 10 82 11.7909 82 14C82 16.2091 80.2091 18 78 18H64.5C62.0148 18 60 15.9853 60 13.5C60 11.0147 62.0148 9 64.5 9C64.6954 9 64.8881 9.01248 65.0769 9.03665C65.5378 6.18091 68.0142 4 71 4C74.3137 4 77 6.68628 77 10Z" fill="#F1FAEE"/>
                                        </g>
                                        <g id="cloud_left">
                                            <path id="cloud_left_2" d="M8 30C8 30.0422 7.99951 30.0844 7.99866 30.1264C8.31873 30.0439 8.65417 30 9 30C11.2091 30 13 31.7909 13 34C13 36.2091 11.2091 38 9 38H-4.5C-6.98523 38 -9 35.9853 -9 33.5C-9 31.0147 -6.98523 29 -4.5 29C-4.30457 29 -4.11194 29.0125 -3.9231 29.0367C-3.46216 26.1809 -0.98584 24 2 24C5.31372 24 8 26.6863 8 30Z" fill="#F1FAEE"/>
                                        </g>
                                        <g id="cloud_right">
                                            <path id="cloud_right_2" d="M77 10C77 10.0422 76.9995 10.0844 76.9987 10.1264C77.3187 10.0439 77.6542 10 78 10C80.2091 10 82 11.7909 82 14C82 16.2091 80.2091 18 78 18H64.5C62.0148 18 60 15.9853 60 13.5C60 11.0147 62.0148 9 64.5 9C64.6954 9 64.8881 9.01248 65.0769 9.03665C65.5378 6.18091 68.0142 4 71 4C74.3137 4 77 6.68628 77 10Z" fill="#F1FAEE"/>
                                        </g>
                        </svg>
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
