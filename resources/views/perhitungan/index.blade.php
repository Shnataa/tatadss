@extends('partials.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 font-weight-bold" style="color:rgb(17, 10, 54);">Form Perhitungan Metode SMART</h1>
    </div>

    <!-- Card Form for Perhitungan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="m-0 font-weight-bold" style="color: black;">Pilih Periode</span>
        </div>
        <div class="card-body">
            <!-- Form for selecting periode -->
            <form action="{{ route('perhitungan.hitung') }}" method="GET">
                <div class="form-group">
                    <label for="periode_id">Pilih Periode</label>
                    <select name="periode_id" id="periode_id" class="form-control">
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}" {{ isset($periodeId) && $periodeId == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Lihat</button>
            </form>

        </div>
    </div>

</div>
@endsection
