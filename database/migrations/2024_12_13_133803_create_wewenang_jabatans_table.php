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
        Schema::create('wewenang_jabatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uraian_master_jabatan_id')->nullable();
            $table->enum('jenis_jabatan',['fungsional','struktural'])->nullable();
            $table->string('definisi');
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wewenang_jabatans');
    }
};
