@extends('partials.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 font-weight-bold">Perhitungan SMART</h1>
    </div>

    <!-- Card Section untuk pesan success atau error -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Card untuk Langkah-langkah Perhitungan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="h3 mb-0 font-weight-bold" style="color:rgb(29, 31, 33);">Langkah-langkah Perhitungan</span>
        </div>
        <div class="card-body">
            <ul>
                <!-- Langkah 1: Data Asli Penilaian -->
                <li><strong>1. Data Asli Penilaian:</strong>
                    <!-- Tabel Data Asli -->
                    <div class="table-responsive">
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Alternatif</th>
                                    @foreach($kriteria as $k)
                                        <th style="text-align: center;">{{ $k }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataAsli as $alternatifId => $nilaiAsli)
                                    <tr>
                                        <td style="text-align: center;">{{ $alternatifsData[$alternatifId] ?? 'Nama Tidak Ditemukan' }}</td>
                                        @foreach($nilaiAsli as $nilai)
                                            <td style="text-align: center;">{{ $nilai }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </li>

                <!-- Langkah 2: Matriks Penilaian (sebelum normalisasi) -->
                <li><strong>2. Normalisasi (Nilai/ Nilai Max):</strong>
                    <!-- Tabel dengan wrapper untuk responsivitas -->
                    <div class="table-responsive">
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Alternatif</th>
                                    @foreach($kriteria as $k)
                                        <th style="text-align: center;">{{ $k }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriksKeputusan as $alternatifId => $penilaianAlternatif)
                                    <tr>
                                        <td style="text-align: center;">{{ $alternatifsData[$alternatifId] ?? 'Nama Tidak Ditemukan' }}</td>
                                        @foreach($penilaianAlternatif as $nilai)
                                            <td style="text-align: center;">{{ $nilai }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </li>

                <!-- Langkah 3: Perhitungan Skor untuk Setiap Alternatif -->
                <li><strong>3. Perhitungan Skor untuk Setiap Alternatif (Nilai Normalisasi* bobot kriteria):</strong>
                    <ul>
                        @foreach($skorDetails as $alternatifId => $detail)
                            <li><strong>{{ $alternatifsData[$alternatifId] ?? 'Nama Tidak Ditemukan' }}:</strong>
                                <pre>{{ implode(', ', $detail) }}</pre>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <!-- Card Section untuk Hasil Perhitungan SMART -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="h3 mb-0 font-weight-bold" style="color:rgb(29, 31, 33);">Hasil Perhitungan SMART</span>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Alternatif</th>
                            <th style="text-align: center;">Skor</th>
                            <th style="text-align: center;">Rangking</th>
                        </tr>
                    </thead>
                        <tbody>
                            @php
                                $rank = $paginatedSkorSmart->firstItem();
                            @endphp
                            @foreach($paginatedSkorSmart as $alternatifId => $skor)
                                <tr>
                                    <td>{{ $alternatifsData[$alternatifId] ?? 'Nama Tidak Ditemukan' }}</td>
                                    <td>{{ number_format($skor, 2) }}</td>
                                    <td>{{ $rank++ }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                </table>
                <div class="d-flex justify-content-end mt-3">
    {{ $paginatedSkorSmart->links('pagination::bootstrap-4') }}
</div>
         
            </div>
        </div>
    </div>
</div>
@endsection