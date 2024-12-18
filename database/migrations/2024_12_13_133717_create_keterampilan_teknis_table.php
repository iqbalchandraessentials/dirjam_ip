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
            $table->unsignedBigInteger('uraian_master_jabatan_id');
            $table->string('kode');
            $table->enum('kategori',['CORE','ENABLER']);
            $table->integer('level');
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
