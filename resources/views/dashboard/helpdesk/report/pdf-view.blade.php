<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Tiket</title>
    <style>
        @page {
            size: landscape;
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        header img {
            height: 70px;
        }


        .header-left {
            text-align: left;
            margin: 0;
            /* Hapus margin */
        }

        .header-left h1,
        .header-left p {
            margin: 0;
            /* Hapus margin bawah */
        }

        .date {
            font-size: 12px;
            font-style: italic;
            color: #555;
            margin: 0;
            /* Hapus margin bawah */
            text-align: right;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
            color: gray;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header
        style="background-color: #1c2732;border-radius: 5px;display: flex;justify-content: space-between;padding: 10px 20px;margin-bottom: 10px;">
        <img src="{{ asset('template/dist/assets/media/logos/logo.png') }}" />
    </header>

    <div class="header-container">
        <div class="header-left" style="text-align: center">
            <h1>Laporan Tiket</h1>
            <p>Periode: {{ $startDate->format('d-F-Y') }} - {{ $endDate->format('d-F-Y') }}</p>
        </div>
        <p class="date" style="margin-bottom:10px">Dicetak pada: {{ now()->format('d-F-Y H:i') }}</p>
    </div>

    <!-- Table Section -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Tiket</th>
                <th>Dibuat Tanggal</th>
                <th>No Provinsi</th>
                <th>Nama Provinsi</th>
                <th>No Kabupaten</th>
                <th>Nama Kabupaten</th>
                <th>Permasalahan</th>
                <th>Solusi</th>
                <th>Kategori</th>
                <th>Disposisi</th>
                <th>Prioritas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
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
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $ticket->no_ticket }}</td>
                    <td> {{ \Carbon\Carbon::parse($ticket->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                    <td>{{ $ticket->province->no_province ?? '-' }}</td>
                    <td>{{ $ticket->province->province_name ?? '-' }}</td>
                    <td>{{ $ticket->cityOrRegency->no_city_or_regency ?? '-' }}</td>
                    <td>{{ $ticket->cityOrRegency->city_or_regency_name ?? '-' }}</td>
                    <td>
                        {!! nl2br(wordwrap(strip_tags(html_entity_decode($ticket->description)), 30, "\n", true)) ?? '-' !!}
                    </td>
                    <td>
                        {!! nl2br(wordwrap(strip_tags(html_entity_decode($ticket->completion_notes)), 30, "\n", true)) ?? '-' !!}
                    </td>
                    <td>{{ $ticket->category->category_name ?? '-' }}</td>
                    <td>{{ $disposisi }}</td>
                    <td>{{ $priority }}</td>
                    <td>{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer Section -->
    <footer>
        <p>Dokumen ini dicetak secara otomatis dari sistem ticket | SIAK DUKCAPIL {{ now()->format('Y') }}</p>
    </footer>
</body>

</html>
