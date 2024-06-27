@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Ducapil
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

                                                <!-- Comments section -->
                                                <div class="mb-5">

                                                    <!-- Form to submit a new comment -->
                                                    <div class="mb-0">
                                                        <form class="row g-3 needs-validation" method="POST"
                                                            action="{{ route('assignedTicket.store') }}"
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
                                                                type="submit">Submit</button>
                                                        </form>
                                                    </div>

                                                    <!-- Display existing comments -->
                                                    @foreach ($comments as $comment)
                                                        <div id="comment-{{ $comment->id }}">
                                                            <form
                                                                action="{{ route('assignedTicket.update', $comment->id) }}"
                                                                method="POST" class="comment-form"
                                                                data-comment-id="{{ $comment->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="ms-9 mb-9">
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
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <a href="#"
                                                                                                class="text-gray-800 fw-bolder text-hover-primary fs-5 me-3">
                                                                                                {{ $comment->user->name }}
                                                                                            </a>
                                                                                            @if ($comment->user_id == $comment->ticket->customer)
                                                                                                <span
                                                                                                    class="badge badge-light-danger">Pemilik</span>
                                                                                            @endif
                                                                                        </div>
                                                                                        <span
                                                                                            class="text-muted fw-bold fs-6">
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
                                                                            <button
                                                                                class="btn btn-primary mt-2 update-button"
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
                                    <div class="card bg-primary bg-opacity-5 mt-15">
                                        <div class="card-body p-12">
                                            <h2 class="text-dark fw-bolder mb-11">Riwayat Aktivitas</h2>
                                            @foreach ($logs as $log)
                                                <div
                                                    class="d-flex align-items-center @if (!$loop->last) mb-10 @endif">
                                                    <i class="bi bi-file-earmark-text text-primary fs-1 me-5"></i>
                                                    <div class="d-flex flex-column">
                                                        <h5 class="text-gray-800 fw-bolder">
                                                            <strong>{{ $log->attribute }}</strong>:
                                                        </h5>
                                                        <div class="fw-bold">
                                                            <span class="text-muted">Dari: {{ $log->old_value }}</span>
                                                            <span>Untuk: {{ $log->new_value }}</span>
                                                            <span>Alasan: {{ $log->reason }}</span>
                                                            <div class="text-muted">Dirubah oleh: {{ $log->user->name }}
                                                                pada {{ $log->created_at }}</div>
                                                        </div>
                                                    </div>
                                                </div>
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
    </div>

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
