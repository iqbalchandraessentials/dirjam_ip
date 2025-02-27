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
        Schema::create('master_jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('aktif',[0,1])->default(1);
            $table->string('unit_kode');
            $table->enum('jenis_jabatan',['struktural','fungsional']);
            $table->string('jenjang_kode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_jabatans');
    }
};
