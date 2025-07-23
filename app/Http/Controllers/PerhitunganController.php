<?php

namespace App\Http\Controllers;

use App\Models\Perhitungan;
use App\Models\Penilaian;
use App\Models\Alternatif;
use App\Models\Periode;
use App\Models\Kriteria;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PerhitunganController extends Controller
{
    public function index()
    {
        // Ambil semua data periode yang tersedia
        $periodes = Periode::where('flag', true)->get();

        // Kirim data periode ke view
        return view('perhitungan.index', compact('periodes'));
    }

    public function hitungSmart(Request $request)
    {
        // Ambil periode_id dari query string
        $periodeId = $request->get('periode_id');
    
        // Validasi periode_id
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
        ]);
    
        // Ambil semua data penilaian untuk periode tertentu
        $penilaians = Penilaian::where('periode_id', $periodeId)->get();
    
        // Kriteria yang digunakan dalam perhitungan SMART (menggunakan kriteria baru)
        $kriteria = [
            'panjang_ruas_jalan_id',
            'lebar_ruas_jalan_id',
            'jenis_permukaan_jalan_id',
            'kondisi_jalan_id',
            'mobilitas_jalan_id',
        ];
    
        // Ambil bobot dari tabel kriteria
        $bobot = [];
        foreach ($kriteria as $kriteriaKey) {
            // Ambil nama kriteria berdasarkan kriteriaKey
            $kriteriaNama = $this->getKriteriaName($kriteriaKey);
    
            // Cari bobot berdasarkan kriteriaNama
            $kriteriaData = Kriteria::where('nama_kriteria', $kriteriaNama)->first();
    
            // Jika data ditemukan, ambil bobotnya, jika tidak, set bobot default 0
            if ($kriteriaData) {
                $bobot[$kriteriaNama] = $kriteriaData->bobot;
            } else {
                $bobot[$kriteriaNama] = 0;  // Set default jika tidak ditemukan
            }
        }
    
        // Mengelompokkan data penilaian berdasarkan alternatif_id
        $alternatifs = $penilaians->groupBy('alternatif_id');
        $matriksKeputusan = [];
        $skorSmart = [];
        $skorDetails = [];
    
        // Ambil data alternatif yang terkait dengan periode ini
        $alternatifIds = $alternatifs->keys(); // Ambil ID alternatif yang terlibat
        $alternatifsData = Alternatif::whereIn('id', $alternatifIds)->pluck('nama', 'id'); // Mengambil nama alternatif berdasarkan ID
    
        // Membuat matriks keputusan dan menghitung skor untuk tiap alternatif
        foreach ($alternatifs as $alternatifId => $penilaianAlternatif) {
            $penilaianData = [];
            $totalSkor = 0;
            $detailSkor = [];
    
            foreach ($kriteria as $kriteriaKey) {
                // Mengambil nilai dari relasi model Penilaian berdasarkan kriteria
                $penilaian = $penilaianAlternatif->first(); // Ambil penilaian pertama untuk alternatif ini
                $parameter = null;
    
                // Cek relasi berdasarkan kriteria
                if ($kriteriaKey === 'panjang_ruas_jalan_id') {
                    $parameter = $penilaian->panjangRuasJalan;
                } elseif ($kriteriaKey === 'lebar_ruas_jalan_id') {
                    $parameter = $penilaian->lebarRuasJalan;
                } elseif ($kriteriaKey === 'jenis_permukaan_jalan_id') {
                    $parameter = $penilaian->jenisPermukaanJalan;
                } elseif ($kriteriaKey === 'kondisi_jalan_id') {
                    $parameter = $penilaian->kondisiJalan;
                } elseif ($kriteriaKey === 'mobilitas_jalan_id') {
                    $parameter = $penilaian->mobilitasJalan;
                }
    
                // Jika parameter ditemukan, hitung utility dan skor
                if ($parameter) {
                    // Normalisasi nilai berdasarkan kriteria
                    $utility = $this->normalizeValue($parameter->nilai, $this->getKriteriaName($kriteriaKey));
                    $penilaianData[] = $utility;
    
                    // Kalikan nilai utility dengan bobot kriteria dan tambahkan ke total skor
                    $skorPerKriteria = $utility * $bobot[$this->getKriteriaName($kriteriaKey)];
                    $totalSkor += $skorPerKriteria;
    
                    $detailSkor[] = "{$utility} * {$bobot[$this->getKriteriaName($kriteriaKey)]} = " . number_format($skorPerKriteria, 2);
                } else {
                    $penilaianData[] = 0; // Jika tidak ada data, berikan nilai default 0
                }
            }
    
            // Menyimpan hasil perhitungan ke dalam tabel 'perhitungans'
            Perhitungan::create([
                'periode_id' => $periodeId,
                'alternatif_id' => $alternatifId,
                'skor' => $totalSkor,
                'detail_skor' => implode(', ', $detailSkor),
            ]);
    
            $matriksKeputusan[$alternatifId] = $penilaianData;
            $skorSmart[$alternatifId] = $totalSkor;  // Menyimpan skor total untuk setiap alternatif
            $skorDetails[$alternatifId] = $detailSkor; // Menyimpan detail perhitungan skor
        }
    
        // Mengurutkan alternatif berdasarkan skor SMART (skor tertinggi ke terendah)
        arsort($skorSmart);
        // Tambahkan pagination ke skorSmart
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $items = array_slice($skorSmart, ($currentPage - 1) * $perPage, $perPage, true);

        $paginatedSkorSmart = new LengthAwarePaginator(
            $items,
            count($skorSmart),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        $dataAsli = [];
        $paginatedAlternatifIds = array_keys($items);

        // Filter ulang data berdasarkan alternatif yang muncul di halaman ini
        $dataAsli = array_filter($dataAsli, function ($key) use ($paginatedAlternatifIds) {
            return in_array($key, $paginatedAlternatifIds);
        }, ARRAY_FILTER_USE_KEY);

        $matriksKeputusan = array_filter($matriksKeputusan, function ($key) use ($paginatedAlternatifIds) {
            return in_array($key, $paginatedAlternatifIds);
        }, ARRAY_FILTER_USE_KEY);

        $skorDetails = array_filter($skorDetails, function ($key) use ($paginatedAlternatifIds) {
            return in_array($key, $paginatedAlternatifIds);
        }, ARRAY_FILTER_USE_KEY);

        // Ambil hanya alternatif yang ada di halaman ini
foreach ($alternatifs as $alternatifId => $penilaianAlternatif) {
    if (!in_array($alternatifId, $paginatedAlternatifIds)) {
        continue; // lewati jika bukan bagian dari halaman sekarang
    }

    foreach ($kriteria as $kriteriaKey) {
        $penilaian = $penilaianAlternatif->first(); // Ambil penilaian pertama untuk alternatif ini
        $parameter = null;

        if ($kriteriaKey === 'panjang_ruas_jalan_id') {
            $parameter = $penilaian->panjangRuasJalan;
        } elseif ($kriteriaKey === 'lebar_ruas_jalan_id') {
            $parameter = $penilaian->lebarRuasJalan;
        } elseif ($kriteriaKey === 'jenis_permukaan_jalan_id') {
            $parameter = $penilaian->jenisPermukaanJalan;
        } elseif ($kriteriaKey === 'kondisi_jalan_id') {
            $parameter = $penilaian->kondisiJalan;
        } elseif ($kriteriaKey === 'mobilitas_jalan_id') {
            $parameter = $penilaian->mobilitasJalan;
        }

        if ($parameter) {
            $dataAsli[$alternatifId][$this->getKriteriaName($kriteriaKey)] = $parameter->nilai;
        } else {
            $dataAsli[$alternatifId][$this->getKriteriaName($kriteriaKey)] = 0;
        }
    }
}

    
        return view('perhitungan.hasil', compact('matriksKeputusan','paginatedSkorSmart', 'skorSmart', 'kriteria', 'periodeId', 'skorDetails', 'alternatifsData', 'dataAsli'));
    }
    

    /**
     * Fungsi untuk normalisasi nilai
     * Ini adalah contoh sederhana untuk normalisasi nilai menjadi skala 0-1.
     */
    private function normalizeValue($nilai, $kriteriaNama)
    {
        // Setiap kriteria memiliki rentang nilai yang berbeda
        $maxValues = [
            'Panjang Ruas Jalan' => 5,  // Nilai tertinggi untuk Panjang Ruas Jalan
            'Lebar Ruas Jalan' => 5,
            'Jenis Permukaan Jalan' => 5,
            'Kondisi Jalan' => 5,
            'Mobilitas Jalan' => 5,
        ];

        // Ambil nilai maksimal berdasarkan kriteria
        $maxValue = $maxValues[$kriteriaNama] ?? 1;
        
        // Normalisasi nilai menjadi skala 0-1
        return min(1, $nilai / $maxValue);  // Jika nilai lebih besar dari max, batasi ke 1
    }

    private function getKriteriaName($kriteriaKey)
    {
        $kriteriaMapping = [
            'panjang_ruas_jalan_id' => 'Panjang Ruas Jalan',
            'lebar_ruas_jalan_id' => 'Lebar Ruas Jalan',
            'jenis_permukaan_jalan_id' => 'Jenis Permukaan Jalan',
            'kondisi_jalan_id' => 'Kondisi Jalan',
            'mobilitas_jalan_id' => 'Mobilitas Jalan',
        ];

        return $kriteriaMapping[$kriteriaKey] ?? ''; // Kembalikan kriteria yang sesuai atau string kosong jika tidak ada
    }
}