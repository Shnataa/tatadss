@extends('partials.app')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hasil Akhir Perhitungan</h1>
    </div>

    <!-- Form untuk memilih periode -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="m-0 font-weight-bold" style="color: black;">Pilih Periode</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('hasilAkhir.index') }}">
                <div class="form-group">
                    <label for="periode_id">Pilih Periode</label>
                    <select name="periode_id" id="periode_id" class="form-control">
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}" {{ isset($periodeId) && $periodeId == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tampilkan Semua Skor</button>
            </form>
        </div>
    </div>

    <!-- Menampilkan hasil perhitungan jika periode dipilih -->
    @if(isset($hasilTertinggi) && $hasilTertinggi->isNotEmpty())
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="mt-3">Jalan yang perlu diperbaiki pada periode <strong>{{ $periodeNama }}</strong> Adalah:</h5>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Nama Jalan</th>
                                <th style="text-align: center;">Skor</th>
                                <th style="text-align: center;">Rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasilTertinggi as $hasil)
                                <tr>
                                    <td style="text-align: center;">{{ $hasil->alternatif->nama }}</td>
                                    <td style="text-align: center;">{{ number_format($hasil->skor, 2) }}</td>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Export Buttons -->
                <div class="mt-3">
                    <a href="{{ route('hasilAkhir.exportPdf', ['periodeId' => $periodeId]) }}" class="btn btn-danger">Export as PDF</a>
                </div>
            </div>
        </div>
    @else
        <p>No data available for the selected period.</p>
    @endif

</div>
@endsection
