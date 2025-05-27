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
        Schema::create('parameter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kriteria_id');  // Foreign key untuk kriteria
            $table->string('parameter');                 // Kolom parameter
            $table->decimal('nilai', 8, 2);              // Kolom nilai
            $table->timestamps();

            // Mendefinisikan foreign key
            $table->foreign('kriteria_id')->references('id')->on('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter');
    }
};
