@extends('partials.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Alternatif</h1>
    </div>

    <div class="card shadow mb-4" style="width: 70%;">
        <div class="card-header py-3">
            <span class="m-0 font-weight-bold" style="color: black;">Form Tambah Alternatif</span>
        </div>
        <div class="card-body">

            <!-- Menampilkan pesan success jika ada -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form tambah alternatif -->
            <form action="{{ route('alternatif.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Alternatif</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Alternatif</button>
            </form>

        </div>
    </div>
</div>
@endsection
