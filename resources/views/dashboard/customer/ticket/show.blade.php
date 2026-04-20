@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Dukcapil
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Show Tiket
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Detail Tiket</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    {{-- Riwayat Tiket  --}}
    <style>
        .activity-log {
            padding: 15px;
            background-color: #f9fafc;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .log-header {
            margin-bottom: 10px;
        }

        .log-body span {
            display: block;
            margin-bottom: 5px;
        }

        .log-body hr {
            margin: 10px 0;
            border: 0;
            border-top: 1px solid #272727;
        }

        .btn-custom {
            margin-right: 10px;
            border: none;
            background-color: #f8f9fa;
            padding: 10px 50px;
            border-radius: 5px;
        }

        .btn-custom.active {
            background-color: #007bff;
            color: white;
        }

        .font-regular {
            font-size: 1rem;
        }
    </style>

    <style>
        .timeline {
            list-style: none;
            padding: 0;
            position: relative;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            left: 20px;
            margin: 0;
        }

        .timeline-item {
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item.current-status .timeline-content {
            border: 2px solid #007bff;
        }

        .timeline-date {
            margin-left: 33px;
            font-weight: bold;
            color: #888;
        }

        .timeline-content {
            margin-left: 40px;
            background: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .timeline-title {
            margin: 0 0 5px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .timeline-text {
            margin: 0;
        }
    </style>

    <div id="kt_content_container" class="container mt-5">
        <div class="card">
            <div class="card-header" style="margin-top: 30px">
                <ul class="nav custom-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="btn-custom active font-regular mt-4" data-bs-toggle="tab" href="#keluhan" role="tab"
                            aria-selected="true">
                            <strong>Detail</strong>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-custom font-regular" data-bs-toggle="tab" href="#riwayat" role="tab"
                            aria-selected="false">
                            <Strong>Riwayat Aktivitas</Strong>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Detail Keluhan -->
                    <div class="tab-pane fade show active" id="keluhan" role="tabpanel">
                        <div class="row g-xl-12">
                            <div class="col-xl-12">
                                <div class="card-body">
                                    <div class="card shadow-sm p-4 mb-4">
                                        <div class="d-flex align-items-center">
                                            <span class="svg-icon svg-icon-4qx svg-icon-success ms-n2 me-3">
                                            </span>
                                            <div class="d-flex flex-column">
                                                <h1 class="text-primary fw-bold mb-2">{{ $ticket->title }} ({{ $ticket->no_ticket }})</h1>
                                                <div class="d-flex align-items-center gap-3 my-2">
                                                    <strong>Prioritas:</strong>
                                                    @if ($ticket->priority_id == '4')
                                                        <span class="badge"
                                                            style="background-color:red; color:white; font-weight:bold;">
                                                            {{ $ticket->priority->priority_name }}
                                                        </span>
                                                    @elseif($ticket->priority_id == '3')
                                                        <span class="badge"
                                                            style="background-color:#FF7F3E; color:white; font-weight:bold;">
                                                            {{ $ticket->priority->priority_name }}
                                                        </span>
                                                    @elseif($ticket->priority_id == '2')
                                                        <span class="badge"
                                                            style="background-color:blue; color:white; font-weight:bold;">
                                                            {{ $ticket->priority->priority_name }}
                                                        </span>
                                                    @elseif($ticket->priority_id == '1')
                                                        <span class="badge"
                                                            style="background-color:green; color:white; font-weight:bold;">
                                                            {{ $ticket->priority->priority_name }}
                                                        </span>
                                                    @else
                                                        <span class="badge"
                                                            style="background-color:rgb(77, 75, 75); color:white; font-weight:bold;">
                                                            -
                                                        </span>
                                                    @endif

                                                    <strong>Status:</strong>
                                                    @if ($ticket->status_id == '1')
                                                        <span class="badge"
                                                            style="background-color:red; color:white; font-weight:bold;">
                                                            Tertunda
                                                        </span>
                                                    @elseif($ticket->status_id == '2')
                                                        <span class="badge"
                                                            style="background-color:blue; color:white; font-weight:bold;">
                                                            Diterima
                                                        </span>
                                                    @elseif($ticket->status_id == '3')
                                                        <span class="badge"
                                                            style="background-color:#FF7F3E; color:white; font-weight:bold;">
                                                            Proses
                                                        </span>
                                                    @elseif($ticket->status_id == '4')
                                                        <span class="badge"
                                                            style="background-color:green; color:white; font-weight:bold;">
                                                            Selesai
                                                        </span>
                                                    @elseif($ticket->status_id == '5')
                                                        <span class="badge"
                                                            style="background-color:rgb(185, 192, 2); color:white; font-weight:bold;">
                                                            Buka Kembali
                                                        </span>
                                                    @else
                                                        <span class="badge"
                                                            style="background-color:rgb(77, 75, 75); color:white; font-weight:bold;">
                                                            -
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-muted">
                                                    <span class="fw-bold me-6"><i class="fas fa-user me-2"></i>Pemilik: {{ $ticket->customers->name }}</span>
                                                    <span class="fw-bold"><i class="fas fa-calendar-alt me-2"></i>Dibuat: {{ date('d F Y H:i', strtotime($ticket->created_at)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Problem and Solution Section -->
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="card shadow-sm p-7 h-100">
                                                <h1 class="text fw-bold mb-2">Permasalahan</h1>
                                                <div class="fs-5 fw-normal text-gray-800">
                                                    {!! $ticket->description ?? 'Tidak ada deskripsi tersedia.' !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card shadow-sm p-7 h-100">
                                                <h1 class="text fw-bold mb-2">Solusi</h1>
                                                <div class="fs-5 fw-normal text-gray-800">
                                                    {!! $ticket->completion_notes ?? '<span class="text-muted italic">Belum ada solusi.</span>' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lampiran Section -->
                                    <div class="card shadow-sm p-7 mb-4">
                                        <h1 class="text fw-bold mb-4">Lampiran Tiket</h1>
                                        <div class="d-flex flex-wrap justify-content-start">
                                            @php
                                                $attachments = explode(',', str_replace(['[', ']', '"'], '', $ticket->attachments));
                                            @endphp
                                            @if(count($attachments) > 0 && !empty($attachments[0]))
                                                @foreach ($attachments as $index => $attachment)
                                                    <div class="p-2">
                                                        <div class="card shadow-sm" style="width: 160px;">
                                                            <img src="{{ asset($attachment) }}" alt="{{ basename($attachment) }}" class="rounded-top"
                                                                style="width: 100%; height: 120px; object-fit: cover; cursor: pointer;"
                                                                data-bs-toggle="modal" data-bs-target="#kt_modal_2{{ $ticket->id }}_{{ $index }}" />
                                                            <div class="card-body text-center p-2">
                                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_2{{ $ticket->id }}_{{ $index }}">
                                                                    Lihat Lampiran
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted">Tidak ada lampiran.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Collapsible Comments Section -->
                                    <div class="accordion accordion-icon-toggle mt-4" id="kt_accordion_comments">
                                        <div class="mb-5">
                                            <div class="accordion-header py-3 d-flex" data-bs-toggle="collapse" data-bs-target="#kt_accordion_comments_item_1">
                                                <span class="accordion-icon"><i class="bi bi-chat-dots fs-3 text-primary"></i></span>
                                                <h3 class="fs-4 fw-bold mb-0 ms-4 text-primary">Chat Komentar</h3>
                                            </div>
                                            <div id="kt_accordion_comments_item_1" class="collapse fs-6 ps-10" data-bs-parent="#kt_accordion_comments">
                                                <div class="card shadow-sm">
                                                    <div class="card-body" id="kt_chat_messenger_body">
                                                        <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto scrollable-card" style="max-height: 400px; overflow-y:auto;">
                                                            @foreach ($comments as $comment)
                                                                <div class="d-flex justify-content-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }} mb-10" id="comment-{{ $comment->id }}">
                                                                    <div class="d-flex flex-column align-items-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }}">
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <div class="symbol symbol-35px symbol-circle">
                                                                                <div class="symbol-label fs-1 fw-bolder bg-light-success text-success">
                                                                                    {{ substr($comment->user->name, 0, 1) }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="{{ $comment->user_id == auth()->user()->id ? 'me-3' : 'ms-3' }}">
                                                                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{ $comment->user->name }}</a>
                                                                                <span class="text-muted fs-7 mb-1">{{ $comment->created_at->locale('id')->diffForHumans() }}</span>
                                                                                @if ($comment->user_id == $comment->ticket->customer)
                                                                                    <span class="badge badge-light-danger">Pemilik</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="p-5 rounded bg-light-{{ $comment->user_id == auth()->user()->id ? 'primary' : 'info' }} text-dark fw-bold mw-lg-600px text-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }}" data-kt-element="message-text">
                                                                            <div class="fw-normal fs-5 text-gray-700 m-0" id="message-display-{{ $comment->id }}">
                                                                                {!! $comment->message !!}
                                                                            </div>
                                                                            <form action="{{ route('myTickets.update', $comment->id) }}" method="POST" class="comment-form" data-comment-id="{{ $comment->id }}">
                                                                                @method('PUT')
                                                                                @csrf
                                                                                <textarea name="message" class="form-control" id="message-{{ $comment->id }}" style="display: none">{{ $comment->message }}</textarea>
                                                                            </form>
                                                                        </div>
                                                                        @if ($comment->updated_at && $comment->updated_at != $comment->created_at)
                                                                            <span class="badge badge-light-success">Dirubah</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                                                        <form class="row g-3 mt-2 needs-validation" method="POST" action="{{ route('myTickets.store') }}" enctype="multipart/form-data" novalidate>
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                            <input type="hidden" name="assign_to" value="{{ $ticket->assign_to }}">
                                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                            <textarea name="message" class="form-control form-control-flush mb-3 @error('message') is-invalid @enderror" id="message" cols="10" rows="1"></textarea>
                                                            @error('message')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <div class="d-flex flex-stack">
                                                                <button class="btn btn-primary" type="submit" data-kt-element="send">Kirim</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Riwayat -->
                    <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        <div class="col-xl-12">
                            <!--begin::List Widget 4-->
                            <div class="card card-xl-stretch mb-5 mb-xl-8 scrollable-card"
                                style="max-height: 756px; overflow-y: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                <div class="card-body p-12">
                                    <h2 class="text-dark fw-bolder mb-11">Riwayat Aktivitas</h2>
                                    <ul class="timeline">
                                        @foreach ($logs as $log)
                                            <li class="timeline-item {{ $loop->first ? 'current-status' : '' }}">
                                                <span
                                                    class="timeline-date">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</span>
                                                <div class="timeline-content">
                                                    <h5 class="timeline-title mb-3">{{ $log->h_title }}</h5>
                                                    <p class="timeline-text">
                                                        <strong>Nomor Tiket :</strong> {{ $log->h_no_ticket }}<br>
                                                        <strong>Ditugaskan Ke :</strong>
                                                        {{ $log->assignTo->name ?? 'N/A' }}<br>
                                                        <strong>Jatuh Tempo :</strong>
                                                        {{ \Carbon\Carbon::parse($log->h_due_date)->translatedFormat('d F Y') ?? 'N/A' }}
                                                        <br>
                                                        <strong>Status :</strong>
                                                        {{ $log->status->status_name ?? 'N/A' }}<br>
                                                        <strong>Lampiran :</strong>
                                                        @if ($log->h_attachments && is_string($log->h_attachments) && json_decode($log->h_attachments))
                                                            @foreach (json_decode($log->h_attachments) as $attachment)
                                                                @php
                                                                    $filename = basename($attachment);
                                                                    $parts = explode('_', $filename);
                                                                    $shortenedFilename = end($parts);
                                                                @endphp
                                                                <a href="#" class="attachment-link"
                                                                   data-bs-toggle="modal" data-bs-target="#imageModal"
                                                                   data-src="{{ asset($attachment) }}">{{ $shortenedFilename }}</a><br>
                                                            @endforeach
                                                        @else
                                                            N/A
                                                        @endif



                                                        <br>
                                                        <strong>Status Diubah Oleh :</strong>
                                                        {{ $log->statusChangedByUser->name ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Riwayat -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Lampiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Attachment" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modal.addEventListener('show.bs.modal', function(event) {
                const link = event.relatedTarget;
                const imageSrc = link.getAttribute('data-src');
                modalImage.src = imageSrc;
            });
        });
    </script>

    @foreach (explode(',', str_replace(['[', ']', '"'], '', $ticket->attachments)) as $index => $attachment)
        <div class="modal fade" tabindex="-1" id="kt_modal_2{{ $ticket->id }}_{{ $index }}">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title m-0 text" id="exampleModalprimary1">
                            Foto
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset($attachment) }}" alt="{{ basename($attachment) }}" />
                        </div>
                    </div><!--end modal-body-->
                </div>
            </div>
        </div>
    @endforeach

    {{-- Refresh Komentar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newCommentId = {{ session('new_comment_id') }};
            if (newCommentId) {
                const newCommentElement = document.getElementById('comment-' + newCommentId);
                if (newCommentElement) {
                    newCommentElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.modal').on('click', function(e) {
                if ($(e.target).hasClass('modal')) {
                    $(this).modal('hide');
                }
            });
        });
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#message'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#messageEdit'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-button');
            let currentEditor;

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const textarea = document.getElementById(`message-${commentId}`);
                    const displayParagraph = document.getElementById(
                        `message-display-${commentId}`);
                    const updateButton = document.getElementById(`update-button-${commentId}`);

                    // Hide all other textareas and update buttons
                    document.querySelectorAll('textarea').forEach(el => el.style.display = 'none');
                    document.querySelectorAll('.update-button').forEach(el => el.style.display =
                        'none');
                    // Destroy existing CKEditor instance
                    if (currentEditor) {
                        currentEditor.destroy();
                    }

                    // Show the current textarea and update button
                    textarea.style.display = 'block';
                    updateButton.style.display = 'block';

                    // Initialize CKEditor
                    ClassicEditor.create(textarea)
                        .then(editor => {
                            currentEditor = editor;
                        })
                        .catch(error => {
                            console.error(error);
                        });

                    // Hide all other display paragraphs
                    document.querySelectorAll('p[id^="message-display-"]').forEach(el => el.style
                        .display = 'block');
                    // Hide the current display paragraph
                    if (displayParagraph) {
                        displayParagraph.style.display = 'none';
                    }
                });
            });

            // Scroll to the last edited comment after page reload
            const lastEditedComment = localStorage.getItem('lastEditedComment');
            if (lastEditedComment) {
                const element = document.getElementById(`comment-${lastEditedComment}`);
                if (element) {
                    element.scrollIntoView();
                }
                localStorage.removeItem('lastEditedComment');
            }

            // Save the last edited comment ID before form submission
            const commentForms = document.querySelectorAll('.comment-form');
            commentForms.forEach(form => {
                form.addEventListener('submit', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    localStorage.setItem('lastEditedComment', commentId);
                });
            });
        });
    </script>
@endsection
