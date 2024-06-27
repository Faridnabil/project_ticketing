@extends('layouts.dashboard.app')

@section('title')
    Edit Tiket | SIAK Dukcapil
@endsection

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Edit Tiket</small>
                </h1>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="row g-5 g-xl-12">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch mb-xl-8">
                        <div class="card-body pt-5">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('ticket.update', $ticket->id) }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="no_ticket" value="{{ $ticket->no_ticket }}">
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Judul</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $ticket->title) }}" autofocus
                                        required>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Pemilik</label>
                                    <select name="customer" class="form-control @error('customer') is-invalid @enderror"
                                        required autofocus>
                                        <option value="" disabled>Pilih Pemilik</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ $ticket->customer == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('customer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Ditugaskan Ke</label>
                                    <select name="assign_to" class="form-control @error('assign_to') is-invalid @enderror"
                                        required autofocus>
                                        <option value="" disabled>Pilih Departemen</option>
                                        @foreach ($assignTo as $assign)
                                            <option value="{{ $assign->id }}"
                                                {{ $ticket->assign_to == $assign->id ? 'selected' : '' }}>
                                                {{ $assign->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('assign_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Prioritas</label>
                                    <select name="priority_id"
                                        class="form-control @error('priority_id') is-invalid @enderror" required autofocus>
                                        <option value="" disabled>Pilih Prioritas</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ $ticket->priority_id == $priority->id ? 'selected' : '' }}>
                                                {{ $priority->priority_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('priority_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Tanggal Jatuh Tempo</label>
                                    <input type="date" name="due_date" class="form-control"
                                        value="{{ old('due_date', $ticket->due_date) }}">
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Status</label>
                                    <select name="status_id" class="form-control @error('status_id') is-invalid @enderror"
                                        required autofocus>
                                        <option value="" disabled>Pilih Status</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->status_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('status_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Kategori</label>
                                    <select name="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror" required autofocus>
                                        <option value="" disabled>Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        cols="10" rows="3">{{ old('description', $ticket->description) }}</textarea>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="reason" class="form-label">Alasan Perubahan</label>
                                    <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" id="reason" cols="10"
                                        rows="3">{{ old('reason') }}</textarea>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                    @error('reason')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="col-md-12">
                                    <label class="d-block fw-bold fs-6 mb-5">Lampiran</label>
                                    <div class="image-input image-input-outline" data-kt-image-input="true"
                                        style="background-image: url({{ asset($ticket->attachment) }})">
                                        <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: url({{ asset($ticket->attachment) }});"></div>
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Ganti lampiran">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="attachment" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="attachment_remove" />
                                        </label>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Batalkan lampiran">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Hapus lampiran">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                    <a href="{{ route('ticket.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                            <hr>
                            <h5>Riwayat Perubahan</h5>
                            <ul>
                                @foreach ($logs as $log)
                                    <li>
                                        <strong>{{ $log->attribute }}</strong>:
                                        <span>{{ $log->old_value }}</span>
                                        ->
                                        <span>{{ $log->new_value }}</span>
                                        oleh
                                        <strong>{{ $log->user->name }}</strong>
                                        dengan alasan
                                        <em>{{ $log->reason }}</em>
                                        pada {{ date('d F Y H:i', strtotime($log->created_at)) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
