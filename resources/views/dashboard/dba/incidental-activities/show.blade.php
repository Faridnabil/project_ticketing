@extends('layouts.dashboard.app')

@section('title')
    Detail Incidental Activity | PLN Icon+
@endsection

@section('content')
    <div id="kt_content_container" class="container">
        <a href="{{ route('dba.incidental-activities.index') }}" class="btn btn-custom">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div class="card">
            <div class="card-header card-header border-0 pt-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Incidental Activity</h4>
                </div>
                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Detail Incidental Activity -->
                        <div class="tab-pane fade show active" id="activity" role="tabpanel">
                            <div class="row gy-5 g-xl-12">
                                <!-- Column for Activity Details -->
                                <div class="col-xl-6">
                                    <div class="card-body py-14 me-xl-7 me-0 px-0 px-xxl-9">
                                        <div class="d-flex flex-column">
                                            <h1 class="text-gray-800 fw-bold">{{ $activity->title }}</h1>
                                            <div>
                                                <span class="fw-bold text-muted">Kategori:
                                                    {{ $activity->category->category_name }}</span><br>
                                                <span class="fw-bold text-muted">Deskripsi:
                                                    {{ strip_tags($activity->description) }}</span><br>
                                                <span class="fw-bold text-muted">Waktu Mulai:
                                                    {{ date('d F Y', strtotime($activity->start_time)) }}</span><br>
                                                <span class="fw-bold text-muted">Waktu Selesai:
                                                    {{ date('d F Y', strtotime($activity->end_time)) }}</span><br>
                                                <span class="fw-bold text-muted">Pelaksana:
                                                    {{ $assigned_users->isEmpty() ? 'Tidak ada pelaksana' : implode(', ', $assigned_users->pluck('name')->toArray()) }}</span><br>
                                                <span class="fw-bold text-muted">Mitigasi:
                                                    {{ strip_tags($activity->mitigation) }}</span><br>
                                                <span class="fw-bold text-muted">Dampak:
                                                    {{ strip_tags($activity->impact) }}</span><br>
                                                <span class="fw-bold text-muted">Dibuat:
                                                    <span class="fw-bolder text-gray-600 me-1">
                                                        {{ date('d F Y H:i', strtotime($activity->created_at)) }}</span>
                                                </span><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column for File View -->
                                <div class="col-xl-6">
                                    <div class="card-body py-14 me-xl-7 me-0 px-0 px-xxl-9">
                                        <div class="d-flex flex-column">
                                            <h5 class="fw-bold mb-4">File Lampiran</h5>
                                            @if ($activity->file_path)
                                                @php
                                                    $fileExtension = pathinfo($activity->file_path, PATHINFO_EXTENSION);
                                                @endphp
                                                <span class="fw-bold text-muted">File:
                                                    @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                        <!-- Thumbnail for Image Files -->
                                                        <img src="{{ asset($activity->file_path) }}" alt="Uploaded Image"
                                                            class="img-thumbnail mt-2" style="max-width: 300px;">
                                                    @elseif($fileExtension === 'pdf')
                                                        <!-- Thumbnail for PDF (using PDF icon as placeholder) -->
                                                        <a href="{{ asset($activity->file_path) }}" target="_blank"
                                                            class="btn btn-danger">
                                                            <span class="btn-label">
                                                                <i class="fas fa-file-pdf"></i>
                                                            </span>
                                                            View PDF</a>
                                                    @elseif(in_array($fileExtension, ['doc', 'docx']))
                                                        <!-- Thumbnail for Word Files (using Word icon as placeholder) -->
                                                        <a href="{{ asset($activity->file_path) }}" target="_blank"
                                                            class="btn btn-primary">
                                                            <span class="btn-label">
                                                                <i class="fas fa-file-word"></i>
                                                            </span>Download</a>
                                                    @elseif(in_array($fileExtension, ['xls', 'xlsx']))
                                                        <!-- Thumbnail for Excel Files (using Excel icon as placeholder) -->
                                                        <a href="{{ asset($activity->file_path) }}" target="_blank"
                                                            class="btn"
                                                            style="background-color: #17ba4b; color:white"><span
                                                                class="btn-label">
                                                                <i class="fas fa-file-excel"></i>
                                                            </span>Download</a>
                                                    @else
                                                        <!-- Generic icon for other file types -->
                                                        <img src="{{ asset('path/to/generic-file-icon.png') }}"
                                                            alt="File Thumbnail" class="img-thumbnail mt-2"
                                                            style="max-width: 100px;">
                                                        <a href="{{ asset($activity->file_path) }}" target="_blank"
                                                            class="btn btn-outline-secondary mt-2">Download File</a>
                                                    @endif
                                                </span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End of Row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
