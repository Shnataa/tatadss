@extends('partials.app')

@section('content')
<div class="container-fluid">

    <!-- Content Row -->
    <div class="card shadow mb-4" style="width: 70%;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <span class="m-0 font-weight-bold" style="color: black;">Tambah Kriteria</span>
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

            <!-- Menampilkan pesan success jika ada -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form untuk menambah kriteria -->
            <form action="{{ route('kriteria.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                    <input type="text" class="form-control" name="nama_kriteria" id="nama_kriteria" required>
                </div>
                <div class="mb-3">
                    <label for="bobot" class="form-label">Bobot</label>
                    <input type="text" class="form-control" name="bobot" id="bobot" required>
                </div>
                <div class="mb-3">
                    <label for="tipe_kriteria">Tipe Kriteria</label>
                    <select class="form-control" id="tipe_kriteria" name="tipe_kriteria" required>
                        <option value="Cost" {{ (isset($kriteria) && $kriteria->tipe_kriteria == 'Cost') ? 'selected' : '' }}>Cost</option>
                        <option value="Benefit" {{ (isset($kriteria) && $kriteria->tipe_kriteria == 'Benefit') ? 'selected' : '' }}>Benefit</option>
                    </select>
                </div>
                <button type="submit" class="btn" style="background-color: #0066ff; color:white;">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
