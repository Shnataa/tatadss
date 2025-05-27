@extends('partials.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Penilaian</h1>
    </div>

    <!-- Card for Form Penilaian -->
    <div class="card shadow mb-4" style="width: 70%;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <span class="m-0 font-weight-bold" style="color: black;">Form Tambah Penilaian</span>
        </div>
        <div class="card-body">
            <!-- Menampilkan pesan error jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Menampilkan pesan error periode tidak aktif jika ada -->
            @if(session('error'))
                <script>
                    alert('{{ session('error') }}');
                    window.location.href = "{{ route('periode.index') }}"; // Redirect ke halaman pengaturan periode
                </script>
            @endif

            <!-- Form untuk menambah penilaian -->
            <form action="{{ route('penilaian.store') }}" method="POST">
                @csrf

                <!-- Dropdown Periode -->
                <div class="mb-3">
                    <label for="periode_id" class="form-label">Periode</label>
                    <select name="periode_id" id="periode_id" class="form-control" required>
                        <option value="">Pilih Periode</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Alternatif -->
                <div class="mb-3">
                    <label for="alternatif_id" class="form-label">Alternatif</label>
                    <select name="alternatif_id" id="alternatif_id" class="form-control" required>
                        <option value="">Pilih Alternatif</option>
                        @foreach($alternatifs as $alternatif)
                            <option value="{{ $alternatif->id }}"
                                @if(in_array($alternatif->id, $usedAlternatifs)) 
                                    disabled style="color: gray; background-color: #f0f0f0;"
                                @endif>
                                {{ $alternatif->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Loop untuk menampilkan semua Kriteria -->
                @foreach($kriterias as $kriteria)
                    <div class="mb-3">
                        <label for="{{ strtolower($kriteria->nama_kriteria) }}" class="form-label">{{ $kriteria->nama_kriteria }}</label>
                        <select name="{{ strtolower($kriteria->nama_kriteria) }}_id" class="form-control" required>
                            <option value="">Pilih Parameter</option>
                            @foreach($kriteria->parameter as $parameter)
                                <option value="{{ $parameter->id }}">{{ $parameter->parameter }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection
