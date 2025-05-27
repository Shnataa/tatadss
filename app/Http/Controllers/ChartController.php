<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function getPenilaianData()
    {
        // Ambil data dari tabel penilaian dan hubungkan dengan parameter
        $data = DB::table('penilaian')
            ->join('parameter', 'penilaian.kondisi_jalan_id', '=', 'parameter.id')
            ->select('parameter.parameter as kondisi', DB::raw('COUNT(penilaian.kondisi_jalan_id) as total'))
            ->groupBy('penilaian.kondisi_jalan_id', 'parameter.parameter')
            ->get();

        return response()->json($data); // Kembalikan data dalam format JSON
    }
}
