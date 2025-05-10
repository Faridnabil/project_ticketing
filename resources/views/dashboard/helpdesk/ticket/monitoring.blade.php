@extends('layouts.dashboard.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Monitoring Jumlah Tiket</h4>

    <ul class="nav nav-tabs" id="monitoringTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="regional-tab" data-bs-toggle="tab" data-bs-target="#regional" type="button" role="tab">Regional</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="provinsi-tab" data-bs-toggle="tab" data-bs-target="#provinsi" type="button" role="tab">Provinsi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kabupaten-tab" data-bs-toggle="tab" data-bs-target="#kabupaten" type="button" role="tab">Kabupaten/Kota</button>
        </li>
    </ul>

    <div class="tab-content pt-3" id="monitoringTabContent">
        {{-- Regional Tab --}}
        <div class="tab-pane fade show active" id="regional" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Regional</th>
                        <th>Jumlah Tiket</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($regionals as $regional)
                        <tr>
                            <td>{{ $regional->regional_name }}</td>
                            <td>{{ $regional->tickets_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Provinsi Tab --}}
        <div class="tab-pane fade" id="provinsi" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Provinsi</th>
                        <th>Jumlah Tiket</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($provinsis as $provinsi)
                        <tr>
                            <td>{{ $provinsi->name }}</td>
                            <td>{{ $provinsi->tickets_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Kabupaten Tab --}}
        <div class="tab-pane fade" id="kabupaten" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kabupaten/Kota</th>
                        <th>Jumlah Tiket</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kabupatens as $kabupaten)
                        <tr>
                            <td>{{ $kabupaten->type }} {{ $kabupaten->name }}</td>
                            <td>{{ $kabupaten->tickets_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
