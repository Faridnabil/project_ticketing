@extends('layouts.dashboard.app')

@section('title')
    Edit Incidental Activity | PLN Icon+
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card">
                <div class="card-header card-header border-0 pt-6 ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Incidental Activity</h4>
                    </div>
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-12">
                        <div class="col-xl-12">
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ route('sysadmin.incidental-activities.update', $activity->id) }}"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Judul</label>
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror" id="title"
                                            value="{{ old('title', $activity->title) }}" required autofocus>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label">Kategori</label>
                                        <select name="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Pilih Kategori" required>
                                            <option selected disabled>Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $activity->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                            cols="10" rows="3" required>{{ old('description', $activity->description) }}</textarea>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="status_id">Status</label>
                                        <select name="status_id" id="status_id" class="form-control">
                                            <option value="">Pilih Status</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ $activity->status_id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->status_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('status_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="start_time" class="form-label">Waktu Mulai</label>
                                        <input type="date" name="start_time"
                                            class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                                            value="{{ old('start_time', $activity->start_time) }}" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('start_time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="end_time" class="form-label">Waktu Selesai</label>
                                        <input type="date" name="end_time"
                                            class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                                            value="{{ old('end_time', $activity->end_time) }}" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('end_time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="users" class="form-label">Pilih Pelaksana</label>
                                        <select name="users[]" class="form-select" id="multiple-select-optgroup-field"
                                            data-placeholder="Pilih Pelaksana" multiple>
                                            <optgroup label="SysAdmin">
                                                @foreach ($users as $user)
                                                    @if ($user->hasRole('SysAdmin'))
                                                        <option value="{{ $user->id }}"
                                                            {{ in_array($user->id, $selectedUsers) ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="DBA">
                                                @foreach ($users as $user)
                                                    @if ($user->hasRole('DBA'))
                                                        <option value="{{ $user->id }}"
                                                            {{ in_array($user->id, $selectedUsers) ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('users')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="mitigation" class="form-label">Mitigasi</label>
                                        <textarea name="mitigation" class="form-control @error('mitigation') is-invalid @enderror" id="mitigation"
                                            cols="10" rows="3" required>{{ old('mitigation', $activity->mitigation) }}</textarea>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('mitigation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="impact" class="form-label">Dampak</label>
                                        <textarea name="impact" class="form-control @error('impact') is-invalid @enderror" id="impact" cols="10"
                                            rows="3" required>{{ old('impact', $activity->impact) }}</textarea>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('impact')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="file" class="form-label">Upload File</label>
                                        <input type="file" name="file"
                                            class="form-control @error('file') is-invalid @enderror" id="file">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                        <a href="{{ route('sysadmin.incidental-activities.index') }}"
                                            class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                                <!--end form-->
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#mitigation'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#impact'))
            .catch(error => {
                console.error(error);
            });
        $('#multiple-select-optgroup-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script>
@endsection
