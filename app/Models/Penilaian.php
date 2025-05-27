<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan
    protected $table = 'penilaian';

    // Kolom yang dapat diisi
    protected $fillable = [
        'periode_id',
        'alternatif_id',
        'panjang_ruas_jalan_id',
        'lebar_ruas_jalan_id',
        'jenis_permukaan_jalan_id',
        'kondisi_jalan_id',
        'mobilitas_jalan_id',
    ];

    /**
     * Relasi ke model Periode
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    /**
     * Relasi ke model Alternatif
     */
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }

    /**
     * Relasi ke model Parameter untuk panjang_ruas_jalan
     */
    public function panjangRuasJalan()
    {
        return $this->belongsTo(Parameter::class, 'panjang_ruas_jalan_id');
    }

    /**
     * Relasi ke model Parameter untuk lebar_ruas_jalan
     */
    public function lebarRuasJalan()
    {
        return $this->belongsTo(Parameter::class, 'lebar_ruas_jalan_id');
    }

    /**
     * Relasi ke model Parameter untuk jenis_permukaan_jalan
     */
    public function jenisPermukaanJalan()
    {
        return $this->belongsTo(Parameter::class, 'jenis_permukaan_jalan_id');
    }

    /**
     * Relasi ke model Parameter untuk kondisi_jalan
     */
    public function kondisiJalan()
    {
        return $this->belongsTo(Parameter::class, 'kondisi_jalan_id');
    }

    /**
     * Relasi ke model Parameter untuk mobilitas_jalan
     */
    public function mobilitasJalan()
    {
        return $this->belongsTo(Parameter::class, 'mobilitas_jalan_id');
    }

    
}
