<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    //
    protected $table = 'alternatif';
    protected $fillable = ['nama'];
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
    public function periode()
{
    return $this->belongsTo(Periode::class);
}

public function alternatif()
{
    return $this->belongsTo(Alternatif::class);
}


}
