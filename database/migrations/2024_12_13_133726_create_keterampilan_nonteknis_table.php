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
        Schema::create('keterampilan_non_teknis', function (Blueprint $table) {
            $table->id();
            $table->string('master_jabatan');
            $table->string('kode');
            $table->enum('kategori',['FUNGSI','PERAN', 'UTAMA']);
            $table->string('jenis')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterampilan_non_teknis');
    }
};
