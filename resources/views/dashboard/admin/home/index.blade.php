@extends('layouts.dashboard.app')

@section('title')
    Dashboard | SIAK Dukcapil
@endsection

@section('content')
    <style>
        .col {
            flex: 1;
            margin-right: 10px;
            height: 100px;
            /* Set a specific height for uniformity */
        }

        .col:last-child {
            margin-right: 0;
        }
    </style>

    <style>
        .activity-log {
            padding: 15px;
            background-color: #f9fafc;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .log-header {
            margin-bottom: 10px;
        }

        .log-body span {
            display: block;
            margin-bottom: 5px;
        }

        .log-body hr {
            margin: 10px 0;
            border: 0;
            border-top: 1px solid #272727;
        }

        .btn-custom {
            margin-right: 10px;
            border: none;
            background-color: #f8f9fa;
            padding: 10px 50px;
            border-radius: 5px;
        }

        .btn-custom.active {
            background-color: #007bff;
            color: white;
        }

        .font-regular {
            font-size: 1rem;
        }
    </style>

    {{-- Riwayat Tiket  --}}
    <style>
        .timeline {
            list-style: none;
            padding: 0;
            position: relative;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            left: 20px;
            margin: 0;
        }

        .timeline-item {
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item.current-status .timeline-content {
            border: 2px solid #007bff;
        }

        .timeline-date {
            margin-left: 33px;
            font-weight: bold;
            color: #888;
        }

        .timeline-content {
            margin-left: 40px;
            background: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .timeline-title {
            margin: 0 0 5px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .timeline-text {
            margin: 0;
        }
    </style>

    <!--begin::Toolbar-->
    {{--  card title  --}}
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-place="true" data-kt-place-mode="prepend"
                data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Dashboard
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1"></small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    {{--  card main  --}}
    <div class="post  " id="kt_post">
        <div id="kt_content_container" class="container">
            <div class="row">
                <!--begin::Col-->
                <div class="col-xxl-12 ">
                    <!--begin::Mixed Widget 2-->
                    <div class="card card-xxl-stretch" style="height: 190px">
                        <!--begin::Header-->
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title fw-bolder text-white">Data Keseluruhan</h3>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <!--end::Menu-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <div class="card-body p-0">
                            <!--begin::Chart-->
                            <div class="mixed card-rounded-bottom bg-primary" data-kt-color="primary" style="height: 28px">
                            </div>
                            <!--begin::Stats-->
                            <div class="card-p mt-n20 position-relative">
                                <!--begin::Row-->

                                <div class="row g-0">
                                    <div class="col"
                                        style="width: 25%; background-color: #e9ecef; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.75rem;">
                                        <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-1 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" version="1.1">
                                            <path
                                                d="M19,21H5c-2.757,0-5-2.243-5-5v-.922c0-.552,.448-1,1-1,.024,0,.053,.001,.082,.003,1.106-.021,2-.928,2-2.04s-.894-2.02-2-2.041c-.029,.002-.058,.003-.081,.003-.552,0-1-.448-1-1v-1.004C0,5.243,2.243,3,5,3h14c2.757,0,5,2.243,5,5v1c0,.552-.448,1-1,1-1.103,0-2,.897-2,2s.897,2,2,2c.552,0,1,.448,1,1v1c0,2.757-2.243,5-5,5ZM2,15.967v.033c0,1.654,1.346,3,3,3h14c1.654,0,3-1.346,3-3v-.126c-1.723-.445-3-2.013-3-3.874s1.277-3.428,3-3.874v-.126c0-1.654-1.346-3-3-3H5c-1.654,0-3,1.346-3,3v.115c1.767,.432,3.082,2.028,3.082,3.926s-1.315,3.494-3.082,3.926Z"
                                                fill="#000000" opacity="0.3" />
                                            <path
                                                d="M19,21H5c-2.757,0-5-2.243-5-5v-.922c0-.552,.448-1,1-1,.024,0,.053,.001,.082,.003,1.106-.021,2-.928,2-2.04s-.894-2.02-2-2.041c-.029,.002-.058,.003-.081,.003-.552,0-1-.448-1-1v-1.004C0,5.243,2.243,3,5,3h14c2.757,0,5,2.243,5,5v1c0,.552-.448,1-1,1-1.103,0-2,.897-2,2s.897,2,2,2c.552,0,1,.448,1,1v1c0,2.757-2.243,5-5,5ZM2,15.967v.033c0,1.654,1.346,3,3,3h14c1.654,0,3-1.346,3-3v-.126c-1.723-.445-3-2.013-3-3.874s1.277-3.428,3-3.874v-.126c0-1.654-1.346-3-3-3H5c-1.654,0-3,1.346-3,3v.115c1.767,.432,3.082,2.028,3.082,3.926s-1.315,3.494-3.082,3.926Z"
                                                fill="#000000" />
                                        </svg>
                                        </span>
                                        <span class="text-primary fw-bold fs-3">{{ $total_tiket }}</span>
                                        <a href="#" class="text-primary fw-bold fs-6">Total Tiket</a>
                                    </div>

                                    <div class="col"
                                        style="width: 25%; background-color: #fff3cd; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.75rem;">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-1 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" version="1.1">
                                            <path
                                                d="m12 4a1 1 0 0 1 -1-1v-2a1 1 0 0 1 2 0v2a1 1 0 0 1 -1 1zm1 19v-2a1 1 0 0 0 -2 0v2a1 1 0 0 0 2 0zm-9-11a1 1 0 0 0 -1-1h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1zm20 0a1 1 0 0 0 -1-1h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1zm-6.621-7.285 1-1.731a1 1 0 0 0 -1.731-1l-1 1.731a1 1 0 0 0 .365 1.366.987.987 0 0 0 .5.135 1 1 0 0 0 .866-.501zm-10.03 17.3 1-1.731a1 1 0 0 0 -1.731-1l-1 1.731a1 1 0 0 0 .364 1.366.989.989 0 0 0 .5.135 1 1 0 0 0 .867-.498zm-2.27-14.028a1 1 0 0 0 -.364-1.366l-1.731-1a1 1 0 0 0 -1 1.731l1.731 1a1 1 0 0 0 1.366-.365zm17.3 10.031a1 1 0 0 0 -.364-1.367l-1.731-1a1 1 0 0 0 -1 1.731l1.731 1a.987.987 0 0 0 .5.135 1 1 0 0 0 .867-.499zm-14.392-12.939a1 1 0 0 0 .365-1.366l-1-1.731a1 1 0 0 0 -1.731 1l1 1.731a1 1 0 0 0 .866.5.987.987 0 0 0 .5-.134zm10.031 17.3a1 1 0 0 0 .364-1.366l-1-1.731a1 1 0 0 0 -1.731 1l1 1.731a1 1 0 0 0 1.367.364zm2.269-14.03 1.731-1a1 1 0 0 0 -1-1.731l-1.731 1a1 1 0 0 0 1 1.731zm-17.3 10.03 1.731-1a1 1 0 0 0 -1-1.731l-1.731 1a1 1 0 0 0 .5 1.866.987.987 0 0 0 .497-.132z"
                                                fill="#000000" opacity="0.3" />
                                            <path
                                                d="m12 4a1 1 0 0 1 -1-1v-2a1 1 0 0 1 2 0v2a1 1 0 0 1 -1 1zm1 19v-2a1 1 0 0 0 -2 0v2a1 1 0 0 0 2 0zm-9-11a1 1 0 0 0 -1-1h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1zm20 0a1 1 0 0 0 -1-1h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1zm-6.621-7.285 1-1.731a1 1 0 0 0 -1.731-1l-1 1.731a1 1 0 0 0 .365 1.366.987.987 0 0 0 .5.135 1 1 0 0 0 .866-.501zm-10.03 17.3 1-1.731a1 1 0 0 0 -1.731-1l-1 1.731a1 1 0 0 0 .364 1.366.989.989 0 0 0 .5.135 1 1 0 0 0 .867-.498zm-2.27-14.028a1 1 0 0 0 -.364-1.366l-1.731-1a1 1 0 0 0 -1 1.731l1.731 1a1 1 0 0 0 1.366-.365zm17.3 10.031a1 1 0 0 0 -.364-1.367l-1.731-1a1 1 0 0 0 -1 1.731l1.731 1a.987.987 0 0 0 .5.135 1 1 0 0 0 .867-.499zm-14.392-12.939a1 1 0 0 0 .365-1.366l-1-1.731a1 1 0 0 0 -1.731 1l1 1.731a1 1 0 0 0 .866.5.987.987 0 0 0 .5-.134zm10.031 17.3a1 1 0 0 0 .364-1.366l-1-1.731a1 1 0 0 0 -1.731 1l1 1.731a1 1 0 0 0 1.367.364zm2.269-14.03 1.731-1a1 1 0 0 0 -1-1.731l-1.731 1a1 1 0 0 0 1 1.731zm-17.3 10.03 1.731-1a1 1 0 0 0 -1-1.731l-1.731 1a1 1 0 0 0 .5 1.866.987.987 0 0 0 .497-.132z"
                                                fill="#000000" />
                                        </svg>
                                        </span>
                                        <span class="text-warning fw-bold fs-3">{{ $tiket_buka_proses }}</span>
                                        <a href="#" class="text-warning fw-bold fs-6">Proses</a>
                                    </div>

                                    <div class="col"
                                        style="width: 25%; background-color: #f8d7da; padding: 1rem; border-radius: 0.5rem; ">
                                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-1 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" version="1.1">
                                            <path
                                                d="m15.999,15.5c-.188,0-.379-.053-.548-.164l-4-2.628c-.281-.186-.451-.499-.451-.836v-4.872c0-.553.447-1,1-1s1,.447,1,1v4.333l3.549,2.331c.462.304.59.924.287,1.385-.192.293-.512.451-.837.451Zm-3.285,6.475c-.236.017-.474.025-.714.025-5.514,0-10-4.486-10-10S6.486,2,12,2c3.151,0,6.112,1.512,7.988,4h-2.988c-.553,0-1,.447-1,1s.447,1,1,1h4c1.103,0,2-.897,2-2V2c0-.553-.447-1-1-1s-1,.447-1,1v2.104C18.743,1.543,15.473,0,12,0,5.383,0,0,5.383,0,12s5.383,12,12,12c.288,0,.573-.011.856-.031.551-.039.966-.518.926-1.068-.039-.55-.512-.975-1.068-.926Zm10.286-10.975c-.553,0-1,.447-1,1,0,.455-.031.913-.092,1.36-.074.548.31,1.052.856,1.126.046.006.091.009.136.009.493,0,.922-.364.99-.865.072-.536.109-1.085.109-1.63,0-.553-.447-1-1-1Zm-.863,5.396c-.484-.268-1.093-.088-1.357.396-.217.396-.464.782-.735,1.148-.328.444-.233,1.07.21,1.399.18.132.388.195.594.195.307,0,.609-.141.806-.405.323-.439.62-.902.88-1.377.266-.484.088-1.092-.396-1.357Zm-4.731,4.02c-.383.246-.783.467-1.191.656-.501.233-.719.827-.486,1.328.17.365.53.579.908.579.141,0,.284-.029.42-.093.491-.229.973-.493,1.432-.789.465-.299.599-.917.3-1.382-.299-.463-.918-.597-1.382-.3Z"
                                                fill="#000000" opacity="0.3" />
                                            <path
                                                d="m15.999,15.5c-.188,0-.379-.053-.548-.164l-4-2.628c-.281-.186-.451-.499-.451-.836v-4.872c0-.553.447-1,1-1s1,.447,1,1v4.333l3.549,2.331c.462.304.59.924.287,1.385-.192.293-.512.451-.837.451Zm-3.285,6.475c-.236.017-.474.025-.714.025-5.514,0-10-4.486-10-10S6.486,2,12,2c3.151,0,6.112,1.512,7.988,4h-2.988c-.553,0-1,.447-1,1s.447,1,1,1h4c1.103,0,2-.897,2-2V2c0-.553-.447-1-1-1s-1,.447-1,1v2.104C18.743,1.543,15.473,0,12,0,5.383,0,0,5.383,0,12s5.383,12,12,12c.288,0,.573-.011.856-.031.551-.039.966-.518.926-1.068-.039-.55-.512-.975-1.068-.926Zm10.286-10.975c-.553,0-1,.447-1,1,0,.455-.031.913-.092,1.36-.074.548.31,1.052.856,1.126.046.006.091.009.136.009.493,0,.922-.364.99-.865.072-.536.109-1.085.109-1.63,0-.553-.447-1-1-1Zm-.863,5.396c-.484-.268-1.093-.088-1.357.396-.217.396-.464.782-.735,1.148-.328.444-.233,1.07.21,1.399.18.132.388.195.594.195.307,0,.609-.141.806-.405.323-.439.62-.902.88-1.377.266-.484.088-1.092-.396-1.357Zm-4.731,4.02c-.383.246-.783.467-1.191.656-.501.233-.719.827-.486,1.328.17.365.53.579.908.579.141,0,.284-.029.42-.093.491-.229.973-.493,1.432-.789.465-.299.599-.917.3-1.382-.299-.463-.918-.597-1.382-.3Z"
                                                fill="#000000" />
                                        </svg>
                                        </span>
                                        <span class="text-danger fw-bold fs-3">{{ $tiket_tertunda }}</span>
                                        <a href="#" class="text-danger fw-bold fs-6 mt-2">Tiket Tertunda</a>
                                    </div>

                                    <div class="col"
                                        style="width: 25%; background-color: #d4edda; padding: 1rem; border-radius: 0.5rem;">
                                        <div class="mb-5">
                                            <span class="svg-icon svg-icon-3x svg-icon-success d-block my-1 mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" version="1.1">
                                                <path
                                                    d="M18,0H14V1a2,2,0,0,1-4,0V0H6A3,3,0,0,0,3,3V24h7V23a2,2,0,0,1,4,0v1h7V3A3,3,0,0,0,18,0ZM15.874,22a4,4,0,0,0-7.748,0H5V17H8V15H5V3A1,1,0,0,1,6,2H8.126a4,4,0,0,0,7.748,0H18a1,1,0,0,1,1,1V15H16v2h3v5Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M18,0H14V1a2,2,0,0,1-4,0V0H6A3,3,0,0,0,3,3V24h7V23a2,2,0,0,1,4,0v1h7V3A3,3,0,0,0,18,0ZM15.874,22a4,4,0,0,0-7.748,0H5V17H8V15H5V3A1,1,0,0,1,6,2H8.126a4,4,0,0,0,7.748,0H18a1,1,0,0,1,1,1V15H16v2h3v5Z"
                                                    fill="#000000" />
                                            </svg>
                                            </span>
                                            <span class="text-success fw-bold fs-3">{{ $tiket_selesai }}</span>
                                            <a href="#" class="text-success fw-bold fs-6 mt-2">Tiket Selesai</a>
                                        </div>
                                    </div>
                                </div>

                                <!--end::Row-->
                            </div>
                            <!--end::Stats-->
                        </div>

                        <br>
                        <br>
                    </div>
                    <!--end::Mixed Widget 2-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                {{-- <div class="col-xxl-12 mt-5">
                    <!--begin::List Widget 5-->
                    <div class="card card-xxl-stretch" style="height: 380px">
                        <!--begin::Header-->
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bolder mb-2 text-dark">Monitoring Tiket
                                    @if ($selectedTicketNumber)
                                        ({{ $selectedTicketNumber }})
                                    @endif
                                </span>
                            </h3>
                            <form action="{{ route('admin.dashboard.index') }}" method="GET">
                                <div class="input-group">
                                    <!-- Dropdown untuk memilih nomor tiket -->
                                    <select name="ticket_number" class="form-control mt-3">
                                        <option value="">Pilih Nomor Tiket</option>
                                        @foreach ($allTickets as $ticket)
                                            <option value="{{ $ticket->id }}"
                                                {{ $selectedTicketId == $ticket->id ? 'selected' : '' }}>
                                                {{ $ticket->no_ticket }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-3">Filter</button>
                                    <a href="{{ route('admin.dashboard.index') }}"
                                        class="btn btn-secondary mt-3 ms-2">Refresh</a>
                                </div>
                            </form>

                            <div class="col-xl-12 mt-6" style="max-height: 268px; overflow-y: auto;">
                                <ul class="timeline">
                                    @if ($selectedTicketId)
                                        @if ($logs->isEmpty())
                                            <div class="text-center mt-5">
                                                <img src="{{ asset('template/dist/assets/media/illustrations/terms-2.png') }} "
                                                    style="width: 280px" height="150px" alt="No History"
                                                    class="img-fluid" />
                                                <p class="mt-3">Tidak ada history untuk tiket yang dipilih.</p>
                                            </div>
                                        @else
                                            @foreach ($logs as $log)
                                                <li class="timeline-item {{ $loop->first ? 'current-status' : '' }}">
                                                    <span
                                                        class="timeline-date">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</span>
                                                    <div class="timeline-content">
                                                        <h5 class="timeline-title mb-3">{{ $log->h_title }}</h5>
                                                        <p class="timeline-text">
                                                            <strong>Nomor Tiket :</strong> {{ $log->h_no_ticket }}<br>
                                                            <strong>Nama Pemilik :</strong>
                                                            {{ $log->customers->name ?? 'N/A' }}<br>
                                                            <strong>Prioritas :</strong>
                                                            {{ $log->priority->priority_name ?? 'N/A' }}<br>
                                                            <strong>Jatuh Tempo :</strong>
                                                            {{ \Carbon\Carbon::parse($log->h_due_date)->translatedFormat('d F Y') ?? 'N/A' }}
                                                            <br>
                                                            <strong>Status :</strong>
                                                            {{ $log->status->status_name ?? 'N/A' }}<br>
                                                            <strong>Kategori :</strong>
                                                            {{ $log->category->category_name }}<br>
                                                            <strong>Lampiran :</strong>
                                                            @if ($log->h_attachments)
                                                                @foreach (json_decode($log->h_attachments) as $attachment)
                                                                    @php
                                                                        $filename = basename($attachment);
                                                                        $parts = explode('_', $filename);
                                                                        $shortenedFilename = end($parts);
                                                                    @endphp
                                                                    <a href="#" class="attachment-link"
                                                                        data-bs-toggle="modal" data-bs-target="#imageModal"
                                                                        data-src="{{ asset($attachment) }}">{{ $shortenedFilename }}</a><br>
                                                                @endforeach
                                                            @else
                                                                N/A
                                                            @endif
                                                            <br>
                                                            <strong>Status Diubah Oleh :</strong>
                                                            {{ $log->statusChangedByUser->name ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    @else
                                        <div class="text-center mt-5">
                                            <img src="{{ asset('template/dist/assets/media/illustrations/presentation.png') }}"
                                                alt="No History" class="img-fluid" style="width: 280px"
                                                height="150px" />
                                            <p class="mt-3">Silakan pilih nomor tiket untuk melihat history.</p>
                                        </div>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                    </div>
                    <!--end: List Widget 5-->

                    <!-- Modal Riwayat -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Lampiran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img id="modalImage" src="" alt="Attachment" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const modal = document.getElementById('imageModal');
                            const modalImage = document.getElementById('modalImage');

                            modal.addEventListener('show.bs.modal', function(event) {
                                const link = event.relatedTarget;
                                const imageSrc = link.getAttribute('data-src');
                                modalImage.src = imageSrc;
                            });
                        });
                    </script>

                </div> --}}
                <!--end::Col-->

                <!-- Left Column -->
                <div class="col-xl-12 col-lg-12 mb-4 mt-5">
                    <!-- First Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3 mt-3">Tiket Pertahun</h1>
                            <canvas id="ticketChart" width="80%" height="20px"></canvas>
                        </div>
                    </div>
                    <!-- Second Card -->
                    {{-- <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table id="kt_datatable_example_5"
                                class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-70px">Nomor Tiket</th>
                                        <th class="min-w-70px">Kategori</th>
                                        <th class="min-w-70px">Pemilik</th>
                                        <th class="min-w-70px">Tetapkan Ke</th>
                                        <th class="min-w-70px">Prioritas</th>
                                        <th class="min-w-70px">Dibuat Tanggal</th>
                                        <th class="min-w-70px">Status</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-bold">
                                    @if ($ticketPriotitas->count())
                                        @foreach ($ticketPriotitas as $ticket)
                                            <tr>
                                                <td>{{ $ticket->no_ticket }}</td>
                                                <td>{{ $ticket->category->category_name }}</td>
                                                <td>{{ $ticket->customers->name }}</td>
                                                <td>{{ $ticket->assignTo->name ?? '-' }}</td>
                                                <td>
                                                    @if ($ticket->priority_id == '4')
                                                        <span class="badge"
                                                            style="background-color:red; color: white; font-weight:bold">Critical</span>
                                                    @elseif($ticket->priority_id == '3')
                                                        <span class="badge"
                                                            style="background-color:#FF7F3E; color: white; font-weight:bold">High</span>
                                                    @elseif($ticket->priority_id == '2')
                                                        <span class="badge"
                                                            style="background-color:blue; color: white; font-weight:bold">Medium</span>
                                                    @elseif($ticket->priority_id == '1')
                                                        <span class="badge"
                                                            style="background-color:green; color: white; font-weight:bold">Low</span>
                                                    @else
                                                        <span class="badge"
                                                            style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ date('d F Y', strtotime($ticket->created_at)) }}</td>
                                                <td>
                                                    @if ($ticket->status_id == '1')
                                                        <span class="badge"
                                                            style="background-color:red; color: white; font-weight:bold">Tertunda</span>
                                                    @elseif($ticket->status_id == '2')
                                                        <span class="badge"
                                                            style="background-color:blue; color: white; font-weight:bold">Diterima</span>
                                                    @elseif($ticket->status_id == '3')
                                                        <span class="badge"
                                                            style="background-color:#FF7F3E; color: white; font-weight:bold">Proses</span>
                                                    @elseif($ticket->status_id == '4')
                                                        <span class="badge"
                                                            style="background-color:green; color: white; font-weight:bold">Selesai</span>
                                                    @else
                                                        <span class="badge"
                                                            style="background-color:rgb(77, 75, 75); color: white; font-weight:bold">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div> --}}
                </div>

                <!-- Right Column -->
                {{-- <div class="col-xl-3 col-lg-12">
                    <div class="card">
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ticketChart').getContext('2d');

            fetch('{{ url('/admin/tickets/chart') }}')
                .then(response => response.json())
                .then(data => {
                    const ticketChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.months,
                            datasets: [{
                                    label: 'Tiket Masuk',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    data: data.tickets
                                },
                                {
                                    label: 'Tiket Selesai',
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 1,
                                    data: data.ticketsClosed
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>
@endsection
