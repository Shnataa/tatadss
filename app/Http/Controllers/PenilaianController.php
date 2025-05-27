<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Parameter;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Menampilkan daftar penilaian
     */
    public function index(Request $request)
{
    // Ambil periode_id dari query string (parameter URL)
    $periodeId = $request->get('periode_id');  // Pastikan $request ada di sini
    
    // Validasi periode_id jika ada
    $request->validate([
        'periode_id' => 'nullable|exists:periode,id',
    ]);
    
    // Jika periode_id dipilih, ambil data penilaian berdasarkan periode
    if ($periodeId) {
        // Ambil semua penilaian berdasarkan periode tertentu
        $penilaians = Penilaian::with([
            'periode', 'alternatif', 'panjangRuasJalan', 'lebarRuasJalan', 
            'jenisPermukaanJalan', 'kondisiJalan', 'mobilitasJalan'
        ])->where('periode_id', $periodeId)->paginate();
    } 
    else {
        // Jika tidak ada periode_id, tampilkan semua penilaian dan urutkan berdasarkan periode_id
        $penilaians = Penilaian::with([
            'periode', 'alternatif', 'panjangRuasJalan', 'lebarRuasJalan', 
            'jenisPermukaanJalan', 'kondisiJalan', 'mobilitasJalan'
        ])
        ->orderBy('periode_id') // Mengurutkan berdasarkan periode_id
        ->paginate(10);
    }
    // Ambil semua periode yang tersedia untuk dropdown filter
    $periodes = Periode::all();

    // Kirim data penilaian dan periode ke view
    return view('penilaian.index', compact('penilaians', 'periodes', 'periodeId'));
}

    

    /**
     * Menampilkan form untuk menambahkan penilaian baru
     */
    public function create()
{
    // Ambil periode aktif
    $currentPeriode = Periode::where('flag', true)->first();

    // Jika tidak ada periode aktif, redirect ke halaman yang sesuai dengan pesan
    if (!$currentPeriode) {
        return redirect()->route('periode.index')->with('error', 'Tidak ada periode aktif. Harap aktifkan periode terlebih dahulu.');
    }

    // Ambil periode lainnya dan data yang diperlukan untuk form
    $periodes = Periode::where('flag', true)->get();
    $usedAlternatifs = Penilaian::where('periode_id', $currentPeriode->id)
                                ->pluck('alternatif_id')
                                ->toArray();
    $alternatifs = Alternatif::whereNotIn('id', $usedAlternatifs)->get();
    $kriterias = Kriteria::with('parameter')->get();

    return view('penilaian.create', compact('periodes', 'alternatifs', 'kriterias', 'usedAlternatifs'));
}

    
    

    /**
     * Menyimpan penilaian baru
     */
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'alternatif_id' => 'required|exists:alternatif,id',
            'panjang_ruas_jalan_id' => 'required|exists:parameter,id',
            'lebar_ruas_jalan_id' => 'required|exists:parameter,id',
            'jenis_permukaan_jalan_id' => 'required|exists:parameter,id',
            'kondisi_jalan_id' => 'required|exists:parameter,id',
            'mobilitas_jalan_id' => 'required|exists:parameter,id',
        ]);

        // Menyimpan data penilaian
        Penilaian::create([
            'periode_id' => $request->periode_id,
            'alternatif_id' => $request->alternatif_id,
            'panjang_ruas_jalan_id' => $request->panjang_ruas_jalan_id,
            'lebar_ruas_jalan_id' => $request->lebar_ruas_jalan_id,
            'jenis_permukaan_jalan_id' => $request->jenis_permukaan_jalan_id,
            'kondisi_jalan_id' => $request->kondisi_jalan_id,
            'mobilitas_jalan_id' => $request->mobilitas_jalan_id,
        ]);

        // Redirect ke halaman penilaian index setelah berhasil menyimpan data
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil ditambahkan');
    }

    /**
     * Menampilkan form untuk mengedit penilaian yang sudah ada
     */
    public function edit(Penilaian $penilaian)
    {
        // Ambil data periode, alternatif, dan kriteria
        $periodes = Periode::all();
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::with('parameter')->get();

        return view('penilaian.edit', compact('penilaian', 'periodes', 'alternatifs', 'kriterias'));
    }

    /**
     * Memperbarui data penilaian yang sudah ada
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        // Validasi input form
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'alternatif_id' => 'required|exists:alternatif,id',
            'panjang_ruas_jalan_id' => 'required|exists:parameter,id',
            'lebar_ruas_jalan_id' => 'required|exists:parameter,id',
            'jenis_permukaan_jalan_id' => 'required|exists:parameter,id',
            'kondisi_jalan_id' => 'required|exists:parameter,id',
            'mobilitas_jalan_id' => 'required|exists:parameter,id',
        ]);

        // Update data penilaian
        $penilaian->update([
            'periode_id' => $request->periode_id,
            'alternatif_id' => $request->alternatif_id,
            'panjang_ruas_jalan_id' => $request->panjang_ruas_jalan_id,
            'lebar_ruas_jalan_id' => $request->lebar_ruas_jalan_id,
            'jenis_permukaan_jalan_id' => $request->jenis_permukaan_jalan_id,
            'kondisi_jalan_id' => $request->kondisi_jalan_id,
            'mobilitas_jalan_id' => $request->mobilitas_jalan_id,
        ]);

        // Redirect ke halaman penilaian index setelah berhasil update
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui');
    }

    /**
     * Menghapus penilaian yang sudah ada
     */
    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil dihapus');
    }
}
