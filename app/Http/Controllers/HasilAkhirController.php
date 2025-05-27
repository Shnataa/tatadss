<?php

namespace App\Http\Controllers;

use App\Models\Perhitungan;
use App\Models\Periode;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HasilAkhirExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HasilAkhirController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua periode yang tersedia
        $periodes = Periode::all();
    
        // Jika ada periode yang dipilih, ambil semua hasil perhitungan untuk periode tersebut
        if ($request->has('periode_id')) {
            $periodeId = $request->periode_id;
    
            // Ambil semua hasil perhitungan berdasarkan periode_id, dan urutkan berdasarkan skor
            $hasilTertinggi = Perhitungan::with('alternatif')
            ->where('periode_id', $periodeId)
            ->selectRaw('alternatif_id, periode_id, MAX(skor) as skor') // Gunakan MAX untuk mendapatkan skor tertinggi
            ->groupBy('alternatif_id', 'periode_id') // Kelompokkan berdasarkan alternatif_id dan periode_id
            ->orderByDesc('skor') // Urutkan berdasarkan skor tertinggi
            ->get();
        
            // Ambil nama periode yang dipilih
            $periodeNama = Periode::find($periodeId)->nama;
    
            // Kirim data periode dan hasil perhitungan ke view
            return view('hasilAkhir.index', compact('hasilTertinggi', 'periodes', 'periodeId', 'periodeNama'));
        }
    
        // Jika periode belum dipilih, hanya tampilkan daftar periode
        return view('hasilAkhir.index', compact('periodes'));
    }
    

    public function exportPdf($periodeId)
    {
        // Ambil periode berdasarkan ID yang dipilih
        $periode = Periode::find($periodeId);
    
        // Jika periode tidak ditemukan, beri respons error
        if (!$periode) {
            return redirect()->back()->with('error', 'Periode tidak ditemukan.');
        }
    
        // Ambil hasil perhitungan dengan skor tertinggi
        $hasilTertinggi = Perhitungan::with('alternatif')
        ->where('periode_id', $periodeId)
        ->selectRaw('alternatif_id, periode_id, MAX(skor) as skor') // Gunakan MAX untuk mendapatkan skor tertinggi
        ->groupBy('alternatif_id', 'periode_id') // Kelompokkan berdasarkan alternatif_id dan periode_id
        ->orderByDesc('skor') // Urutkan berdasarkan skor tertinggi
        ->get();
    
        // Jika hasil perhitungan tidak ditemukan
        if (!$hasilTertinggi) {
            return redirect()->back()->with('error', 'Hasil perhitungan tidak ditemukan.');
        }
    
    
        // Generate PDF menggunakan view 'hasilAkhir.pdf'
        $pdf = Pdf::loadView('hasilAkhir.pdf', compact('hasilTertinggi', 'periode'));
    
        // Mengunduh file PDF
        return $pdf->download('hasil_akhir_perhitungan.pdf');
    }
    
}
