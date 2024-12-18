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
        Schema::create('master_detail_komptensi_teknis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_master');
            $table->string('level');
            $table->string('perilaku',4000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_master_komptensi_teknis');
    }
};
