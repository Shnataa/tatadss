<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Parameter;
use App\Models\Periode;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    //
    public function index()
{
    // Menghitung jumlah total periode
    $totalPeriode = Periode::count();

    // Menghitung jumlah periode aktif
    $totalPeriodeAktif = Periode::where('flag', true)->count();

    // Menghitung jumlah periode tidak aktif
    $totalPeriodeNonAktif = Periode::where('flag', false)->count();

    // Mengambil jumlah kriteria dan alternatif
    $totalKriteria = Kriteria::count();
    $totalAlternatif = Alternatif::count();

    return view('dashboard.index', compact(
        'totalPeriode', 
        'totalPeriodeAktif', 
        'totalPeriodeNonAktif', 
        'totalKriteria', 
        'totalAlternatif'
    ));
}


    
}
