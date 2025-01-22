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
        Schema::table('users', function (Blueprint $table) {
            $table->string('USER_ID')->nullable()->after('email'); // Tambahkan setelah kolom email
            $table->string('UNIT_KD')->nullable()->after('USER_ID'); // Tambahkan setelah kolom USER_ID
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['USER_ID', 'UNIT_KD']); // Hapus kolom saat rollback
        });
    }
};
