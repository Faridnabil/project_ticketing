<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Ticketing System</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="icon" type="image" href="{{ asset('img/logos/dev-icon.jpeg') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logos/dev-icon.jpeg') }}">
    <link rel="manifest" href="{{ asset('img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&amp;family=Rubik:ital,wght@0,300..900;1,300..900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>


<body>
    <!-- ===============================================--><!--    Main Content--><!-- ===============================================-->
    <main class="main" id="top">
        <div class="content">
            <nav class="navbar navbar-expand-md fixed-top" id="navbar"
                data-navbar-soft-on-scroll="data-navbar-soft-on-scroll">
                <div class="container-fluid px-0">
                    <a href="/">
                        <img class="img-fluid" src="{{ asset('img/logos/logoss.png') }}" alt="logo" width="430" />
                    </a>
                    <a class="navbar-brand fw-bold d-none d-md-block" href="/"></a>
                    @auth
                        @if (Auth::user()->hasRoles == 'Admin')
                            <a class="btn btn-primary btn-sm ms-md-x1 mt-lg-0 order-md-1 ms-auto "
                                style="background-color: #14a2b1; border-color:#14a2b1" href="{{ route('admin.home') }}">
                                Back to Dashboard
                            </a>
                        @else
                            <a class="btn btn-primary btn-sm ms-md-x1 mt-lg-0 order-md-1 ms-auto "
                                style="background-color: #14a2b1; border-color:#14a2b1"
                                href="{{ route('admin.tickets.index') }}">
                                Back to Dashboard
                            </a>
                        @endif
                    @else
                        <a class="btn btn-primary btn-sm ms-md-x1 mt-lg-0 order-md-1 ms-auto "
                            style="background-color: #14a2b1; border-color:#14a2b1" href="{{ route('login') }}">
                            Login Now
                        </a>
                    @endauth

                    <button class="navbar-toggler border-0 pe-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false"
                        aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-md-end" id="navbar-content"
                        data-navbar-collapse="data-navbar-collapse">
                        <ul class="navbar-nav gap-md-2 gap-lg-3 pt-x1 pb-1 pt-md-0 pb-md-0"
                            data-navbar-nav="data-navbar-nav">
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#home">Beranda</a></li>
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#about">Tentang Kami</a></li>
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#service">Support</a></li>
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#contact">Kontak</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div data-bs-target="#navbar" data-bs-spy="scroll" tabindex="0">
                <section class="hero-section overflow-hidden position-relative z-0 mb-4 mb-lg-0" id="home">
                    <div class="hero-background">
                        <div class="container">
                            <div class="row gy-4 gy-md-8 pt-9 pt-lg-0">
                                <div class="col-lg-6 text-center text-lg-start">
                                    <h1 class="fs-2 fs-lg-1 text-white fw-bold mb-2 mb-lg-x1 lh-base mt-3 mt-lg-0">
                                        Ticketing System</h1>
                                    <p class="fs-8 text-white mb-3 mb-lg-4 lh-lg">membantu menangani permintaan layanan
                                        dengan lebih teratur dan efektif.
                                    </p>
                                </div>
                                <div class="col-lg-6 position-lg-relative">
                                    <div class="position-lg-absolute z-1 mt-5 text-right" style="right: 0%"><img
                                            class="img-fluid" src="{{ asset('img/logos/logo.png') }}"
                                            alt="logos" width="150" />
                                        <div class="position-absolute dots d-none d-md-block"> <img
                                                class="img-fluid w-50 w-lg-75" src="img/illustrations/Dots.webp"
                                                alt="" /></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 z-1"><img class="wave mb-md-n2"
                            src="img/illustrations/Wave.svg" alt="" />
                        <div class="bg-white py-2 py-md-5"></div>
                    </div>
                </section>
                <section class="container border-bottom mb-8 mb-lg-10">
                    <div class="row pb-6 pb-lg-8 g-3 g-lg-8 px-3">
                        <div class="col-12 col-md-4">
                            <h2 class="fs-3 fw-bold lh-sm mb-2 text-center"
                                data-countup='{"endValue":6,"prefix":"0"}'>0</h2>
                            <h6 class="fs-8 fw-normal lh-lg mb-0 opacity-70 text-center">Offices are available on
                                different countries</h6>
                        </div>
                        <div class="col-12 col-md-4">
                            <h2 class="fs-3 fw-bold lh-sm mb-2 text-center" data-countup='{"endValue":238}'>0</h2>
                            <h6 class="opacity-70 fs-8 fw-normal lh-lg mb-0 text-center">Seats are available right now
                                with support</h6>
                        </div>
                        <div class="col-12 col-md-4">
                            <h2 class="fs-3 fw-bold lh-sm mb-2 text-center"
                                data-countup='{"endValue":1395,"autoIncreasing":true}'>0</h2>
                            <h5 class="opacity-70 fs-8 fw-normal lh-lg mb-0 text-center">People are using our co-work
                                spaces right now</h5>
                        </div>
                    </div>
                </section>
                <section class="container mb-8 mb-lg-13" id="about">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-6 col-xl-7"><img class="img-fluid" src="img/Hero/Team.webp"
                                alt="" /></div>
                        <div class="col-12 col-lg-6 col-xl-5">
                            <div class="row justify-content-center justify-content-lg-start">
                                <div class="col-sm-10 col-md-8 col-lg-12">
                                    <h2 class="fs-4 fs-lg-3 fw-bold mb-2 text-center text-lg-start">Kolaborasi penuh
                                        dengan anggota team</h2>
                                    <p class="fs-8 mb-4 mb-lg-5 lh-lg text-center text-lg-start fw-normal">
                                        Berkolaborasi dalam satu platform. Menyelesaikan issue dengan cepat.</p>
                                </div>
                                <div class="col-12">
                                    {{-- <div>
                                        <h5 class="fs-8 fw-bold lh-lg mb-1"> Unlimited Video Meetings</h5>
                                        <p class="lh-xl mb-0">Conduct unlimited video meetings with us for better
                                            business operations.</p>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="container mb-8 mb-lg-13">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-6 col-xl-5 order-lg-1"><img class="img-fluid"
                                src="img/Hero/Collaborator.webp" alt="" /></div>
                        <div class="col-12 col-lg-6 col-xl-7">
                            <div class="row justify-content-center justify-content-lg-start">
                                <div class="col-sm-10 col-md-8 col-lg-11">
                                    <h2 class="fs-4 fs-lg-3 fw-bold mb-2 text-center text-lg-start"> Organize remote
                                        team fast & easily.</h2>
                                    <p class="fs-8 mb-4 mb-lg-5 lh-lg text-center text-lg-start fw-normal">Organizing
                                        and managing your remote teams has never been this easy!</p>
                                </div>
                                <div class="col-12">
                                    <div class="mb-x1 mb-lg-3">
                                        <h5 class="fs-8 fw-bold lh-lg mb-1">Create Unlimited Teams </h5>
                                        <p class="b-0 lh-xl">Create unlimited teams and boost productivity with
                                            efficient collaboration.</p>
                                    </div>
                                    <div>
                                        <h5 class="fs-8 fw-bold lh-lg mb-1"> Hasslefree Chat with Everyone</h5>
                                        <p class="lh-xl mb-0">With unique and simple UIs, keep yourself connected
                                            across all the teams.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="experience position-relative overflow-hidden" id="service">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="position-relative z-1 text-center mb-8 mb-lg-9 video-player-paused"
                                    data-video-player-container="data-video-player-container"><video
                                        class="w-100 h-100 rounded-4" src="video/Video_Icon.mp4"
                                        poster="img/Hero/experiences.webp" type="video/mp4"
                                        data-video-player="data-video-player"></video>
                                    <div class="overlay position-absolute top-0 bottom-0 start-0 end-0 rounded-4 bg-1100 object-cover"
                                        data-overlay="data-overlay"> </div><button
                                        class="btn play-button position-absolute justify-content-center align-items-center bg-white rounded-circle cursor-pointer"
                                        data-play-button="data-play-button"> <img class="play-icon w-25"
                                            src="img/illustrations/play-solid.svg" alt=""
                                            data-play-icon="data-play-icon" /><img class="pause-icon w-25"
                                            src="img/illustrations/pause-solid.svg" alt=""
                                            data-pause-icon="data-pause-icon" /></button>
                                    <div class="position-absolute dots d-none d-sm-block"><img class="img-fluid w-100"
                                            src="img/illustrations/Dots.webp" alt="" /></div>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-7">
                                <h2 class="fs-4 fs-lg-3 fw-bold text-center text-white mb-5 mb-lg-9 lh-sm">We made this
                                    app to solve your problems.</h2>
                            </div>
                            <div class="col-12">
                                <div class="row gy-4 g-md-3 pb-8 pb-lg-11 px-1">
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="img/icons/roadmap.svg" alt="" />
                                        <div>
                                            <h5 class="fs-8 text-white lh-lg fw-bold">Unlimited Projects</h5>
                                            <p class="text-white text-opacity-50 lh-xl mb-0">Manage multiple projects
                                                at once and for seamless business operation.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="img/icons/users-wm.svg" alt="" />
                                        <div>
                                            <h5 class="fs-8 text-white lh-lg fw-bold">Team Management</h5>
                                            <p class="text-white text-opacity-50 lh-xl mb-0">Manage your
                                                cross-functional teams better than ever with our easily manageable app.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="img/icons/share-91.svg" alt="" />
                                        <div>
                                            <h5 class="fs-8 text-white lh-lg fw-bold">File Sharing</h5>
                                            <p class="text-white text-opacity-50 lh-xl mb-0">Easily share files where
                                                necessary and keep them safe with enhanced security and protection.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="img/icons/video_meeting.svg" alt="" />

                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="img/icons/opening-times.svg" alt="" />
                                        <div>
                                            <h5 class="fs-8 text-white lh-lg fw-bold">Time Tracking</h5>
                                            <p class="text-white text-opacity-50 lh-xl mb-0">Track time to ensure
                                                meeting all the deadlines and never lag behind managing multiple
                                                projects.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="img/icons/card-favorite.svg" alt="" />
                                        <div>
                                            <h5 class="fs-8 text-white lh-lg fw-bold">Payment System</h5>
                                            <p class="text-white text-opacity-50 lh-xl mb-0">With its easy payment
                                                system create invoices and get paid all at the same place.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-0 start-0 end-0">
                        <div class="bg-white py-3 py-md-9 py-xl-10"> </div><img class="wave"
                            src="img/illustrations/Wave_2.svg" alt="" />
                    </div>
                </section>
                {{-- Start  Contact  --}}
                <section class="bg-300 position-relative z-0" id="contact">
                    <div class="container py-8 py-lg-6">
                        <div class="row ">
                            <div class="col-md-6 col-lg-6">
                                <div class="row ">
                                    <div class="col-12 col-lg-10">
                                        <h2 class="fs-4 fs-lg-3 fw-bold mb-2 lh-sm">Kontak Kami</h2>
                                        <p class="fs-8 mb-5 mb-lg-5  lh-lg fw-normal"> Hubungi kami untuk informasi
                                            lebih lanjut</p>
                                    </div>
                                    <div class="col-10 col-lg-7">
                                        <form method="POST" onsubmit="return false;">
                                            <div style="margin-bottom: 30px">
                                                <div style="display: flex; align-items: center;">
                                                    <img src="/img/icons/phone-call.png" alt="Phone Icon"
                                                        style="width: 16px; height: 16px; margin-right: 8px; margin-bottom:10px">
                                                    <p style="font-weight: bold; font-size: 16px; margin: 0;">Phone
                                                        Number
                                                    </p>
                                                </div>
                                                <div class="mb-2 w-100" style="margin-left: 25px">
                                                    <p><i class="fas fa-envelope"></i> 021-5253019</p>
                                                </div>
                                            </div>


                                            <div style="margin-bottom: 10px">
                                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <img src="/img/icons/whatsapp.png" alt="WhatsApp Icon"
                                                        style="width: 16px; height: 16px; margin-right: 8px;">
                                                    <p style="font-weight: bold; font-size: 16px; margin: 0;">Fax
                                                        Number</p>
                                                </div>
                                                <div class="mb-2 w-100" style="display: flex; align-items: center;">
                                                    <p style="margin-left: 25px;"><i class="fas fa-envelope"></i>
                                                        021-5253659</p>
                                                </div>

                                            </div>



                                            <div style="display: flex; align-items: center;">
                                                <img src="/img/icons/envelopes.png" alt="Phone Icon"
                                                    style="width: 16px; height: 16px; margin-right: 8px; margin-bottom:10px">
                                                <p style="font-weight: bold; font-size: 16px; margin: 0;">
                                                    Email Address
                                                </p>
                                            </div>
                                            <div class="mb-2 w-100" style="margin-left: 25px;">
                                                <p>
                                                    <i class="fas fa-envelope"></i>humas@iconpln.co.id
                                                </p>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="col-10 col-lg-7">
                                        <p class=" lh-lg mb-0">Kami tidak pernah membagikan rincian Anda kepada pihak
                                            ketiga. Lihat Kebijakan Privasi kami untuk informasi lebih lanjut.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="row">

                                    <div class="col-10 col-lg-12">
                                        <img src="/img/illustrations/contact.png" alt="Description of the image"
                                            class="img-fluid">
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 z-n1 d-none d-lg-block"><img
                            src="img/illustrations/Green_dots.svg" alt="" /></div>
                    <div class="position-relative bottom-0 start-0 z-1"><img class="img-fluid w-100"
                            src="img/illustrations/Wave_3.svg" alt="" /></div>
                </section>
                {{-- End  Contact  --}}

            </div><button
                class="btn scroll-to-top text-white rounded-circle d-flex justify-content-center align-items-center"
                style="background-color: #125d72	; border-color:#14a2b1" data-scroll-top="data-scroll-top"><span
                    class="uil uil-angle-up"></span></button>
            <footer class="pt-7 pt-lg-8">
                <div class="container">
                    <div class="row gy-2 py-3 justify-content-center justify-content-md-between">
                        <div class="col-auto ps-0">
                            <p class="text-center text-md-start lh-xl text-1100"> © 2024 Copyright, All Right Reserved,
                                Made by <a class="fw-semi-bold" href="https://dukcapil.kemendagri.go.id/" target="_blank">
                                    SIAK DUKCAPIL</a>
                            </p>
                        </div>
                        <div class="col-auto pe-0">
                            <a class="icons fs-8 me-3 me-md-0 ms-md-3 cursor-pointer" href="#!">
                                <span class="uil uil-instagram"></span>
                            </a>
                            <a class="icons fs-8 me-3 me-md-0 ms-md-3 cursor-pointer" href="#!">
                                <span class="uil uil-whatsapp"> </span>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <!-- ===============================================--><!--    End of Main Content--><!-- ===============================================-->



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

</body>

</html>
