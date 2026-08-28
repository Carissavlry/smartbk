<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');       // siswa
            $table->foreignId('dicatat_oleh')->constrained('users')->onDelete('cascade'); // guru bk
            $table->string('nama_prestasi');
            $table->enum('jenis', ['Akademik', 'Non-Akademik']);
            $table->enum('tingkat', ['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional']);
            $table->enum('peringkat', ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Peserta'])->nullable();
            $table->string('penyelenggara')->nullable();
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->string('bukti')->nullable(); // path file sertifikat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};