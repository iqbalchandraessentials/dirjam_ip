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
        Schema::create('hubungan_kerjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uraian_master_jabatan_id')->nullable();
            $table->enum('jenis_jabatan',['fungsional','struktural'])->nullable();
            $table->string('komunikasi');
            $table->string('tujuan');
            $table->enum('jenis',['internal','eksternal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hubungan_kerjas');
    }
};
