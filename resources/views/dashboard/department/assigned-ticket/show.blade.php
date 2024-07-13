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
                        <div class="row gy-5 g-xl-12">
                            <div class="col-xl-7">
                                <div class="card-body py-14 me-xl-7 me-0 px-0 px-xxl-9">
                                    <div class="">
                                        <div class="d-flex align-items-center mb-12">
                                            <span class="svg-icon svg-icon-4qx svg-icon-success ms-n2 me-3">
                                                <!-- SVG Icon -->
                                            </span>
                                            <div class="d-flex flex-column">
                                                <h1 class="text-gray-800 fw-bold">{{ $ticket->title }}</h1>
                                                <div class="">
                                                    <span class="fw-bold text-muted me-6">Pemilik :
                                                        {{ $ticket->customers->name }}</span>
                                                    <span class="fw-bold text-muted">
                                                        Created:
                                                        <span
                                                            class="fw-bolder text-gray-600 me-1">{{ date('d F Y H:i', strtotime($ticket->created_at)) }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-10">
                                            <div class="mb-15 fs-5 fw-normal text-gray-800">
                                                <div class="mb-10">
                                                    {!! $ticket->description ?? '' !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-10">
                                            <!--begin::Product slider-->
                                            <div class="tns tns-default">
                                                <!--begin::Slider-->
                                                <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false"
                                                    data-tns-speed="2000" data-tns-autoplay="true"
                                                    data-tns-autoplay-timeout="18000" data-tns-controls="true"
                                                    data-tns-nav="false" data-tns-items="1" data-tns-center="false"
                                                    data-tns-dots="false" data-tns-prev-button="#kt_team_slider_prev1"
                                                    data-tns-next-button="#kt_team_slider_next1">

                                                    @foreach (explode(',', str_replace(['[', ']', '"'], '', $ticket->attachments)) as $index => $attachment)
                                                        <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                                                            <img src="{{ asset($attachment) }}"
                                                                alt="{{ basename($attachment) }}"
                                                                class="card-rounded shadow mw-100" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_2{{ $ticket->id }}_{{ $index }}" />
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!--end::Slider-->
                                                <!--begin::Slider button-->
                                                <button class="btn btn-icon btn-active-color-primary"
                                                    id="kt_team_slider_prev1">
                                                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-left.svg-->
                                                    <span class="svg-icon svg-icon-3x">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                                <path
                                                                    d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                                <!--end::Slider button-->
                                                <!--begin::Slider button-->
                                                <button class="btn btn-icon btn-active-color-primary"
                                                    id="kt_team_slider_next1">
                                                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-right.svg-->
                                                    <span class="svg-icon svg-icon-3x">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                                <path
                                                                    d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                                <!--end::Slider button-->
                                            </div>
                                            <!--end::Product slider-->
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-xl-5">
                                <!--begin::Messenger-->
                                <div class="card" id="kt_chat_messenger"
                                    style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
                                    <!--begin::Card header-->
                                    <div class="card-header" id="kt_chat_messenger_header">
                                        <!--begin::Title-->
                                        <div class="card-title">
                                            <!--begin::User-->
                                            <div class="d-flex justify-content-center flex-column me-3">
                                                <a href="#"
                                                    class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">Chat
                                                    Komentar</a>
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body" id="kt_chat_messenger_body">
                                        <!--begin::Messages-->
                                        <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto scrollable-card"
                                            style="max-height: 300px; overflow-y:auto;">
                                            @foreach ($comments as $comment)
                                                <div class="d-flex justify-content-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }} mb-10"
                                                    id="comment-{{ $comment->id }}">
                                                    <div
                                                        class="d-flex flex-column align-items-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }}">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="symbol symbol-35px symbol-circle">
                                                                <div
                                                                    class="symbol-label fs-1 fw-bolder bg-light-success text-success">
                                                                    {{ substr($comment->user->name, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="{{ $comment->user_id == auth()->user()->id ? 'me-3' : 'ms-3' }}">
                                                                <a href="#"
                                                                    class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{ $comment->user->name }}</a>
                                                                <span
                                                                    class="text-muted fs-7 mb-1">{{ $comment->created_at->locale('id')->diffForHumans() }}</span>
                                                                @if ($comment->user_id == $comment->ticket->customer)
                                                                    <span class="badge badge-light-danger">Pemilik</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="p-5 rounded bg-light-{{ $comment->user_id == auth()->user()->id ? 'primary' : 'info' }} text-dark fw-bold mw-lg-400px text-{{ $comment->user_id == auth()->user()->id ? 'end' : 'start' }}"
                                                            data-kt-element="message-text">
                                                            <p class="fw-normal fs-5 text-gray-700 m-0"
                                                                id="message-display-{{ $comment->id }}">
                                                                {!! $comment->message !!}
                                                            </p>
                                                            <form
                                                                action="{{ route('assignedTickets.update', $comment->id) }}"
                                                                method="POST" class="comment-form"
                                                                data-comment-id="{{ $comment->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <textarea name="message" class="form-control" id="message-{{ $comment->id }}" style="display: none">{{ $comment->message }}</textarea>
                                                            </form>
                                                        </div>
                                                        @if ($comment->updated_at)
                                                            <span class="badge badge-light-success">Dirubah</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!--end::Messages-->
                                    </div>
                                    <!--end::Card body-->
                                    <!--begin::Card footer-->
                                    <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                                        <form class="row g-3 mt-2 needs-validation" method="POST"
                                            action="{{ route('assignedTickets.store') }}" enctype="multipart/form-data"
                                            novalidate>
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="assign_to" value="{{ $ticket->customer }}">
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                            <textarea name="message" class="form-control form-control-flush mb-3 @error('message') is-invalid @enderror"
                                                id="message" cols="10" rows="1"></textarea>
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="d-flex flex-stack">
                                                <button class="btn btn-primary" type="submit"
                                                    data-kt-element="send">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!--end::Card footer-->
                                </div>
                                <!--end::Messenger-->
                            </div>
                        </div>
                    </div>
                    <!-- Riwayat -->
                    <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        <div class="col-xl-12">
                            <!--begin::List Widget 4-->
                            <div class="card card-xl-stretch mb-5 mb-xl-8 scrollable-card"
                                style="max-height: 756px; overflow-y: auto;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                <div class="card-body p-12">
                                    <h2 class="text-dark fw-bolder mb-11">Riwayat Aktivitas</h2>
                                    @foreach ($logs as $log)
                                        @if ($log->attribute != 'attachments')
                                            <div class="activity-log @if (!$loop->last) mb-10 @endif">
                                                <div class="log-header">
                                                    <h5 class="text-gray-800 fw-bolder mb-2">
                                                        <strong>
                                                            @if ($log->attribute == 'priority_id')
                                                                Data Prioritas
                                                            @elseif($log->attribute == 'status_id')
                                                                Data Status
                                                            @elseif($log->attribute == 'customer')
                                                                Data Customer
                                                            @elseif($log->attribute == 'assign_to')
                                                                Data Ditugaskan Ke
                                                            @elseif($log->attribute == 'category_id')
                                                                Data Kategori
                                                            @elseif($log->attribute == 'title')
                                                                Data Judul
                                                            @elseif($log->attribute == 'due_date')
                                                                Data Tanggal Jatuh Tempo
                                                            @elseif($log->attribute == 'description')
                                                                Data Deskripsi
                                                            @else
                                                                {{ $log->attribute }}
                                                            @endif
                                                        </strong>:
                                                    </h5>
                                                </div>
                                                <div class="log-body fw-bold">
                                                    @if ($log->old_value == null)
                                                        <div>
                                                            <span><strong>Nilai Baru : </strong>
                                                                @if (is_numeric($log->new_value))
                                                                    {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                                @else
                                                                    {{ $log->new_value }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Alasan :
                                                                </strong>{!! $log->reason !!}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Dirubah oleh :
                                                                </strong>{{ $log->user->name }}
                                                                pada
                                                                {{ date('d F Y H:i', strtotime($log->created_at)) }}</span>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <hr>
                                                            <span><strong>Data sebelum diubah :
                                                                </strong>
                                                                @if (is_numeric($log->old_value))
                                                                    {{ $log->oldPrioritas->priority_name ?? ($log->oldCategory->category_name ?? ($log->oldUser->name ?? $log->oldStatus->status_name)) }}
                                                                @else
                                                                    {!! $log->old_value !!}
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Menjadi : </strong>
                                                                @if (is_numeric($log->new_value))
                                                                    {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                                @else
                                                                    {!! $log->new_value !!}
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Alasan :
                                                                </strong>{!! $log->reason !!}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Diubah oleh :
                                                                </strong>{{ $log->user->name }}
                                                                pada
                                                                {{ date('d F Y H:i', strtotime($log->created_at)) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
