<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    // Menampilkan daftar alternatif
    public function index()
    {
        $alternatifs = Alternatif::orderBy('nama', 'asc')->get(); // Urutkan berdasarkan nama (A-Z)
        return view('alternatif.index', compact('alternatifs'));
    }

    // Menyimpan alternatif baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Alternatif::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil ditambahkan!');
    }

    // Menampilkan form untuk menambah alternatif
    public function create()
    {
        return view('alternatif.create');
    }

    // Menampilkan form untuk mengedit alternatif
    public function edit($id)
    {
        $alternatif = Alternatif::findOrFail($id);
        return view('alternatif.edit', compact('alternatif'));
    }

    // Update alternatif yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $alternatif = Alternatif::findOrFail($id);
        $alternatif->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil diperbarui!');
    }

    // Menghapus alternatif
    public function destroy($id)
    {
        $alternatif = Alternatif::findOrFail($id);
        $alternatif->delete();

        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil dihapus!');
    }
}
