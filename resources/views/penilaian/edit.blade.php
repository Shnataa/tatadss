@extends('partials.app')

@section('content')
<div class="container">
    <h1>Edit Penilaian</h1>

    <form action="{{ route('penilaian.update', $penilaian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="periode_id" class="form-label">Periode</label>
            <select name="periode_id" id="periode_id" class="form-control" required>
                <option value="">Pilih Periode</option>
                @foreach($periodes as $periode)
                    <option value="{{ $periode->id }}" {{ $penilaian->periode_id == $periode->id ? 'selected' : '' }}>
                        {{ $periode->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="alternatif_id" class="form-label">Alternatif</label>
            <select name="alternatif_id" id="alternatif_id" class="form-control" required>
                <option value="">Pilih Alternatif</option>
                @foreach($alternatifs as $alternatif)
                    <option value="{{ $alternatif->id }}" {{ $penilaian->alternatif_id == $alternatif->id ? 'selected' : '' }}>
                        {{ $alternatif->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Loop untuk menampilkan semua Kriteria -->
        @foreach($kriterias as $kriteria)
            <div class="mb-3">
                <label for="{{ $kriteria->nama }}" class="form-label">{{ $kriteria->nama_kriteria }}</label>
                <select name="{{ strtolower($kriteria->nama_kriteria) }}_id" class="form-control" required>
                    <option value="">Pilih Parameter</option>
                    @foreach($kriteria->parameter as $parameter)
                        <option value="{{ $parameter->id }}" {{ $penilaian->{strtolower($kriteria->nama_kriteria) . '_id'} == $parameter->id ? 'selected' : '' }}>
                            {{ $parameter->parameter }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
