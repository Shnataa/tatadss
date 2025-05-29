@extends('partials.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 font-weight-bold" style="color:rgb(17, 10, 54);">Daftar Alternatif</h1>
        <a href="{{ route('alternatif.create') }}" class="btn btn-primary">Tambah Alternatif</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="m-0 font-weight-bold" style="color: black;">Tabel Alternatif</span>
        </div>
        <div class="card-body">
            <!-- Menampilkan pesan success jika ada -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">Nama</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alternatifs as $alternatif)
                            <tr>
                                <!-- Menggunakan $loop->iteration untuk ID yang berurutan -->
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td>{{ $alternatif->nama }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('alternatif.edit', $alternatif->id) }}" class="btn btn-success btn-sm" style="color: white;">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('alternatif.destroy', $alternatif->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus alternatif ini?')">
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

        </div>
    </div>

</div>
@endsection
