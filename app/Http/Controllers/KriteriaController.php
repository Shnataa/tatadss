<?php
namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Parameter;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        $totalKriteria = Kriteria::count(); // Hitung jumlah kriteria
        return view('kriteria.index', compact('kriterias', 'totalKriteria'));
    }

    // Menampilkan form untuk menambah kriteria baru
    public function create()
    {
        // Tentukan batas maksimum data
        $maxKriteria = 5;
    
        // Hitung jumlah data kriteria yang sudah ada
        $currentCount = \App\Models\Kriteria::count();
    
        // Jika jumlah data mencapai batas, kembalikan dengan notifikasi
        if ($currentCount >= $maxKriteria) {
            return redirect()->route('kriteria.index')->with('error', 'Tidak dapat menambah data baru karena sudah mencapai batas maksimal.');
        }
    
        // Jika belum mencapai batas, tampilkan formulir
        return view('kriteria.create');
    }
    

    // Menyimpan kriteria baru
    public function store(Request $request)
    {
        // Cek apakah jumlah kriteria sudah mencapai 6
        if (Kriteria::count() >= 6) {
            return redirect()->route('kriteria.index')->with('error', 'Jumlah kriteria sudah mencapai batas maksimal!');
        }
    
        // Validasi input
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1', // Pastikan bobot antara 0 dan 1
            'tipe_kriteria' => 'required|in:Cost,Benefit', // Validasi tipe_kriteria
        ]);
    
        // Menyimpan kriteria baru
        Kriteria::create([
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot,  // Menyimpan bobot
            'tipe_kriteria' => $request->tipe_kriteria, // Menyimpan tipe_kriteria
        ]);
    
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    // Memperbarui kriteria yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',  // Validasi bobot saat update
            'tipe_kriteria' => 'required|in:Cost,Benefit', // Validasi tipe_kriteria saat update
        ]);

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot,  // Memperbarui bobot
            'tipe_kriteria' => $request->tipe_kriteria, // Memperbarui tipe_kriteria
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui');
    }

    // Menghapus kriteria
    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        // Cek apakah kriteria sudah digunakan di tabel parameter
        $usedInParameter = Parameter::where('kriteria_id', $kriteria->id)->exists();

        if ($usedInParameter) {
            // Jika sudah digunakan, beri pesan error
            return redirect()->route('kriteria.index')->with('error', 'Kriteria tidak dapat dihapus karena sudah digunakan di parameter.');
        }

        // Jika belum digunakan, hapus kriteria
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus');
    }
    
}
