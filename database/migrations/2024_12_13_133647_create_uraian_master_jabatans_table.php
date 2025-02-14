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
        Schema::create('uraian_master_jabatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_jabatan_id');
            $table->string('nama');
            $table->integer('unit_id');
            $table->string('fungsi_utama',4000);
            $table->string('anggaran')->nullable();
            $table->string('accountability')->nullable();
            $table->string('nature_impact')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uraian_master_jabatans');
    }
};
