@extends('partials.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 font-weight-bold" style="color:rgb(17, 10, 54);">Daftar Parameter</h1>
        <a href="{{ route('parameter.create') }}" class="btn" style="background-color: #0066ff; color:white;">Tambah Parameter</a>
    </div>

    <!-- Content Row -->
    @foreach($kriterias as $kriteria)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span class="m-0 font-weight-bold" style="color: black;">{{ $kriteria->nama_kriteria }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; font-size: 1.2rem;">No</th>
                                <th style="text-align: center; font-size: 1.2rem;">Parameter</th>
                                <th style="text-align: center; font-size: 1.2rem;">Bobot</th>
                                <th style="text-align: center; font-size: 1.2rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Reset nomor urut untuk setiap kriteria -->
                            @php $no = 1; @endphp
                            @if(isset($parameters[$kriteria->id]) && count($parameters[$kriteria->id]) > 0)
                                @foreach($parameters[$kriteria->id] as $parameter)
                                    <tr>
                                        <!-- Gunakan nomor urut dari variabel $no -->
                                        <td style="text-align: center; padding: 1rem;">{{ $no++ }}</td>
                                        <td style="padding: 1rem;">{{ $parameter->parameter }}</td>
                                        <td style="padding: 1rem;">{{ $parameter->nilai }}</td>
                                        <td style="text-align: center; padding: 1rem;">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('parameter.edit', $parameter->id) }}" class="btn btn-success btn-sm" style="color: white;">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('parameter.destroy', $parameter->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus parameter ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" style="text-align: center;">Tidak ada parameter untuk kriteria ini</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection
