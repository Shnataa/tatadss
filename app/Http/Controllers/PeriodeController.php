<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::all();
        return view('periode.index', compact('periodes'));
    }

    public function create()
    {
        return view('periode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Cek apakah nama periode sudah ada
        if (Periode::where('nama', $request->nama)->exists()) {
            return redirect()->route('periode.index')->with('error', 'Periode dengan tahun tersebut sudah ada dan tidak bisa ditambahkan lagi.');
        }

        // Nonaktifkan semua periode aktif sebelumnya
        Periode::where('flag', true)->update(['flag' => false]);

        // Simpan periode baru sebagai aktif
        Periode::create([
            'nama' => $request->nama,
            'flag' => true,
        ]);

        return redirect()->route('periode.index')->with('success', 'Periode berhasil ditambahkan');
    }

    public function edit($id)
    {
        $periode = Periode::findOrFail($id);

        if (!$periode->flag) {
            return redirect()->route('periode.index')->with('error', 'Periode tidak dapat diedit karena tidak aktif');
        }

        return view('periode.edit', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $periode = Periode::findOrFail($id);

        if (!$periode->flag) {
            return redirect()->route('periode.index')->with('error', 'Periode tidak dapat diperbarui karena tidak aktif');
        }

        // Cek jika nama baru sudah digunakan 
        if (Periode::where('nama', $request->nama)->where('id', '!=', $id)->exists()) {
            return redirect()->route('periode.index')->with('error', 'Nama periode sudah digunakan oleh periode lain.');
        }

        $periode->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('periode.index')->with('success', 'Periode berhasil diperbarui');
    }

    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);

        if ($periode->flag) {
            $periode->delete();
            return redirect()->route('periode.index')->with('success', 'Periode berhasil dihapus');
        } else {
            return redirect()->route('periode.index')->with('error', 'Periode tidak bisa dihapus karena tidak aktif');
        }
    }

    public function activate($id)
    {
        Periode::where('flag', true)->update(['flag' => false]);

        $periode = Periode::findOrFail($id);
        $periode->update(['flag' => true]);

        return redirect()->route('periode.index')->with('success', 'Periode berhasil diaktifkan.');
    }

    public function deactivate($id)
    {
        $periode = Periode::findOrFail($id);

        if ($periode->flag) {
            $periode->update(['flag' => false]);
            return redirect()->route('periode.index')->with('success', 'Periode berhasil dinonaktifkan.');
        }

        return redirect()->route('periode.index')->with('error', 'Periode sudah dalam keadaan tidak aktif.');
    }
}
