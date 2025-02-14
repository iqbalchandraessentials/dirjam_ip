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
        Schema::create('keterampilan_nonteknis', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->enum('kategori',['UTAMA','PERAN','FUNGSI']);
            $table->string('jenis')->nullable();
            $table->string('created_by')->nullable();
            $table->string('master_jabatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterampilan_nonteknis');
    }
};
