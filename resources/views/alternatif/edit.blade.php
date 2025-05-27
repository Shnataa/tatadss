@extends('partials.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Alternatif</h1>
    </div>

    <div class="card shadow mb-4" style="width: 70%;">
        <div class="card-header py-3">
            <span class="m-0 font-weight-bold" style="color: black;">Form Edit Alternatif</span>
        </div>
        <div class="card-body">

            <!-- Menampilkan pesan success jika ada -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('alternatif.update', $alternatif->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Alternatif</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $alternatif->nama }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>

        </div>
    </div>
</div>
@endsection
