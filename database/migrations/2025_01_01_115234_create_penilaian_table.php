<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode')->onDelete('cascade');
            $table->foreignId('alternatif_id')->constrained('alternatif')->onDelete('cascade');
            $table->foreignId('panjang_ruas_jalan_id')->constrained('parameter')->onDelete('cascade');
            $table->foreignId('lebar_ruas_jalan_id')->constrained('parameter')->onDelete('cascade');
            $table->foreignId('jenis_permukaan_jalan_id')->constrained('parameter')->onDelete('cascade');
            $table->foreignId('kondisi_jalan_id')->constrained('parameter')->onDelete('cascade');
            $table->foreignId('mobilitas_jalan_id')->constrained('parameter')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
