<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        // Menampilkan semua periode
        $periodes = Periode::all();
        return view('periode.index', compact('periodes'));
    }
    
    public function create()
    {
        return view('periode.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Menonaktifkan periode aktif sebelumnya
        Periode::where('flag', true)->update(['flag' => false]);

        // Menyimpan periode baru sebagai aktif
        Periode::create([
            'nama' => $request->nama,
            'flag' => true, // Membuat periode baru aktif
        ]);

        return redirect()->route('periode.index')->with('success', 'Periode berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Mencari periode berdasarkan ID
        $periode = Periode::findOrFail($id);

        // Pastikan periode tersebut aktif
        if (!$periode->flag) {
            return redirect()->route('periode.index')->with('error', 'Periode tidak dapat diedit karena tidak aktif');
        }

        return view('periode.edit', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Mencari periode berdasarkan ID
        $periode = Periode::findOrFail($id);

        // Pastikan periode tersebut aktif
        if (!$periode->flag) {
            return redirect()->route('periode.index')->with('error', 'Periode tidak dapat diperbarui karena tidak aktif');
        }

        // Update nama periode
        $periode->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('periode.index')->with('success', 'Periode berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Mencari periode berdasarkan ID
        $periode = Periode::findOrFail($id);

        // Cek apakah periode aktif
        if ($periode->flag) {
            // Hapus periode jika aktif
            $periode->delete();
            return redirect()->route('periode.index')->with('success', 'Periode berhasil dihapus');
        } else {
            // Jika periode tidak aktif
            return redirect()->route('periode.index')->with('error', 'Periode tidak bisa dihapus karena tidak aktif');
        }
    }

    public function activate($id)
{
    // Menonaktifkan semua periode lain
    Periode::where('flag', true)->update(['flag' => false]);

    // Mengaktifkan periode yang dipilih
    $periode = Periode::findOrFail($id);
    $periode->update(['flag' => true]);

    return redirect()->route('periode.index')->with('success', 'Periode berhasil diaktifkan.');
}

public function deactivate($id)
{
    // Menonaktifkan periode yang dipilih
    $periode = Periode::findOrFail($id);

    if ($periode->flag) {
        $periode->update(['flag' => false]);
        return redirect()->route('periode.index')->with('success', 'Periode berhasil dinonaktifkan.');
    }

    return redirect()->route('periode.index')->with('error', 'Periode sudah dalam keadaan tidak aktif.');
}

}
