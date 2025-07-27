@extends('partials.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Penilaian</h1>

    {{-- Step 1: Form pilih alternatif --}}
    @if(!request()->has('step') || request('step') != 2)
        <form action="{{ route('penilaian.create') }}" method="GET">
            <input type="hidden" name="step" value="2">

            <div class="card shadow mb-4" style="width: 70%;">
                <div class="card-header">
                    <strong>Pilih Alternatif untuk Dinilai</strong>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>@foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach</ul>
                        </div>
                    @endif

                    <div class="form-group">
                        @foreach($alternatifs as $alternatif)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="alternatif_ids[]" value="{{ $alternatif->id }}" id="alt-{{ $alternatif->id }}">
                                <label class="form-check-label" for="alt-{{ $alternatif->id }}">
                                    {{ $alternatif->nama }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Lanjutkan</button>
                </div>
            </div>
        </form>
    @endif

    {{-- Step 2: Form isi penilaian berdasarkan alternatif yang dipilih --}}
    @if(request()->has('step') && request('step') == 2)
        @php
            // Ambil id alternatif yang dipilih dari request
            $selectedAlternatifIds = request('alternatif_ids', []);
            $selectedAlternatifs = $alternatifs->whereIn('id', $selectedAlternatifIds);
        @endphp

        <form action="{{ route('penilaian.storeBatch') }}" method="POST">
            @csrf
            {{-- Periode otomatis aktif --}}
             <input type="hidden" name="periode_id" value="{{ $periode->id }}">

            <div class="card shadow mb-4" style="width: 90%;">
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Alternatif</th>
                                @foreach($kriterias as $kriteria)
                                    <th>{{ $kriteria->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedAlternatifs as $alternatif)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $alternatif->nama }}
                                        <input type="hidden" name="penilaian[{{ $alternatif->id }}][alternatif_id]" value="{{ $alternatif->id }}">
                                    </td>

                                    @foreach($kriterias as $kriteria)
                                        @php
                                            $keyName = strtolower(str_replace(' ', '_', $kriteria->nama_kriteria)) . '_id';
                                        @endphp
                                        <td>
                                            <select name="penilaian[{{ $alternatif->id }}][{{ $keyName }}]" class="form-control" required>
                                                <option value="">Pilih</option>
                                                @foreach($kriteria->parameter as $parameter)
                                                    <option value="{{ $parameter->id }}">{{ $parameter->parameter }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-success mt-3">Simpan Semua Penilaian</button>
                </div>
            </div>
        </form>
    @endif

</div>
@endsection