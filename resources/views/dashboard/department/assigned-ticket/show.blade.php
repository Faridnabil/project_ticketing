@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Dukcapil
@endsection

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card">
                <div class="container">
                    <div class="card">
                        <div class="card-body py-2 me-xxl-9">
                            <div class="d-flex flex-column flex-xl-row">
                                <div class="flex-lg-row-fluid">
                                    <div class="card">
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
                                                        <div data-tns="true" data-tns-loop="true"
                                                            data-tns-swipe-angle="false" data-tns-speed="2000"
                                                            data-tns-autoplay="true" data-tns-autoplay-timeout="18000"
                                                            data-tns-controls="true" data-tns-nav="false" data-tns-items="1"
                                                            data-tns-center="false" data-tns-dots="false"
                                                            data-tns-prev-button="#kt_team_slider_prev1"
                                                            data-tns-next-button="#kt_team_slider_next1">

                                                            @foreach (explode(',', str_replace(['[', ']', '"'], '', $ticket->attachments)) as $index => $attachment)
                                                                <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                                                                    <img src="{{ asset($attachment) }}"
                                                                        alt="{{ basename($attachment) }}"
                                                                        class="card-rounded shadow mw-100"
                                                                        data-bs-toggle="modal"
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
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1">
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
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1">
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

                                                <!-- Comments section -->
                                                <div class="mb-5">

                                                    <!-- Form to submit a new comment -->
                                                    <div class="mb-0">
                                                        <form class="row g-3 needs-validation" method="POST"
                                                            action="{{ route('assignedTickets.store') }}"
                                                            enctype="multipart/form-data" novalidate>
                                                            @csrf
                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::user()->id }}">
                                                            <input type="hidden" name="ticket_id"
                                                                value="{{ $ticket->id }}">

                                                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message" cols="10"
                                                                rows="1"></textarea>

                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>

                                                            @error('message')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                            <button class="btn btn-primary mb-8"
                                                                type="submit">Simpan</button>
                                                        </form>
                                                    </div>

                                                    <!-- Display existing comments -->
                                                    @foreach ($comments as $comment)
                                                        <div id="comment-{{ $comment->id }}">
                                                            <form
                                                                action="{{ route('assignedTickets.update', $comment->id) }}"
                                                                method="POST" class="comment-form"
                                                                data-comment-id="{{ $comment->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                @if ($comment->user_id == auth()->user()->id)
                                                                    <div class="ms-9 mb-9">
                                                                    @else
                                                                        <div class="mb-9">
                                                                @endif
                                                                <div class="card card-bordered w-100">
                                                                    <div class="card-body">
                                                                        <div class="d-flex flex-stack mb-8">
                                                                            <div class="d-flex align-items-center f">
                                                                                <div class="symbol symbol-50px me-5">
                                                                                    <div
                                                                                        class="symbol-label fs-1 fw-bolder bg-light-success text-success">
                                                                                        {{ substr($comment->user->name, 0, 1) }}
                                                                                        <input type="hidden"
                                                                                            name="ticket_id"
                                                                                            value="{{ $ticket->id }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex flex-column fw-bold fs-5 text-gray-600 text-dark">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="#"
                                                                                            class="text-gray-800 fw-bolder text-hover-primary fs-5 me-3">
                                                                                            {{ $comment->user->name }}
                                                                                        </a>
                                                                                        @if ($comment->user_id == $comment->ticket->customer)
                                                                                            <span
                                                                                                class="badge badge-light-danger">Pemilik</span>
                                                                                        @endif
                                                                                    </div>
                                                                                    <span class="text-muted fw-bold fs-6">
                                                                                        {{ $comment->created_at->locale('id')->diffForHumans() }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="m-0">
                                                                                @if ($comment->user_id == auth()->user()->id)
                                                                                    <button type="button"
                                                                                        class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bolder edit-button"
                                                                                        data-comment-id="{{ $comment->id }}">Ubah</button>
                                                                                @endif
                                                                                @if ($comment->updated_at)
                                                                                    <span
                                                                                        class="badge badge-light-success">Dirubah</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <p class="fw-normal fs-5 text-gray-700 m-0"
                                                                            id="message-display-{{ $comment->id }}">
                                                                            {!! $comment->message !!}
                                                                        </p>
                                                                        <textarea name="message" class="form-control" id="message-{{ $comment->id }}" style="display: none">{{ $comment->message }}</textarea>
                                                                        <button class="btn btn-primary mt-2 update-button"
                                                                            id="update-button-{{ $comment->id }}"
                                                                            type="submit" style="display: none">Ubah
                                                                            Komentar</button>
                                                                        <input type="hidden" name="status_comment"
                                                                            value="Dirubah">
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        </form>
                                                </div>
                                                @endforeach


                                                @if (session('success'))
                                                    <div class="alert alert-success">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-column flex-lg-row-auto w-100 mw-xl-400px mb-10">
                                <div class="card bg-primary bg-opacity-5 mt-15 scrollable-card"
                                    style="max-height: 600px; overflow-y:auto;">
                                    <div class="card-body p-12">
                                        <h2 class="text-dark fw-bolder mb-11">Riwayat Aktivitas</h2>
                                        @foreach ($logs as $log)
                                            @if ($log->user_id != 1)
                                            @if ($log->attribute != 'attachments')
                                                <div
                                                    class="d-flex align-items-center @if (!$loop->last) mb-10 @endif">
                                                    <i class="bi bi-file-earmark-text text-primary fs-1 me-5"></i>
                                                    <div class="d-flex flex-column">
                                                        <h5 class="text-gray-800 fw-bolder">
                                                            <strong>
                                                                @if ($log->attribute == 'priority_id')
                                                                    Prioritas
                                                                @elseif($log->attribute == 'status_id')
                                                                    Status
                                                                @elseif($log->attribute == 'customer')
                                                                    Customer
                                                                @elseif($log->attribute == 'assign_to')
                                                                    Ditugaskan Ke
                                                                @elseif($log->attribute == 'assign_to')
                                                                    Ditugaskan Ke
                                                                @elseif($log->attribute == 'category_id')
                                                                    Kategori
                                                                @elseif($log->attribute == 'title')
                                                                    Judul
                                                                @elseif($log->attribute == 'due_date')
                                                                    Tanggal Jatuh Tempo
                                                                @elseif($log->attribute == 'description')
                                                                    Deskripsi
                                                                @elseif($log->attribute == 'attachments')
                                                                    Foto
                                                                @else
                                                                    {{ $log->attribute }}
                                                                @endif
                                                            </strong>:
                                                        </h5>
                                                        <div class="fw-bold">
                                                            @if ($log->old_value == null)
                                                                <span>
                                                                    @if (is_numeric($log->new_value))
                                                                        {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                                    @else
                                                                        {{ $log->new_value }}
                                                                    @endif
                                                                </span><br>
                                                                <span>Alasan: {!! $log->reason !!}</span>
                                                                <div class="text-muted">Dirubah oleh:
                                                                    {{ $log->user->name }} pada
                                                                    {{ date('d F Y H:i', strtotime($log->created_at)) }}
                                                                </div>
                                                            @else
                                                                <span class="text-muted">Dari:
                                                                    @if (is_numeric($log->old_value))
                                                                        {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                                    @elseif(is_string($log->old_value))
                                                                        {!! $log->old_value !!}
                                                                    @endif
                                                                </span>

                                                                <span>Untuk:
                                                                    @if (is_numeric($log->new_value))
                                                                        {{ $log->newPrioritas->priority_name ?? ($log->newCategory->category_name ?? ($log->newUser->name ?? $log->newStatus->status_name)) }}
                                                                    @elseif (is_string($log->new_value))
                                                                        {!! $log->new_value !!}
                                                                    @endif
                                                                </span>
                                                                <span>Alasan: {!! $log->reason !!}</span>
                                                                <div class="text-muted">Dirubah oleh:
                                                                    {{ $log->user->name }} pada
                                                                    {{ date('d F Y H:i', strtotime($log->created_at)) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
                        <img src="{{ asset($attachment) }}"
                            alt="{{ basename($attachment) }}" />
                    </div>
                </div><!--end modal-body-->
            </div>
        </div>
    </div>
@endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
