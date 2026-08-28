<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konselings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guru_bk_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('kategori', ['Pribadi', 'Sosial', 'Belajar', 'Karir', 'Keluarga']);
            $table->integer('durasi')->comment('durasi dalam menit');
            $table->text('deskripsi_masalah');
            $table->text('tindakan_konselor');
            $table->text('rekomendasi')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->enum('status', ['Baru', 'Dalam Proses', 'Selesai'])->default('Baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konselings');
    }
};