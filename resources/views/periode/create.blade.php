@extends('partials.app')

@section('content')
<div class="container-fluid">

    <!-- Content Row -->
    <div class="card shadow mb-4" style="width: 70%;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <span class="m-0 font-weight-bold" style="color: black;">Tambah Periode</span>
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

            <!-- Form untuk menambah periode -->
            <form action="{{ route('periode.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_periode" class="form-label">Nama Periode</label>
                    <input type="text" class="form-control" name="nama" id="nama_periode" required>
                </div>

                <button type="submit" class="btn" style="background-color: #0066ff; color:white;">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
