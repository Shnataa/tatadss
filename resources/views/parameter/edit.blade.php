@extends('partials.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Parameter</h1>
    </div>

    <div class="card shadow mb-4" style="width: 70%;">
        <div class="card-header py-3">
            <span class="m-0 font-weight-bold" style="color: black;">Form Edit Parameter</span>
        </div>
        <div class="card-body">

            <!-- Menampilkan pesan success jika ada -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('parameter.update', $parameter->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kriteria_id" class="form-label">Kriteria</label>
                    <select name="kriteria_id" id="kriteria_id" class="form-control" required>
                        <option value="">Pilih Kriteria</option>
                        @foreach($kriterias as $kriteria)
                            <option value="{{ $kriteria->id }}" 
                                @if($kriteria->id == $parameter->kriteria_id) selected @endif>
                                {{ $kriteria->nama_kriteria }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="parameter" class="form-label">Parameter</label>
                    <input type="text" name="parameter" id="parameter" class="form-control" value="{{ $parameter->parameter }}" required>
                </div>

                <div class="mb-3">
                    <label for="nilai" class="form-label">Bobot</label>
                    <input type="text" name="nilai" id="nilai" class="form-control" value="{{ $parameter->nilai }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>

        </div>
    </div>

</div>
@endsection
