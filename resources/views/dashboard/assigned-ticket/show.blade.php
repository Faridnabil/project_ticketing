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
                                                        @if ($comment->user_id == auth()->id())
                                                            {{-- Jika komentar dari author --}}
                                                            <div class="ms-9 mb-9">
                                                                <div class="card card-bordered w-100">
                                                                    <div class="card-body">
                                                                        <div class="d-flex flex-stack mb-8">
                                                                            <div class="d-flex align-items-center f">
                                                                                <div class="symbol symbol-50px me-5">
                                                                                    <div
                                                                                        class="symbol-label fs-1 fw-bolder bg-light-success text-success">
                                                                                        {{ substr($comment->user->name, 0, 1) }}
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
                                                                        </div>
                                                                        <p class="fw-normal fs-5 text-gray-700 m-0">
                                                                            {{ $comment->message }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            {{-- Jika reply dari orang lain --}}
                                                            <div class="mb-9">
                                                                <div class="card card-bordered w-100">
                                                                    <div class="card-body">
                                                                        <div class="d-flex flex-stack mb-8">
                                                                            <div class="d-flex align-items-center f">
                                                                                <div class="symbol symbol-50px me-5">
                                                                                    <div
                                                                                        class="symbol-label fs-1 fw-bolder bg-light-success text-success">
                                                                                        {{ substr($comment->user->name, 0, 1) }}
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
                                                                        </div>
                                                                        <p class="fw-normal fs-5 text-gray-700 m-0">
                                                                            {{ $comment->message }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
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
    </script>
@endsection
