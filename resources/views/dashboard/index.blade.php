@extends('partials.app') <!-- Extend the main layout -->

@section('content') <!-- Define the content section to be injected into the layout -->

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 font-weight-bold" style="color:rgb(17, 10, 54);">Dashboard</h1>

    <!-- Dashboard Content -->
    <div class="row">

        <!-- Total Periode Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow border-left-primary rounded-3">
                <div class="card-body">
                    <div class="text-muted mb-2" style="font-size: 1rem;">Total Periode</div>
                    <div class="h4 font-weight-bold text-primary">{{ $totalPeriode }}</div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="text-success">Aktif: {{ $totalPeriodeAktif }}</span>
                        <span class="text-danger">Tidak Aktif: {{ $totalPeriodeNonAktif }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Kriteria Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow border-left-success rounded-3">
                <div class="card-body">
                    <div class="text-muted mb-2" style="font-size: 1rem;">Total Kriteria</div>
                    <div class="h4 font-weight-bold text-success">{{ $totalKriteria }}</div>
                    <hr>
                    <div>
                        <span class="text-muted">Pengelompokan kriteria lengkap</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Alternatif Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow border-left-warning rounded-3">
                <div class="card-body">
                    <div class="text-muted mb-2" style="font-size: 1rem;">Total Alternatif</div>
                    <div class="h4 font-weight-bold text-warning">{{ $totalAlternatif }}</div>
                    <hr>
                    <div>
                        <span class="text-muted">Total data alternatif tersedia</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End of Row -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow border-left-info rounded-3">
            <div class="card-body">
                <div class="text-muted mb-2" style="font-size: 1rem;">Kondisi Infrastruktur</div>
                <canvas id="kondisiChart"></canvas>
            </div>
        </div>
    </div>
   
</div>
    
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function () {
    const response = await fetch('/chart-data-penilaian');
    const data = await response.json();

    // Urutkan data agar sesuai dengan warna
    const kondisiOrder = ['Rusak Berat', 'Rusak Ringan', 'Sedang', 'Baik'];
    data.sort((a, b) => kondisiOrder.indexOf(a.kondisi) - kondisiOrder.indexOf(b.kondisi));

    const labels = data.map(item => item.kondisi);
    const totals = data.map(item => item.total);

    const ctx = document.getElementById('kondisiChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: totals,
                backgroundColor: [
                    '#F44336', // Rusak Berat - Merah
                    '#FFC107', // Rusak Ringan - Oranye
                    '#FFEB3B', // Sedang - Kuning
                    '#4CAF50'  // Baik - Hijau
                ],
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        },
    });
});

</script>




