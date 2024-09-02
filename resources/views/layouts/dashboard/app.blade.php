<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('templates/assets/img/kaiadmin/pln.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('templates/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('templates/assets/css/fonts.min.css') }}"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>


    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('templates/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templates/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templates/assets/css/kaiadmin.min.css') }}" />

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <!-- Additional CSS for Demo -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.notification-link').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    var form = this.closest('.notification-form');
                    var url = this.getAttribute('href');
                    if (form) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', form.action, true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                window.location.href = url;
                            }
                        };
                        var formData = new FormData(form);
                        var formBody = new URLSearchParams(formData).toString();
                        xhr.send(formBody);
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('layouts.dashboard.partials.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('layouts.dashboard.partials.navbar')
            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>
            @include('layouts.dashboard.partials.footer')
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('templates/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('templates/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('templates/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('templates/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Additional JS Files -->
    <script src="{{ asset('templates/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('templates/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('templates/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('templates/assets/js/kaiadmin.min.js') }}"></script>

    <!-- Demo purposes only -->
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});
            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-select"><option value=""></option></select>'
                            )
                            .appendTo($(column.footer()).empty())
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d +
                                "</option>");
                        });
                    });
                }
            });
            $("#add-row").DataTable({
                pageLength: 5
            });
            var action =
                '<td><div class="form-button-action"><button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"><i class="fa fa-edit"></i></button><button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"><i class="fa fa-times"></i></button></div></td>';
            $("#addRowButton").click(function() {
                $("#add-row").dataTable().fnAddData([$("#addName").val(), $("#addPosition").val(), $(
                    "#addOffice").val(), action]);
                $("#addRowModal").modal("hide");
            });
        });
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)"
        });
        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)"
        });
        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)"
        });
    </script>

    {{-- Javascript Dropzone --}}
    <script>
        let uploadedFiles = [];
        let existingFiles = [];

        @if (isset($ticket) && $ticket->attachments)
            @php
                $attachments = explode(',', str_replace(['[', ']', '"'], '', $ticket->attachments));
            @endphp
            @foreach ($attachments as $attachment)
                existingFiles.push('{{ $attachment }}');
            @endforeach
        @endif

        let removedFiles = [];

        document.addEventListener('DOMContentLoaded', function() {
            const preview = document.querySelector('.preview');
            existingFiles.forEach(filePath => {
                const container = document.createElement('div');
                container.classList.add('image-container');

                const img = document.createElement('img');
                img.src = `{{ asset('') }}${filePath}`; // Menggunakan path relatif
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
            document.getElementById('remaining_attachments').value = existingFiles.join(',');
        }

        function removeExistingFile(event, filePath) {
            event.stopPropagation();
            const imgElement = document.querySelector(`img[src="{{ asset('') }}${filePath}"]`);
            if (imgElement && imgElement.parentElement) {
                existingFiles = existingFiles.filter(file => file !== filePath);
                removedFiles.push(filePath);
                imgElement.parentElement.remove();
                document.getElementById('removed_attachments').value = removedFiles.join(',');

                updateExistingFileList(); // Update remaining files list
            } else {
                console.error('File not found:', filePath);
            }
        }
    </script>


    @stack('scripts')
</body>

</html>
