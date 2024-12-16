@extends('layouts.dashboard.app')

@section('title')
    Tambah Tiket | SIAK Dukcapil
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
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Tambah Tiket</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <!--begin::Row-->
            <div class="row g-5 g-xl-12">
                <div class="col-xl-12">
                    <!--begin::List Widget 1-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body pt-5">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('admin.ticket.store') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="no_ticket" value="{{ old('no_ticket') }}">
                                <select name="level1" hidden required>
                                    @foreach ($helpdeskRoles as $roleId)
                                        <option value="{{ $roleId }}"
                                            {{ old('level1') == $roleId ? 'selected' : '' }}>{{ $roleId }}</option>
                                    @endforeach
                                </select>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Kategori Permasalahan</label>
                                    <select name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Kategori" required autofocus>
                                        <option></option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
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

                                <div class="col-md-3">
                                    <label for="province_id" class="form-label">Nama Provinsi</label>
                                    <select id="province_id" data-control="select2" name="province_id"
                                        class="form-select @error('province_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>Pilih Provinsi</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                {{ $province->no_province }} - {{ $province->province_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="city_or_regency_id" class="form-label">Nama Kabupaten/Kota</label>
                                    <select id="city_or_regency_id" data-control="select2" name="city_or_regency_id"
                                        class="form-select @error('city_or_regency_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                                    </select>
                                    @error('city_or_regency_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Status</label>
                                    <select name="status_id" class="form-select @error('status_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Status" required autofocus>
                                        <option></option>
                                        @foreach ($statuses as $status)
                                            @if ($status->status_name !== 'Buka Kembali') {{-- Jika status bukan "Buka Kembali" --}}
                                                <option value="{{ $status->id }}"
                                                    {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->status_name }}
                                                </option>
                                            @endif
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

                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">PIC</label>
                                    <input type="text" name="pic" value="{{ old('pic') }}"
                                        class="form-control @error('pic') is-invalid @enderror" id="pic"
                                        placeholder="Masukan PIC">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('pic')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                                        class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                                        placeholder="Masukan jabatan">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('jabatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Prioritas</label>
                                    <select name="priority_id"
                                        class="form-select @error('priority_id') is-invalid @enderror"
                                        data-control="select2" data-placeholder="Pilih Prioritas" required autofocus>
                                        <option></option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                                {{ $priority->priority_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('priority_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">No Hp / WA</label>
                                    <input type="number" name="no_hp" value="{{ old('no_hp') }}"
                                        class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                        placeholder="Masukan Nomor Handphone/WA">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('no_hp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        cols="10" rows="3">{{ old('description') }}</textarea>
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
                                    <label class="d-block fw-bold fs-6 mb-5">Lampiran</label>
                                    <div class="custom-dropzone" onclick="document.getElementById('attachments').click()">
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <div class="dz-message">
                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1 mt-5">Letakkan file di sini atau
                                                klik untuk mengunggah.</h3>
                                            <span class="fs-7 fw-bold text-gray-400">Unggah hingga 5 file</span>
                                        </div>
                                        <div class="preview"></div>
                                    </div>
                                    <input type="file" id="attachments" name="attachments[]"
                                        class="form-control d-none" multiple>
                                    <div class="valid-feedback">Looks good!</div>
                                    @error('attachments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="error-message" id="error-message"></div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
                                </div>
                            </form>


                            <!--end form-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 1-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = $('#province_id');
            const citySelect = $('#city_or_regency_id');
            const oldProvinceId = "{{ old('province_id') }}";
            const oldCityId = "{{ old('city_or_regency_id') }}";

            // Initialize Select2
            provinceSelect.select2();
            citySelect.select2();

            function loadCities(provinceId, selectedCityId = null) {
                if (provinceId) {
                    fetch(`/get-cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Clear previous options
                            citySelect.html('<option value="">Pilih Kabupaten/Kota</option>');

                            // Add new options
                            data.forEach(city => {
                                citySelect.append(
                                    `<option value="${city.id}" ${city.id == selectedCityId ? 'selected' : ''}>${city.no_city_or_regency} - ${city.city_or_regency_name}</option>`
                                );
                            });

                            // Trigger Select2 to update the dropdown
                            citySelect.trigger('change');
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    citySelect.html('<option value="">Pilih Kabupaten/Kota</option>'); // Clear cities if no province is selected
                    citySelect.trigger('change');
                }
            }

            // Handle province change
            provinceSelect.on('change', function() {
                const provinceId = $(this).val();
                loadCities(provinceId);
            });

            // If there is an old province value, load the cities
            if (oldProvinceId) {
                loadCities(oldProvinceId, oldCityId);
            }
        });
    </script>


    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
