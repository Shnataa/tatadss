@extends('partials.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 font-weight-bold" style="color:rgb(17, 10, 54);">Daftar Penilaian</h1>
        <a href="{{ route('penilaian.create') }}" class="btn btn-primary">Tambah Penilaian</a>
    </div>

    <!-- Card for Tabel Penilaian -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="m-0 font-weight-bold" style="color: black;">Tabel Penilaian</span>
        </div>
        <div class="card-body">

        <form method="GET" action="{{ route('penilaian.index') }}">
    <select name="periode_id">
        <option value="">Pilih Periode</option>
        @foreach ($periodes as $periode)
            <option value="{{ $periode->id }}" {{ request('periode_id') == $periode->id ? 'selected' : '' }}>
                {{ $periode->nama }}
            </option>
        @endforeach
    </select>
    <button type="submit">Tampilkan Penilaian</button>
</form>




            <!-- Menampilkan pesan success jika ada -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table for Daftar Penilaian -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">Periode</th>
                            <th style="text-align: center;">Alternatif</th>
                            <th style="text-align: center;">Panjang Ruas Jalan</th>
                            <th style="text-align: center;">Lebar Ruas Jalan</th>
                            <th style="text-align: center;">Jenis Permukaan Jalan</th>
                            <th style="text-align: center;">Kondisi Jalan</th>
                            <th style="text-align: center;">Mobilitas Jalan</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penilaians as $penilaian)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration + ($penilaians->currentPage() - 1) * $penilaians->perPage() }}</td>
                                <td>{{ $penilaian->periode->nama }}</td>
                                <td>{{ $penilaian->alternatif->nama }}</td>
                                <td style="text-align: center;">{{ $penilaian->panjangRuasJalan->parameter }}</td>
                                <td style="text-align: center;">{{ $penilaian->lebarRuasJalan->parameter }}</td>
                                <td style="text-align: center;">{{ $penilaian->jenisPermukaanJalan->parameter }}</td>
                                <td style="text-align: center;">{{ $penilaian->kondisiJalan->parameter }}</td>
                                <td style="text-align: center;">{{ $penilaian->mobilitasJalan->parameter }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-success btn-sm" style="color: white;">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('penilaian.destroy', $penilaian->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus penilaian ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tombol Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $penilaians->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>

</div>
@endsection
