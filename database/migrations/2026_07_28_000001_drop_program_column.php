<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Project di-lock khusus ke program Ojol Mengaji, jadi kolom
        // 'program' (dulu buat bedain tanwir_qurani vs ojol_mengaji) sudah
        // tidak dipakai lagi dan dihapus di sini.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('program');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('program');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('program', ['tanwir_qurani', 'ojol_mengaji'])->nullable()->after('role');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->enum('program', ['tanwir_qurani', 'ojol_mengaji'])->nullable()->after('code');
        });
    }
};
