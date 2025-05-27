<?php

namespace App\Exports;

use App\Models\Perhitungan;
use Maatwebsite\Excel\Concerns\FromCollection;

class HasilAkhirExport implements FromCollection
{
    protected $periodeId;

    public function __construct($periodeId)
    {
        $this->periodeId = $periodeId;
    }

    public function collection()
    {
        return Perhitungan::where('periode_id', $this->periodeId)
            ->orderByDesc('skor')
            ->get(['alternatif_id', 'skor']);
    }
}
