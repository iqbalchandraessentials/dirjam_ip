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
        Schema::create('keterampilan_teknis', function (Blueprint $table) {
            $table->id();
            $table->string('master_jabatan');
            $table->string('kode');
            $table->enum('kategori',['CORE','ENABLER']);
            $table->integer('level');
            $table->string('master_detail_kompetensi_id');
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterampilan_teknis');
    }
};
