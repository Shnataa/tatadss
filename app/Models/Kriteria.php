<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    //
    
    use HasFactory;
    protected $table = 'kriteria';
    protected $fillable = ['nama_kriteria', 'bobot', 'tipe_kriteria'];

    public function parameter()
    {
        return $this->hasMany(Parameter::class);
    }
    
}
