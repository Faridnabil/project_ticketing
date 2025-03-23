<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="description"
        content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
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

    <link href="{{ asset('template/dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Include CKEditor script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Dropzone CSS -->
    <style>
        .custom-dropzone {
            border: 2px dashed #007bff;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            position: relative;
        }

        .custom-dropzone .dz-message {
            pointer-events: none;
        }

        .preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
            justify-content: center;
        }

        .preview .image-container {
            position: relative;
            display: inline-block;
        }

        .preview img {
            max-width: 100px;
            max-height: 100px;
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
            width: 20px;
            height: 20px;
            font-size: 12px;
            text-align: center;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>

    {{-- Select Status Tiket --}}
    <style>
        .custom-select-wrapper {
            position: relative;
            display: inline-block;
        }

        .custom-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: transparent url('data:image/svg+xml;utf8,<svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M5 7l5 5 5-5" stroke="%23000" stroke-width="2"/></svg>') no-repeat right;
            padding-right: 1.5rem;
            border: 1px solid #ccc;
            font-size: 1rem;
            margin-left: 10px;
            width: 10px;
            cursor: pointer;
        }

        .custom-select:focus {
            width: auto;
        }

        .custom-bg {
            background-image: url('/public/template/dist/assets/media/patterns/bg-main.png');
            background-size: cover;
            background-position: center;

        }
    </style>
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px;">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            <div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true"
                data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
                <!--begin::Brand-->
                <div class="aside-logo flex-column-auto" id="kt_aside_logo" style="background-color: white">
                    <!--begin::Logo-->
                    <a href="">
                        <img alt="Logo" src="{{ asset('template/dist/assets/media/logos/logo.png') }}"
                            style="width: 200px" />
                    </a>
                    <!--end::Logo-->

                </div>
                <!--end::Brand-->
                <!--begin::Aside menu-->

                @include('layouts.dashboard.partials.sidebar')

                <!--end::Aside menu-->
            </div>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" style="" class="header align-items-stretch">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <!--begin::Mobile logo-->
                        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                            <a href="index.html" class="d-lg-none">
                                <img alt="Logo" src="{{ asset('template/dist/assets/media/logos/logos.png') }}"
                                    class="h-30px" />
                            </a>
                        </div>
                        <!--end::Mobile logo-->
                        @include('layouts.dashboard.partials.navbar')
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content"
                    style="background-image: url('/template/dist/assets/media/patterns/bg-main.png'); background-size: cover; background-position: center;">
                    @yield('content')
                </div>
                <!--end::Content-->

                <!--Start Footer-->
                @include('layouts.dashboard.partials.footer')
                <!--end footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('template/dist/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('template/dist/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/modals/create-app.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/modals/upgrade-plan.js') }}"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->

    {{-- Javascript Listing --}}
    <script src="{{ asset('template/dist/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/apps/customers/list/export.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/apps/customers/list/list.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/apps/customers/add.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/modals/create-app.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/custom/modals/upgrade-plan.js') }}"></script>

    {{-- Javascript Notifikasi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.notification-link').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default link behavior

                    var form = this.closest('.notification-form');
                    var url = this.getAttribute('href');

                    if (form) {
                        // Submit the form via AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', form.action, true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Redirect to the URL after the form is successfully submitted
                                window.location.href = url;
                            }
                        };

                        // Collect form data
                        var formData = new FormData(form);
                        var formBody = new URLSearchParams(formData).toString();

                        xhr.send(formBody);
                    }
                });
            });
        });
    </script>

    {{-- JavaScript Dropzone --}}
    <script>
        let uploadedFiles = [];
        let existingFiles = [];

        @if (isset($ticket) && $ticket->attachments)
            @php
                $attachments = explode(',', str_replace(['[', ']', '"'], '', $ticket->attachments));
            @endphp
            @foreach ($attachments as $attachment)
                // Menggunakan Storage::url untuk mendapatkan path yang benar dari file di storage
                existingFiles.push('{{ Storage::url($attachment) }}');
            @endforeach
        @endif

        let removedFiles = [];

        document.addEventListener('DOMContentLoaded', function() {
            const preview = document.querySelector('.preview');
            existingFiles.forEach(filePath => {
                const container = document.createElement('div');
                container.classList.add('image-container');

                const img = document.createElement('img');
                img.src = filePath; // URL file di storage
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
            });
            updateExistingFileList(); // Update the list on page load
        });

        document.getElementById('attachments').addEventListener('change', function(event) {
            const fileList = Array.from(event.target.files);
            const preview = document.querySelector('.preview');
            const errorMessage = document.getElementById('error-message');
            const maxFiles = 5;

            if (existingFiles.length + uploadedFiles.length + fileList.length > maxFiles) {
                errorMessage.textContent = `Anda hanya dapat mengunggah hingga ${maxFiles} file/foto.`;
                return;
            }

            errorMessage.textContent = ''; // Clear any existing error message

            fileList.forEach(file => {
                if (!uploadedFiles.includes(file) && !existingFiles.includes(file.name)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const container = document.createElement('div');
                        container.classList.add('image-container');

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.addEventListener('click', (event) => {
                            event.stopPropagation();
                            container.remove();
                            uploadedFiles.splice(uploadedFiles.indexOf(file), 1);
                            updateFileList();
                        });

                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'x';
                        removeBtn.classList.add('remove-btn');
                        removeBtn.addEventListener('click', (event) => {
                            event.stopPropagation();
                            container.remove();
                            uploadedFiles.splice(uploadedFiles.indexOf(file), 1);
                            updateFileList();
                        });

                        container.appendChild(img);
                        container.appendChild(removeBtn);
                        preview.appendChild(container);
                    };

                    if (file.type.startsWith('image/')) {
                        reader.readAsDataURL(file); // Read file as Data URL for image preview
                    }

                    uploadedFiles.push(file);
                    updateFileList(); // Update file list after adding each file
                }
            });
        });

        function uploadFile(event) {
            if (!event.target.closest('.image-container')) {
                document.getElementById('attachments').click();
            }
        }

        function updateFileList() {
            const dataTransfer = new DataTransfer();
            uploadedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('attachments').files = dataTransfer.files;
        }

        function updateExistingFileList() {
            // Update input value for remaining attachments
            document.getElementById('remaining_attachments').value = existingFiles.join(',');
        }

        function removeExistingFile(event, filePath) {
            event.stopPropagation();
            const imgElement = document.querySelector(`img[src="${filePath}"]`);
            if (imgElement && imgElement.parentElement) {
                // Filter out the removed file from existing files
                existingFiles = existingFiles.filter(file => file !== filePath);
                removedFiles.push(filePath.replace('{{ Storage::url('') }}', '')); // Remove Storage prefix

                imgElement.parentElement.remove();
                document.getElementById('removed_attachments').value = removedFiles.join(',');

                updateExistingFileList(); // Update remaining files list
            } else {
                console.error('File not found:', filePath);
            }
        }
    </script>


    {{-- DataTables --}}
    <script>
        $(document).ready(function() {
            // Ambil nilai lengthMenu dan halaman terakhir dari localStorage
            var selectedLength = localStorage.getItem('selectedLength') ||
                5; // Default ke 5 jika tidak ada nilai di localStorage
            var lastPage = localStorage.getItem('lastPage') ||
                0; // Default ke 0 jika tidak ada nilai di localStorage (halaman pertama)

            // Inisialisasi DataTable
            var table = $("#kt_datatable_example_5").DataTable({
                "language": {
                    "lengthMenu": "Show _MENU_",
                    "emptyTable": "Tidak ada data yang ditampilkan. Silakan gunakan filter untuk mencari data."
                },
                "dom": "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +
                    "<'table-responsive'tr>" +
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">",
                "pageLength": parseInt(
                    selectedLength), // Atur panjang halaman sesuai dengan nilai yang tersimpan
                "lengthMenu": [5, 10, 25, 50, 100], // Pilihan jumlah data yang ditampilkan
                "order": [
                    [3, 'desc']
                ], // Urutkan berdasarkan prioritas
                "columnDefs": [{
                    "targets": 3, // Kolom prioritas
                    "orderData": [3],
                    "type": "num"
                }],
                "displayStart": parseInt(lastPage) *
                    selectedLength // Memulai dari halaman terakhir yang tersimpan
            });

            // Simpan nilai pageLength ke localStorage setiap kali berubah
            $('#kt_datatable_example_5').on('length.dt', function(e, settings, len) {
                localStorage.setItem('selectedLength', len);
            });

            // Simpan halaman terakhir yang diakses ke localStorage setiap kali pagination berubah
            $('#kt_datatable_example_5').on('page.dt', function() {
                var info = table.page.info();
                localStorage.setItem('lastPage', info.page);
            });

            // Custom search input
            $('#tableSearch').on('keyup', function() {
                table.search(this.value).draw(); // Pencarian otomatis saat mengetik
            });
        });
    </script>

    {{-- CHATBOT --}}
    <!-- <script type="text/javascript">
        var LHCChatOptions = {};
        LHCChatOptions.opt = {
            widget_height: 340,
            widget_width: 300,
            popup_height: 520,
            popup_width: 500
        };
        (function() {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf(
                '://') + 1)) : '';
            var location = (document.location) ? encodeURIComponent(window.location.href.substring(window.location
                .protocol.length)) : '';
            po.src =
                '//rafimotors.shop/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true/(department)/2?r=' +
                referrer + '&l=' + location;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    </script> -->

</body>

</html>
