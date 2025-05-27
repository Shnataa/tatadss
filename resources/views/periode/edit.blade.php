@extends('partials.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Periode</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4" style="width: 70%;">
        <div class="card-header py-3">
            <span class="m-0 font-weight-bold" style="color: black;">Form Edit Periode</span>
        </div>
        <div class="card-body">

            <!-- Menampilkan pesan success atau error -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form untuk mengedit periode -->
            <form action="{{ route('periode.update', $periode->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Periode</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $periode->nama) }}" required>
                </div>
                <button type="submit" class="btn" style="background-color: #0066ff; color: white;">Perbarui Periode</button>
            </form>
        </div>
    </div>

</div>
@endsection
