@extends('partials.app')

@section('content')
<div class="container-fluid">

    <!-- Content Row -->
    <div class="card shadow mb-4" style="width: 70%;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <span class="m-0 font-weight-bold" style="color: black;">Tambah Parameter</span>
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

            <!-- Form untuk menambah parameter -->
            <form action="{{ route('parameter.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kriteria_id" class="form-label">Kriteria</label>
                    <select name="kriteria_id" id="kriteria_id" class="form-control" required>
                        <option value="">Pilih Kriteria</option>
                        @foreach($kriterias as $kriteria)
                            <option value="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</option>
                        @endforeach
                    </select>
                    @error('kriteria_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="parameter" class="form-label">Parameter</label>
                    <input type="text" class="form-control" name="parameter" id="parameter" value="{{ old('parameter') }}" required>
                    @error('parameter')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nilai" class="form-label">Bobot</label>
                    <input type="text" class="form-control" name="nilai" id="nilai" value="{{ old('nilai') }}" required>
                    @error('nilai')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
