@extends('partials.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 font-weight-bold" style="color:rgb(17, 10, 54);">Daftar Periode</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4" style="width: 100%;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <span class="m-0 font-weight-bold" style="color: black;">Tabel Periode</span>
            <a href="{{ route('periode.create') }}" class="btn" style="background-color: #0066ff; color:white;">Tambah Periode</a>
        </div>
        <div class="card-body">

            <!-- Menampilkan pesan success jika ada -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Menampilkan pesan error jika ada -->
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabel untuk menampilkan daftar periode -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">Nama</th>
                            <th style="text-align: center;">Flag</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($periodes as $index => $periode)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $periode->nama }}</td>
                                <td style="text-align: center;">
                                    @if($periode->flag)
                                        <span class="badge bg-success" style="color: white;">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary" style="color: white;">Tidak Aktif </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($periode->flag)
                                        <a href="{{ route('periode.deactivate', $periode->id) }}" class="btn btn-warning">Nonaktifkan</a>
                                    @else
                                        <a href="{{ route('periode.activate', $periode->id) }}" class="btn btn-success">Aktifkan</a>
                                    @endif
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
