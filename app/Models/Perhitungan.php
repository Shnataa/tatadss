<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perhitungan extends Model
{
    //
    use HasFactory;
    protected $table = 'perhitungan';
    protected $fillable = [
        'periode_id', 'alternatif_id', 'skor', 'rangking'
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}
