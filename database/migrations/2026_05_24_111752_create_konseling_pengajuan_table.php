<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konseling_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guru_bk_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_diajukan');
            $table->time('jam_diajukan');
            $table->string('topik');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'reschedule', 'selesai'])->default('menunggu');
            $table->text('alasan_tolak')->nullable();
            $table->date('tanggal_reschedule')->nullable();
            $table->time('jam_reschedule')->nullable();
            $table->text('catatan_reschedule')->nullable();
            $table->foreignId('konseling_id')->nullable()->constrained('konselings')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konseling_pengajuan');
    }
};