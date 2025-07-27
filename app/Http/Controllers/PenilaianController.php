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
        $periodeId = $request->get('periode_id');

        // Ambil periode aktif (default)
        $currentPeriode = Periode::where('flag', true)->first();

        // Validasi periode_id
        $request->validate([
            'periode_id' => 'nullable|exists:periode,id',
        ]);

        // Jika tidak ada query string, pakai periode aktif
        if (!$periodeId && $currentPeriode) {
            $periodeId = $currentPeriode->id;
        }

        // Query penilaian berdasarkan periode yang dipilih
        $penilaians = Penilaian::with([
            'periode', 'alternatif', 'panjangRuasJalan', 'lebarRuasJalan',
            'jenisPermukaanJalan', 'kondisiJalan', 'mobilitasJalan'
        ])
        ->where('periode_id', $periodeId)
        ->orderBy('alternatif_id')
        ->paginate(10);

        $periodes = Periode::all();

        return view('penilaian.index', compact('penilaians', 'periodes', 'periodeId'));
    }


    

    /**
     * Menampilkan form untuk menambahkan penilaian baru
     */
    public function create()
    {
        $periode = Periode::where('flag', true)->first();

        if (!$periode) {
            return redirect()->route('periode.index')->with('error', 'Tidak ada periode aktif.');
        }

        $usedAlternatifs = Penilaian::where('periode_id', $periode->id)
            ->pluck('alternatif_id')
            ->toArray();

        $alternatifs = Alternatif::whereNotIn('id', $usedAlternatifs)->get();
        $kriterias = Kriteria::with('parameter')->get();

        return view('penilaian.create', compact('periode', 'alternatifs', 'kriterias', 'usedAlternatifs'));
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

    // Tampilkan form checklist alternatif
    public function pilihAlternatifBatch()
    {
        $currentPeriode = Periode::where('flag', true)->first();

        if (!$currentPeriode) {
            return redirect()->route('periode.index')->with('error', 'Tidak ada periode aktif.');
        }

        $usedAlternatifs = Penilaian::where('periode_id', $currentPeriode->id)->pluck('alternatif_id')->toArray();
        $alternatifs = Alternatif::all();

        return view('penilaian.pilih_batch', compact('alternatifs', 'usedAlternatifs'));
    }

    // Tampilkan form penilaian batch
    public function createFormBatch(Request $request)
    {
        $request->validate([
            'alternatif_ids' => 'required|array|min:1'
        ]);

        $periode = Periode::where('flag', true)->first();
        $kriterias = Kriteria::with('parameter')->get();
        $alternatifs_terpilih = Alternatif::whereIn('id', $request->alternatif_ids)->get();

        return view('penilaian.form_batch', compact('periode', 'alternatifs_terpilih', 'kriterias'));
    }

    public function storeBatch(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'penilaian' => 'required|array'
        ]);

        foreach ($request->penilaian as $data) {
            Penilaian::create([
                'periode_id' => $request->periode_id,
                'alternatif_id' => $data['alternatif_id'],
                'panjang_ruas_jalan_id' => $data['panjang_ruas_jalan_id'],
                'lebar_ruas_jalan_id' => $data['lebar_ruas_jalan_id'],
                'jenis_permukaan_jalan_id' => $data['jenis_permukaan_jalan_id'],
                'kondisi_jalan_id' => $data['kondisi_jalan_id'],
                'mobilitas_jalan_id' => $data['mobilitas_jalan_id'],
            ]);
        }

        return redirect()->route('penilaian.index')->with('success', 'Semua penilaian berhasil disimpan!');
    }


}