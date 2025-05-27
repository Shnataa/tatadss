<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    //
    use HasFactory;
    protected $table = 'parameter';
    protected $fillable = ['kriteria_id', 'parameter', 'nilai'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
        // Relasi ke Penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

}
