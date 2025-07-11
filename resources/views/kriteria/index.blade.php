@extends('partials.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 font-weight-bold" style="color:rgb(17, 10, 54);">Daftar Kriteria</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4" style="width: 100%;"> 
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <span class="m-0 font-weight-bold" style="color: black;">Tabel Kriteria</span>
            <button 
                class="btn" 
                style="background-color: #0066ff; color: white;" 
                onclick="handleTambahKriteria({{ $totalKriteria }})">
                Tambah Kriteria
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">Nama Kriteria</th>
                            <th style="text-align: center;">Bobot</th>
                            <th style="text-align: center;">Tipe Kriteria</th>  <!-- Kolom Tipe Kriteria -->
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriterias as $kriteria)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td> <!-- mengurutkan id tampilan code aslinya($kriteria->id) -->
                                <td>{{ $kriteria->nama_kriteria }}</td>
                                <td>{{ $kriteria->bobot }}</td>
                                <td style="text-align: center;">{{ $kriteria->tipe_kriteria }}</td> <!-- Tampilkan tipe_kriteria -->
                                <td style="text-align: center;">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>

                                    @php
                                        $isUsedInParameter = $kriteria->parameters ? $kriteria->parameters->count() > 0 : false;
                                    @endphp

                                    @if($isUsedInParameter)
                                        <button class="btn btn-danger btn-sm" disabled>
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    @else
                                        <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus parameter ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
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

<!-- Modal Popup -->
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupModalLabel">Notifikasi</h5>
            </div>
            <div class="modal-body">
                Tidak dapat menambah kriteria baru, batas maksimum kriteria telah tercapai.
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Modal dan Cek Kondisi -->
<script>
    function handleTambahKriteria(totalKriteria) {
        const maxKriteria = 5;
        if (totalKriteria >= maxKriteria) {
            // Tampilkan modal notifikasi jika batas tercapai
            const modal = new bootstrap.Modal(document.getElementById('popupModal'));
            modal.show();
        } else {
            // Jika tidak mencapai batas, redirect ke halaman tambah kriteria
            window.location.href = '{{ route('kriteria.create') }}';
        }
    }
</script>

@endsection
