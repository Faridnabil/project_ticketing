@extends('layouts.dashboard.app')

@section('title')
    Edit Tiket | PLN ICON+
@endsection

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card">
                <div class="card-header card-header border-0 pt-6 ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Ticket</h4>
                    </div>
                    <div class="row g-5 g-xl-12">
                        <div class="col-xl-12">
                            <div class="card card-xl-stretch mb-xl-8">
                                <div class="card-body pt-5">
                                    <form class="row g-3 needs-validation" method="POST"
                                        action="{{ route('assignedSysadmin.update', $ticket->id) }}"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @method('PUT')

                                        <div class="col-md-2">
                                            <label for="validationCustom01" class="form-label">Status</label>
                                            <select name="status_id"
                                                class="form-select @error('status_id') is-invalid @enderror"
                                                data-control="select2" data-placeholder="Pilih Status" required autofocus>
                                                <option disabled>Pilih Status</option>
                                                @foreach ($statuses as $status)
                                                    @if (in_array($status->status_name, ['Aktif', 'Proses', 'Selesai']))
                                                        <option value="{{ $status->id }}"
                                                            {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                                                            {{ $status->status_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('status_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-10">
                                            <label for="solution" class="form-label">Solusi</label>
                                            <textarea name="solution" class="form-control @error('solution') is-invalid @enderror" id="solution" cols="10"
                                                rows="3">{{ old('solution', $ticket->solution) }}</textarea>
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('solution')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label class="d-block fw-bold fs-6 mb-3">Lampiran</label>
                                            <div class="custom-dropzone" onclick="document.getElementById('attachments').click()">
                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                <div class="dz-message">
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini atau
                                                        klik untuk mengunggah.</h3>
                                                    <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5 file</span>
                                                </div>
                                                <div class="preview" id="preview"></div>
                                            </div>
                                            <input type="file" id="attachments" name="attachments[]"
                                                class="form-control d-none" multiple>
                                            <input type="hidden" id="removed_attachments" name="removed_attachments">
                                            <input type="hidden" id="remaining_attachments" name="remaining_attachments">
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('attachments')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="error-message" id="error-message"></div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Ubah</button>
                                            <a href="{{ route('assignedSysadmin.index') }}" class="btn btn-danger">Batal</a>
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

    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#solution'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
