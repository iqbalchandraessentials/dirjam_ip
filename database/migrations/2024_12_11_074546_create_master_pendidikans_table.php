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
        Schema::create('master_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('pengalaman_g1')->nullable();
            $table->string('pengalaman_g2')->nullable();
            $table->string('pengalaman_g3')->nullable();
            $table->string('penglaman_md')->nullable();
            $table->string('pengalaman_mm')->nullable();
            $table->string('pengalaman_ma')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pendidikans');
    }
};
