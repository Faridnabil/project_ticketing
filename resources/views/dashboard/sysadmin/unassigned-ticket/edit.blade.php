@extends('layouts.dashboard.app')

@section('title')
    Edit Tiket | PLN ICON+
@endsection

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card-header card-header border-0 pt-6 ">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Ticket</h4>
                </div>
                <div class="row g-5 g-xl-12">
                    <div class="col-xl-12">
                        <div class="card card-xl-stretch mb-xl-8">
                            <div class="card-body pt-5">
                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ route('unassignedSysadmin.update', $ticket->id) }}"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <div class="col-md-6">
                                        <label for="priority_id" class="form-label">Prioritas</label>
                                        <select name="priority_id"
                                            class="form-select @error('priority_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Pilih Prioritas" required autofocus>
                                            <option disabled>Pilih Prioritas</option>
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

                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label">Kategori</label>
                                        <select name="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Pilih Kategori" required autofocus>
                                            <option disabled>Pilih Kategori</option>
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

                                    {{-- <div class="col-md-6">
                                            <label for="service_id" class="form-label">Layanan</label>
                                            <select name="service_id"
                                                class="form-select @error('service_id') is-invalid @enderror"
                                                data-control="select2" data-placeholder="Pilih Layanan" required autofocus>
                                                <option disabled>Pilih Layanan</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}"
                                                        {{ $ticket->service_id == $service->id ? 'selected' : '' }}>
                                                        {{ $service->service_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('service_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Ubah</button>
                                        <a href="{{ route('unassignedSysadmin.index') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
