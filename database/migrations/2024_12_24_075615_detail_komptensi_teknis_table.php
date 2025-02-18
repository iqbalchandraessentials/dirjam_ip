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
        Schema::create('detail_komptensi_teknis', function (Blueprint $table) {
            $table->bigInteger('id'); // Tidak pakai auto-increment
            $table->string('kode_master');
            $table->string('level');
            $table->string('kode_master_level');
            $table->string('perilaku', 4000);
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_komptensi_teknis');
    }
};