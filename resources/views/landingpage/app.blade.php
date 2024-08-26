<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sistem Monitoring SysDBA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="icon" href="{{ asset('templates/assets/img/kaiadmin/pln.ico') }}" type="image/x-icon" />

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
            border-radius: 0.375rem;
            color: black;
            /* Pastikan warna teks hitam agar terlihat */
            background-color: white;
            /* Pastikan latar belakang putih */
        }

        .ck-editor__editable {
            min-height: 70px;
            border-radius: 0.375rem;
            color: black;
            /* Warna teks dalam CKEditor */
            background-color: white;
            /* Latar belakang CKEditor */
        }

        .ck-editor__editable_inline {
            padding: 0.375rem 0.75rem;
            box-sizing: border-box;
            color: black;
            /* Warna teks */
            background-color: white;
            /* Latar belakang */
        }
    </style>

    <style>
        .custom-dropzone {
            border: 3px dashed #dbdbdb;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            position: relative;
            width: 100%;
            height: 150px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .custom-dropzone .dz-message {
            pointer-events: none;
            transition: opacity 0.3s ease;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .custom-dropzone .dz-message.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .custom-dropzone .dz-message h5 {
            font-size: 14px;
            margin-top: 10px;
        }

        .custom-dropzone .dz-message span {
            font-size: 12px;
        }

        .custom-dropzone .bi {
            font-size: 2rem;
        }

        .preview {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
            justify-content: center;
            align-items: center;
        }

        .image-container {
            position: relative;
            width: 80px;
            height: 80px;
            border: 1px solid #ccc;
            padding: 5px;
            box-sizing: border-box;
            overflow: hidden;
        }

        .image-container img {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: 0 auto;
        }

        .remove-btn {
            position: absolute;
            top: 3px;
            right: 3px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 15px;
            height: 15px;
            font-size: 10px;
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
                        <div class="nav-item dropdown">
                        </div>
                    </div>
                </div>
                @auth
                    @if (Auth::user()->role('Admin'))
                        <a href="{{ route('admin.dashboard.index') }}"
                            class="btn btn-secondary rounded-pill py-2 px-4">Dashboard</a>
                    @elseif (Auth::user()->role('Engineer'))
                        <a href="{{ route('login') }}" class="btn btn-secondary rounded-pill py-2 px-4">Dashboard</a>
                    @elseif (Auth::user()->role('SysAdmin'))
                        <a href="{{ route('sysadmin.dashboard.index') }}"
                            class="btn btn-secondary rounded-pill py-2 px-4">Dashboard</a>
                    @elseif (Auth::user()->role('DBA'))
                        <a href="{{ route('dba.dashboard.index') }}"
                            class="btn btn-secondary rounded-pill py-2 px-4">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary rounded-pill py-2 px-4">Login</a>
                @endauth
            </nav>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Carousel Start -->
    <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="{{ asset('cental/img/carousel.jpeg') }}" class="img-fluid w-100" alt="First slide" />
                <div class="carousel-caption">
                    <div class="container py-4">
                        <div class="row g-5">
                            <div class="col-lg-12 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight"
                                data-delay="1s" style="animation-delay: 1s;">
                                <div class="text-center">
                                    <h1 class="display-5 text-white">Selamat Datang di Sistem Monitoring SysAdmin dan
                                        DBA</h1>
                                    <p>Memastikan kinerja dan keamanan optimal untuk infrastruktur Anda</p>
                                    <a href="#form" class="btn btn-primary rounded-pill py-2 px-4">Ajukan Laporan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Features Start -->
    <div class="container-fluid feature py-5" id="form">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Pengajuan <span class="text-primary">Tiket</span></h1>
                <div class="col-lg-12 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s"
                    style="animation-delay: 1s;">
                    <div class="bg-secondary rounded p-5">
                        <form action={{ route('landing.save') }} method="POST" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="title" class="form-label"><b>Judul Tiket</b></label>
                                    <input class="form-control @error('title') is-invalid @enderror" id="title"
                                        name="title">

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="validationCustom01" class="form-label"><b>Pemilik Tiket</b></label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                                        id="title">

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="notlp" class="form-label"><b>Nomor Telp/WhatsApp</b></label>
                                    <input type="number" class="form-control @error('notlp') is-invalid @enderror"
                                        id="notlp" name="no_telp">

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('notlp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="email" class="form-label"><b>Email</b></label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email">

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="services" class="form-label"><b>Tetapkan ke</b></label>
                                    <div class="row">
                                        <div class="col-6">
                                            <select class="form-select" id="division-select" name="assig_to_role">
                                                <option selected disabled>Divisi</option>
                                                @foreach ($userRoles as $item)
                                                    @if (in_array($item['role'], ['SysAdmin', 'DBA']))
                                                        <option value="{{ $item['role'] }}">{{ $item['role'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select class="form-select" id="user-select" name="assign_to">
                                                <option selected disabled>Seseorang</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}"
                                                        data-role="{{ $item->roles->pluck('name')->implode(', ') }}">
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="services" class="form-label"><b>Prioritas</b></label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="priority_id">
                                        <option value="" selected disabled>Pilih Prioritas</option>
                                        @foreach ($prioritas as $item)
                                            <option value="{{ $item->id }}">{{ $item->priority_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="services" class="form-label"><b>Layanan</b></label>
                                    <select id="services" name="service_id" class="form-select" aria-label="Default select example">
                                        <option value="">Pilih Layanan</option>
                                        @foreach ($services as $item)
                                            <option value="{{ $item->id }}">{{ $item->service_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="col-6">
                                    <label for="category" class="form-label"><b>Kategori</b></label>
                                    <select id="category" class="form-select" aria-label="Default select example" name="category_id">
                                        <option value="">Pilih Kategori</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label"><b>Deskripsi
                                            Laporan</b></label>
                                    <textarea id="description" name="description"></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="d-block fw-bold mb-2">Lampiran</label>
                                    <div class="custom-dropzone"
                                        onclick="document.getElementById('attachments').click()">
                                        <div class="dz-message">
                                            <h5 class="fs-6 fw-bolder mb-1 mt-0" style="color: #eeeeee">
                                                Letakkan file di sini atau klik untuk mengunggah.
                                            </h5>
                                            <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5 file</span>
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
                                    <button class="btn btn-light w-100 py-2" type='submit'>Ajukan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->

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

    {{-- Javascript Dropzone --}}
    <script>
        let uploadedFiles = [];
        let existingFiles = [];
        let removedFiles = [];

        @if (isset($ticket) && $ticket->attachments)
            @php
                $attachments = explode(',', str_replace(['[', ']', '"'], '', $ticket->attachments));
            @endphp
            @foreach ($attachments as $attachment)
                existingFiles.push('{{ $attachment }}');
            @endforeach
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            const preview = document.querySelector('.preview');
            const dzMessage = document.querySelector('.dz-message');
            const icon = document.querySelector('.bi-file-earmark-arrow-up');

            // Tampilkan existing files
            existingFiles.forEach(filePath => {
                addExistingFile(preview, filePath);
            });
            updateExistingFileList();

            // Sembunyikan pesan dan ikon jika ada existing files
            if (existingFiles.length > 0) {
                dzMessage.classList.add('hidden');
                icon.style.display = 'none';
            }
        });

        document.getElementById('attachments').addEventListener('change', function(event) {
            const preview = document.querySelector('.preview');
            const dzMessage = document.querySelector('.dz-message');
            const icon = document.querySelector('.bi-file-earmark-arrow-up');
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                uploadedFiles.push(file);
                addNewFile(preview, file);
            }

            // Sembunyikan pesan dan ikon saat file diunggah
            if (files.length > 0) {
                dzMessage.classList.add('hidden');
                icon.style.display = 'none';
            }
        });

        function addExistingFile(preview, filePath) {
            const container = document.createElement('div');
            container.classList.add('image-container');
            const img = document.createElement('img');
            img.src = `{{ asset('') }}${filePath}`;
            img.addEventListener('click', (event) => {
                event.stopPropagation();
                removeExistingFile(event, filePath);
            });
            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'x';
            removeBtn.classList.add('remove-btn');
            removeBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                removeExistingFile(event, filePath);
            });
            container.appendChild(img);
            container.appendChild(removeBtn);
            preview.appendChild(container);
        }

        function addNewFile(preview, file) {
            const container = document.createElement('div');
            container.classList.add('image-container');
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'x';
            removeBtn.classList.add('remove-btn');
            removeBtn.addEventListener('click', () => removeFile(file));
            container.appendChild(img);
            container.appendChild(removeBtn);
            preview.appendChild(container);
        }

        function removeFile(file) {
            const index = uploadedFiles.indexOf(file);
            if (index !== -1) {
                uploadedFiles.splice(index, 1);
                const preview = document.querySelector('.preview');
                preview.removeChild(preview.childNodes[index]);

                // Tampilkan kembali pesan dan ikon jika tidak ada file yang diunggah
                if (uploadedFiles.length === 0 && existingFiles.length === 0) {
                    document.querySelector('.dz-message').classList.remove('hidden');
                    document.querySelector('.bi-file-earmark-arrow-up').style.display = 'block';
                }
            }
        }

        function removeExistingFile(event, filePath) {
            event.stopPropagation();
            removedFiles.push(filePath);
            existingFiles = existingFiles.filter(file => file !== filePath);
            event.target.parentElement.remove();
            updateExistingFileList();

            // Tampilkan kembali pesan dan ikon jika tidak ada file yang diunggah
            if (uploadedFiles.length === 0 && existingFiles.length === 0) {
                document.querySelector('.dz-message').classList.remove('hidden');
                document.querySelector('.bi-file-earmark-arrow-up').style.display = 'block';
            }
        }

        function updateExistingFileList() {
            const fileList = document.getElementById('existing_file_list');
            fileList.innerHTML = '';
            existingFiles.forEach(filePath => {
                const listItem = document.createElement('li');
                listItem.textContent = filePath;
                fileList.appendChild(listItem);
            });
        }

        function removeAllFiles() {
            uploadedFiles = [];
            removedFiles = [];
            existingFiles = [];
            const preview = document.querySelector('.preview');
            preview.innerHTML = '';
            updateExistingFileList();
            document.querySelector('.dz-message').classList.remove('hidden');
            document.querySelector('.bi-file-earmark-arrow-up').style.display = 'block';
        }
    </script>

    <script>
        document.getElementById('division-select').addEventListener('change', function() {
            var selectedDivision = this.value;
            var userSelect = document.getElementById('user-select');
            var options = userSelect.querySelectorAll('option');

            options.forEach(function(option) {
                option.style.display = 'block';
                option.disabled = false;
            });
            if (selectedDivision !== 'Divisi') {
                options.forEach(function(option) {
                    var userRole = option.getAttribute('data-role');
                    if (userRole && userRole !== selectedDivision) {
                        option.style.display = 'none';
                        option.disabled = true;
                    }
                });
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#services').change(function() {
                var serviceId = $(this).val();

                if (serviceId) {
                    $.ajax({
                        url: '/categories-by-service/' + serviceId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var categoryDropdown = $('#category');
                            categoryDropdown.empty();
                            categoryDropdown.append('<option value="">Pilih Kategori</option>');

                            $.each(data, function(key, category) {
                                categoryDropdown.append('<option value="' + category.id + '">' + category.category_name + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.log('Error:', xhr.responseText);
                        }
                    });
                } else {
                    $('#category').empty().append('<option value="">Pilih Kategori</option>'); // Clear categories dropdown
                }
            });
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
