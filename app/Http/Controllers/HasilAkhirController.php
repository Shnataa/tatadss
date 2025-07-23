<?php

namespace App\Http\Controllers;

use App\Models\Perhitungan;
use App\Models\Periode;
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

            // Ambil semua hasil perhitungan berdasarkan periode_id, dan urutkan berdasarkan skor terendah
            $hasilTerendah = Perhitungan::with('alternatif')
                ->where('periode_id', $periodeId)
                ->selectRaw('alternatif_id, periode_id, MIN(skor) as skor')
                ->groupBy('alternatif_id', 'periode_id')
                ->orderBy('skor') // skor terendah menjadi ranking 1
                ->paginate(10);

            // Ambil nama periode yang dipilih
            $periodeNama = Periode::find($periodeId)->nama;

            // Kirim data ke view
            return view('hasilAkhir.index', compact('hasilTerendah', 'periodes', 'periodeId', 'periodeNama'));
        }

        // Jika belum dipilih
        return view('hasilAkhir.index', compact('periodes'));
    }

    public function exportPdf($periodeId)
    {
        // Ambil periode
        $periode = Periode::find($periodeId);

        if (!$periode) {
            return redirect()->back()->with('error', 'Periode tidak ditemukan.');
        }

        // Ambil hasil skor terendah
        $hasilTerendah = Perhitungan::with('alternatif')
            ->where('periode_id', $periodeId)
            ->selectRaw('alternatif_id, periode_id, MIN(skor) as skor')
            ->groupBy('alternatif_id', 'periode_id')
            ->orderBy('skor')
            ->get();

        if (!$hasilTerendah) {
            return redirect()->back()->with('error', 'Hasil perhitungan tidak ditemukan.');
        }

        $pdf = Pdf::loadView('hasilAkhir.pdf', compact('hasilTerendah', 'periode'));

        return $pdf->download('hasil_akhir_perhitungan.pdf');
    }
}
