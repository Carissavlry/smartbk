<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel konseling_sesi
        Schema::create('konseling_sesi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konseling_id')->constrained('konselings')->onDelete('cascade');
            $table->unsignedInteger('ke')->default(1); // Sesi ke-1, ke-2, dst
            $table->date('tanggal');
            $table->unsignedInteger('durasi')->default(30); // menit
            $table->text('deskripsi_masalah');
            $table->text('tindakan_konselor');
            $table->text('rekomendasi')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();
        });

        // Modifikasi tabel konselings - hapus kolom yang pindah ke sesi
        Schema::table('konselings', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal',
                'durasi',
                'tindakan_konselor',
                'rekomendasi',
                'tindak_lanjut',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konseling_sesi');

        Schema::table('konselings', function (Blueprint $table) {
            $table->date('tanggal')->nullable();
            $table->unsignedInteger('durasi')->nullable();
            $table->text('tindakan_konselor')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->text('tindak_lanjut')->nullable();
        });
    }
};