<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sistem Monitoring SysDBA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('cental/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('cental/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('cental/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('cental/css/style.css') }}" rel="stylesheet">

    <style>
        #description {
            width: 100%;
            height: 100px;
            /* Sesuaikan tinggi sesuai kebutuhan */
            border-radius: 0.375rem;
            /* Sesuaikan dengan input form lainnya */
        }

        .ck-editor__editable {
            min-height: 70px;
            /* Sesuaikan dengan tinggi minimum */
            border-radius: 0.375rem;
            /* Agar border sama dengan input lain */
        }

        .ck-editor__editable_inline {
            padding: 0.375rem 0.75rem;
            /* Agar padding sama dengan input lain */
            box-sizing: border-box;
        }
    </style>

<style>
    .custom-dropzone {
    border: 2px dashed #dbdbdb;
    padding: 10px; /* Kecilkan padding untuk mengecilkan dropzone */
    text-align: center;
    cursor: pointer;
    position: relative;
    width: 100%; /* Sesuaikan lebar agar sama dengan form lainnya */
    height: 150px; /* Sesuaikan tinggi agar tidak terlalu besar */
}

.custom-dropzone .dz-message {
    pointer-events: none;
}

.custom-dropzone .dz-message h3 {
    font-size: 14px; /* Kecilkan ukuran font */
    margin-top: 10px; /* Sesuaikan margin atas */
}

.custom-dropzone .dz-message span {
    font-size: 12px; /* Kecilkan ukuran font */
}

.custom-dropzone .bi {
    font-size: 2rem; /* Sesuaikan ukuran ikon */
}

.preview {
    display: flex;
    flex-wrap: wrap;
    gap: 5px; /* Kurangi jarak antar gambar preview */
    margin-top: 10px;
    justify-content: center;
}

.preview img {
    max-width: 70px; /* Kecilkan ukuran gambar preview */
    max-height: 70px;
}

.remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    width: 15px; /* Kecilkan tombol hapus */
    height: 15px;
    font-size: 10px; /* Kecilkan ukuran font tombol hapus */
    text-align: center;
}
</style>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    {{-- <div class="container-fluid topbar bg-secondary d-none d-xl-block w-100">
        <div class="container">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-6 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-muted me-4"><i
                                class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                        <a href="tel:+01234567890" class="text-muted me-4"><i
                                class="fas fa-phone-alt text-primary me-2"></i>+01234567890</a>
                        <a href="mailto:example@gmail.com" class="text-muted me-0"><i
                                class="fas fa-envelope text-primary me-2"></i>Example@gmail.com</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="#" class="btn btn-light btn-sm-square rounded-circle me-3"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-light btn-sm-square rounded-circle me-3"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-light btn-sm-square rounded-circle me-3"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-light btn-sm-square rounded-circle me-0"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="" class="navbar-brand p-0">
                    <img src="{{ asset('templates/assets/img/kaiadmin/logo.png') }}" alt="navbar brand"
                        class="navbar-brand" width="150px" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        {{-- <a href="index.html" class="nav-item nav-link active">Home</a>
                        <a href="about.html" class="nav-item nav-link">About</a>
                        <a href="service.html" class="nav-item nav-link">Service</a>
                        <a href="blog.html" class="nav-item nav-link">Blog</a> --}}

                        <div class="nav-item dropdown">
                            {{-- <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="feature.html" class="dropdown-item">Our Feature</a>
                                <a href="cars.html" class="dropdown-item">Our Cars</a>
                                <a href="team.html" class="dropdown-item">Our Team</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="404.html" class="dropdown-item">404 Page</a> --}}
                        </div>
                    </div>
                    {{-- <a href="contact.html" class="nav-item nav-link">Contact</a> --}}
                </div>
                <a href="{{ route('login') }}" class="btn btn-secondary rounded-pill py-2 px-4">Login</a>
        </div>
        </nav>
    </div>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Carousel Start -->
    <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
        {{-- <ol class="carousel-indicators">
            <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true" aria-label="First slide"></li>
            <li data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Second slide"></li>
        </ol> --}}
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="{{ asset('cental/img/carousel.jpeg') }}" class="img-fluid w-100" alt="First slide" />
                <div class="carousel-caption">
                    <div class="container py-4">
                        <div class="row g-5">
                            <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s"
                                style="animation-delay: 1s;">
                                <div class="bg-secondary rounded p-5">
                                    <h4 class="text-white mb-4">Ajukan Laporan</h4>
                                    <form>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <div
                                                        class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                        <span class="ms-1">Judul Laporan</span>
                                                    </div>
                                                    <input class="form-control" type="text"
                                                        aria-label="Enter a City or Airport">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <div
                                                        class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                        <span class="ms-1">Pemilik Laporan</span>
                                                    </div>
                                                    <input class="form-control" type="text"
                                                        aria-label="Enter a City or Airport">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Pilih Layanan</option>
                                                    <option value="1">VW Golf VII</option>
                                                    <option value="2">Audi A1 S-Line</option>
                                                    <option value="3">Toyota Camry</option>
                                                    <option value="4">BMW 320 ModernLine</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Pilih Kategori</option>
                                                    <option value="1">VW Golf VII</option>
                                                    <option value="2">Audi A1 S-Line</option>
                                                    <option value="3">Toyota Camry</option>
                                                    <option value="4">BMW 320 ModernLine</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label for="description" class="form-label"><b>Deskripsi
                                                        Laporan</b></label>
                                                <textarea id="description" name="description" autofocus required></textarea>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="d-block fw-bold mb-2">Lampiran</label>
                                                <div class="custom-dropzone"
                                                    onclick="document.getElementById('attachments').click()">
                                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                    <div class="dz-message">
                                                        <h5 class="fs-6 fw-bolder mb-1 mt-0" style="color: #eeeeee">Letakkan
                                                            file di sini
                                                            atau
                                                            klik untuk mengunggah.</h5>
                                                        <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5
                                                            file</span>
                                                    </div>
                                                    <div class="preview"></div>
                                                </div>
                                                <input type="file" id="attachments" name="attachments[]"
                                                    class="form-control d-none" multiple>
                                                <div class="valid-feedback">Looks good!</div>
                                                @error('attachments')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="error-message" id="error-message"></div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-light w-100 py-2">Book Now</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight"
                                data-delay="1s" style="animation-delay: 1s;">
                                <div class="text-start">
                                    <h1 class="display-5 text-white">Selamat Datang di Sistem Monitoring SysAdmin dan
                                        DBA</h1>
                                    <p>Memastikan kinerja dan keamanan optimal untuk infrastruktur Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-body"><a href="#" class="border-bottom text-white"><i
                                class="fas fa-copyright text-light me-2"></i>Monitoring SysDBA</a>, PLN ICON
                        PLUS</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('cental/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('cental/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('cental/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('cental/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('cental/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('cental/js/main.js') }}"></script>
</body>

</html>
