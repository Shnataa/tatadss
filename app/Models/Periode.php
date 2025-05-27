<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    //
    use HasFactory;
    protected $table = 'periode';
    protected $fillable = ['nama', 'flag'];
    
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

        public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAktif($query)
    {
        $query->whereDate('start_date', '<=', now())
              ->whereDate('end_date', '>=', now());
    }
    public function up()
{
    Schema::table('periodes', function (Blueprint $table) {
        $table->boolean('is_active')->default(false);
    });
}

public function down()
{
    Schema::table('periodes', function (Blueprint $table) {
        $table->dropColumn('is_active');
    });
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
