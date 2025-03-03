@extends('layouts.dashboard.app')

@section('title')
    Ticket | SIAK Dukcapil
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Tiket
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Data Tiket</small>
                </h1>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="card mb-3">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h6 class="m-0 font-weight-bold text-dark">Laporan Tiket</h6>
                    </div>
                </div>
                <div class="card-body">
                    <!-- User Friendly Note -->
                    <div class="alert alert-info mb-10">
                        <h6 class="alert-heading">Panduan Penggunaan</h6>
                        <p class="mb-1">1. Masukkan <strong>Tanggal Awal</strong> untuk mulai periode pelaporan yang
                            diinginkan.</p>
                        <p class="mb-1">2. Masukkan <strong>Tanggal Akhir</strong> untuk mengakhiri periode pelaporan yang
                            diinginkan.</p>
                        <p class="mb-1">3. Klik tombol <strong>"Masukan Data"</strong> untuk menampilkan laporan
                            berdasarkan rentang tanggal yang dipilih.</p>
                        <p class="mb-0">4. Jika data ditemukan, Anda dapat mengklik tombol <strong>"Export"</strong> untuk
                            mengunduh laporan.</p>
                    </div>
                    <!-- End of User Friendly Note -->

                    <form action="{{ route('helpdesk.report.filter') }}" method="post" id="filter-form">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_awal" class="form-label mb-2">Tanggal Awal</label>
                                    <input type="date" id="tanggal_awal" name="awal" required class="form-control" style=" border: 2px solid #28a745;"
                                        value="{{ old('awal', $req1) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_akhir" class="form-label mb-2">Tanggal Akhir</label>
                                    <input type="date" id="tanggal_akhir" name="akhir" required class="form-control" style=" border: 2px solid #dc3545;"
                                        value="{{ old('akhir', $req2) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="category_id" class="form-label mb-2">Kategori</label>
                                <div class="d-flex align-items-center">
                                    <select name="category_id" id="category_id" class="form-select" data-control="select2"
                                        data-placeholder="Pilih Kategori">
                                        <option value="">Tidak Jadi Memilih</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-secondary ms-2"
                                        onclick="clearSelect('category_id')">X</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="priority_id" class="form-label mb-2">Prioritas</label>
                                <div class="d-flex align-items-center">
                                    <select name="priority_id" id="priority_id" class="form-select" data-control="select2"
                                        data-placeholder="Pilih Prioritas">
                                        <option value="">Tidak Jadi Memilih</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ old('priority_id', request('priority_id')) == $priority->id ? 'selected' : '' }}>
                                                {{ $priority->priority_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-secondary ms-2"
                                        onclick="clearSelect('priority_id')">X</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="status_id" class="form-label mb-2">Status</label>
                                <div class="d-flex align-items-center">
                                    <select name="status_id" id="status_id" class="form-select" data-control="select2"
                                        data-placeholder="Pilih Status">
                                        <option value="">Tidak Jadi Memilih</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ old('status_id', request('status_id')) == $status->id ? 'selected' : '' }}>
                                                {{ $status->status_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-secondary ms-2"
                                        onclick="clearSelect('status_id')">X</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="level" class="form-label mb-2">Disposisi</label>
                                <div class="d-flex align-items-center">
                                    <select name="level" id="level" class="form-select" data-control="select2"
                                        data-placeholder="Pilih Disposisi">
                                        <option value="">Tidak Jadi Memilih</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}"
                                                {{ old('level', request('level')) == $level->id ? 'selected' : '' }}>
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-secondary ms-2"
                                        onclick="clearSelect('level')">X</button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <input type="submit" class="btn btn-primary me-2" value="Masukan Data">
                            <a href="{{ route('helpdesk.report.index') }}" type="button"
                                class="btn btn-secondary">Atur ulang</a>
                        </div>
                    </form>
                </div>
            </div>

            @if (isset($tickets))
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-toolbar">
                            <form action="{{ route('helpdesk.report.export') }}" method="GET" class="d-inline">
                                <!-- Existing Date Range Filters -->
                                <input type="hidden" name="awal" value="{{ old('awal', $req1) }}">
                                <input type="hidden" name="akhir" value="{{ old('akhir', $req2) }}">

                                <!-- New Filters (Category, Priority, Status, and Disposition) -->
                                <input type="hidden" name="category_id"
                                    value="{{ old('category_id', request('category_id')) }}">
                                <input type="hidden" name="priority_id"
                                    value="{{ old('priority_id', request('priority_id')) }}">
                                <input type="hidden" name="status_id"
                                    value="{{ old('status_id', request('status_id')) }}">
                                <input type="hidden" name="level" value="{{ old('level', request('level')) }}">

                                <button type="submit" class="btn btn-success mb-4">
                                    <span class="img-icon">
                                        <img src="{{ asset('template/dist/assets/media/illustrations/office365.png') }}"
                                            alt="Export Icon" width="24" height="24">
                                    </span>
                                    Export
                                </button>
                            </form>
                            <!-- Tombol untuk membuka modal -->
                            <button type="button" class="btn btn-danger mb-4 ms-3" data-bs-toggle="modal"
                                data-bs-target="#pdfPreviewModal" onclick="loadPdfPreview()">
                                <i class="fas fa-eye"></i> Lihat PDF
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="pdfPreviewModal" tabindex="-1"
                                aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pdfPreviewModalLabel">Preview PDF</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Iframe untuk preview PDF -->
                                            <iframe id="pdfPreviewIframe" src="" width="100%" height="500px"
                                                frameborder="0"></iframe>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- Tombol untuk export PDF -->
                                            <form action="{{ route('helpdesk.report.export_pdf') }}" method="GET"
                                                class="d-inline">
                                                <input type="hidden" name="awal" value="{{ old('awal', $req1) }}">
                                                <input type="hidden" name="akhir" value="{{ old('akhir', $req2) }}">
                                                <input type="hidden" name="category_id"
                                                    value="{{ old('category_id', request('category_id')) }}">
                                                <input type="hidden" name="priority_id"
                                                    value="{{ old('priority_id', request('priority_id')) }}">
                                                <input type="hidden" name="status_id"
                                                    value="{{ old('status_id', request('status_id')) }}">
                                                <input type="hidden" name="level"
                                                    value="{{ old('level', request('level')) }}">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-file-pdf"></i> Export PDF
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table id="kt_datatable_example_5"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <thead>
                                <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th lass="min-w-70px">Nomor Tiket</th>
                                    <th lass="min-w-70px">Dibuat Tanggal</th>
                                    <th lass="min-w-70px">No Provinsi</th>
                                    <th lass="min-w-70px">Nama Provinsi</th>
                                    <th lass="min-w-70px">No Kabupaten</th>
                                    <th lass="min-w-70px">Nama Kabupaten</th>
                                    <th lass="min-w-70px">Keterangan Permasalahan</th>
                                    <th lass="min-w-70px">Kategori</th>
                                    <th lass="min-w-70px">Disposisi</th>
                                    <th lass="min-w-70px">Prioritas</th>
                                    <th lass="min-w-70px">Status</th>
                                    <th lass="min-w-70px">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @if (isset($hitung) && $hitung == 0)
                                    <tr>
                                        <td colspan="6" class="text-center">No tickets found for the selected date
                                            range.</td>
                                    </tr>
                                @else
                                    @foreach ($tickets as $key => $ticket)
                                        @php
                                            // Logika disposisi
                                            $disposisi = '-';
                                            if ($ticket->level1) {
                                                $disposisi = $ticket->helpdesk->name ?? '-';
                                            } elseif ($ticket->level2) {
                                                $disposisi = $ticket->koordinator->name ?? '-';
                                            } elseif ($ticket->level3) {
                                                $disposisi = $ticket->staffSubdit->name ?? '-';
                                            } elseif ($ticket->level4) {
                                                $disposisi = $ticket->siakDev->name ?? '-';
                                            } elseif ($ticket->level5) {
                                                $disposisi = $ticket->pejabat->name ?? '-';
                                            }

                                            // Logika prioritas
                                            $priority = match ($ticket->priority_id) {
                                                4 => 'Critical',
                                                3 => 'High',
                                                2 => 'Medium',
                                                1 => 'Low',
                                                default => '-',
                                            };

                                            // Logika status
                                            $status = match ($ticket->status_id) {
                                                1 => 'Tertunda',
                                                2 => 'Diterima',
                                                3 => 'Proses',
                                                4 => 'Selesai',
                                                5 => 'Buka Kembali',
                                                default => '-',
                                            };
                                        @endphp
                                        <tr>
                                            <td>{{ $ticket->no_ticket }}</td>
                                            <td>{{ $ticket->created_at->format('d-m-Y') }}</td>
                                            <td>{{ $ticket->province->no_province ?? '-' }}</td>
                                            <td>{{ $ticket->province->province_name ?? '-' }}</td>
                                            <td>{{ $ticket->cityOrRegency->no_city_or_regency ?? '-' }}</td>
                                            <td>{{ $ticket->cityOrRegency->city_or_regency_name ?? '-' }}</td>
                                            <td>{{ strip_tags(html_entity_decode($ticket->description)) ?? '-' }}</td>
                                            <td>{{ $ticket->category->category_name ?? '-' }}</td>
                                            <td>{{ $disposisi }}</td>
                                            <td>{{ $priority }}</td>
                                            <td>{{ $status }}</td>
                                            <td>{!! Str::limit($ticket->completion_notes, 20) !!}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function clearSelect(selectId) {
            // Reset hanya select yang dipilih berdasarkan ID
            var selectElement = document.getElementById(selectId);
            selectElement.value = '';

            // Jika menggunakan Select2 atau library serupa, reset juga select tersebut
            if (selectElement.hasAttribute('data-control') && selectElement.getAttribute('data-control') === 'select2') {
                $(selectElement).val(null).trigger('change');
            }
        }
    </script>

    <!-- JavaScript untuk mengatur iframe saat modal dibuka -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById('pdfPreviewModal');
            var iframe = document.getElementById('pdfPreviewIframe');

            modal.addEventListener('show.bs.modal', function() {
                var params = new URLSearchParams({
                    awal: "{{ old('awal', $req1) }}",
                    akhir: "{{ old('akhir', $req2) }}",
                    category_id: "{{ old('category_id', request('category_id')) }}",
                    priority_id: "{{ old('priority_id', request('priority_id')) }}",
                    status_id: "{{ old('status_id', request('status_id')) }}",
                    level: "{{ old('level', request('level')) }}"
                });

                iframe.src = "{{ route('helpdesk.report.preview_pdf') }}?" + params.toString();
            });
        });
    </script>

@endsection
