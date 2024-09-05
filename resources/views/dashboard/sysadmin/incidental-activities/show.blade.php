@extends('layouts.dashboard.app')

@section('title')
Detail Incidental Activity | PLN Icon+
@endsection

@section('content')
<div id="kt_content_container" class="container">
    <a href="{{ route('sysadmin.incidental-activities.index') }}" class="btn btn-custom">
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
                            <div class="col-xl-12">
                                <div class="card-body py-14 me-xl-7 me-0 px-0 px-xxl-9">
                                    <div class="d-flex align-items-center mb-12">
                                        <div class="mb-12 ms-5">
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
                                                    </span>
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
        </div>
    </div>
</div>
@endsection
