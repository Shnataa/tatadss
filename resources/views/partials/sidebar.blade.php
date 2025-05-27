@if(Auth::check() && Auth::user()->role == 'superadmin')

<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #FFC928;" id="accordionSidebar">
    <li class="nav-item nav-link">
        <div class="d-flex align-items-center mx-3 mt-3">
            <!-- Add your image here -->
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px;">
            <!-- Title text with custom class for responsive font size -->
            <div class="sidebar-title" style="color: #0508B4; font-weight:bold;">SPK DPU Bangka Barat</div>
        </div>
    </li> 

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-tachometer-alt" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Dashboard</span>
        </a>
    </li>

    <!-- Periode -->
    <li class="nav-item">
        <a class="nav-link" href="{{URL::to('/dashboard/periode')}}">
            <i class="fas fa-calendar-alt" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Periode</span>
        </a>
    </li>

    <!-- Kriteria -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/kriteria">
            <i class="fas fa-list-alt" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Kriteria</span>
        </a>
    </li>

    <!-- Parameter -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/parameter">
            <i class="fas fa-cogs" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Parameter</span>
        </a>
    </li>

    <!-- Data Alternatif -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/alternatif">
            <i class="fas fa-users" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Data Alternatif</span>
        </a>
    </li>

    <!-- Penilaian -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/penilaian">
            <i class="fas fa-star" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Penilaian</span>
        </a>
    </li>

    <!-- Perhitungan -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/perhitungan">
            <i class="fas fa-calculator" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Perhitungan</span>
        </a>
    </li>

    <!-- Hasil Akhir -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/hasil-akhir"> 
            <i class="fas fa-check-circle" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Hasil Akhir</span>
        </a>
    </li>

    <!-- Sidebar Toggle Button -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<!-- Font Awesome Link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endif



<!-- admin-->

@if(Auth::check() && Auth::user()->role == 'admin')

<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #FFC928;" id="accordionSidebar">
    <li class="nav-item nav-link">
        <div class="d-flex align-items-center mx-3 mt-3">
            <!-- Add your image here -->
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px;">
            <!-- Title text with custom class for responsive font size -->
            <div class="sidebar-title" style="color: #0508B4; font-weight:bold;">SPK DPU Bangka Barat</div>
        </div>
    </li> 

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-tachometer-alt" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Dashboard</span>
        </a>
    </li>

    <!-- Periode -->
    <li class="nav-item">
        <a class="nav-link" href="{{URL::to('/dashboard/periode')}}">
            <i class="fas fa-calendar-alt" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Periode</span>
        </a>
    </li>


    <!-- Data Alternatif -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/alternatif">
            <i class="fas fa-users" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Data Alternatif</span>
        </a>
    </li>

    <!-- Penilaian -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/penilaian">
            <i class="fas fa-star" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Penilaian</span>
        </a>
    </li>

    <!-- Perhitungan -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/perhitungan">
            <i class="fas fa-calculator" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Perhitungan</span>
        </a>
    </li>

    <!-- Hasil Akhir -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard/hasil-akhir"> 
            <i class="fas fa-check-circle" style="color: #000;"></i> <!-- Icon -->
            <span style="color: #000;">Hasil Akhir</span>
        </a>
    </li>

    <!-- Sidebar Toggle Button -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<!-- Font Awesome Link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endif