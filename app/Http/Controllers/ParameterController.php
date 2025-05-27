<?php
namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    // Menampilkan semua parameter
    public function index()
    {
        $parameters = Parameter::with('kriteria')->get()->groupBy('kriteria_id');
        $kriterias = Kriteria::all(); // Ambil data kriteria untuk header tabel
        return view('parameter.index', compact('parameters', 'kriterias'));
    }

    // Menampilkan form untuk menambah parameter baru
    public function create()
    {
        // Ambil semua kriteria dari database
        $kriterias = Kriteria::all();

        // Kirim data kriteria ke view
        return view('parameter.create', compact('kriterias'));
    }

    // Menyimpan parameter baru
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id', // Validasi kriteria_id harus ada di tabel kriteria
            'parameter' => 'required|string|max:255', // Validasi parameter
            'nilai' => 'required|numeric', // Validasi nilai
        ]);

        // Simpan parameter baru
        Parameter::create([
            'kriteria_id' => $request->kriteria_id, // Pastikan sesuai dengan nama field input
            'parameter' => $request->parameter,
            'nilai' => $request->nilai,
        ]);

        // Redirect setelah menyimpan
        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Cari parameter berdasarkan ID
        $parameter = Parameter::findOrFail($id);

        // Ambil data kriteria untuk dropdown
        $kriterias = Kriteria::all();

        // Tampilkan view dengan data parameter dan kriteria
        return view('parameter.edit', compact('parameter', 'kriterias'));
    }

    // Method untuk memperbarui data parameter
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id', // Pastikan kriteria yang dipilih ada di tabel kriteria
            'parameter' => 'required|string',
            'nilai' => 'required|numeric',
        ]);

        // Cari parameter berdasarkan ID
        $parameter = Parameter::findOrFail($id);

        // Update data parameter
        $parameter->update([
            'kriteria_id' => $request->kriteria_id,
            'parameter' => $request->parameter,
            'nilai' => $request->nilai,
        ]);

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil diperbarui');
    }

    // Menghapus parameter berdasarkan ID
    public function destroy($id)
    {
        // Mencari parameter berdasarkan ID dan menghapusnya
        $parameter = Parameter::findOrFail($id);
        $parameter->delete();

        // Redirect setelah menghapus
        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil dihapus!');
    }

    
}
