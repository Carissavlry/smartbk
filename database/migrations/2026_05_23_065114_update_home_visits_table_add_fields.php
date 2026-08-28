<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_visits', function (Blueprint $table) {
            $table->string('nomor_surat')->nullable()->after('id');
            $table->time('jam_mulai')->nullable()->after('tanggal');
            $table->time('jam_selesai')->nullable()->after('jam_mulai');
            $table->string('alamat')->nullable()->after('jam_selesai');
            $table->string('nama_ortu')->nullable()->after('alamat');
            $table->string('no_hp_ortu')->nullable()->after('nama_ortu');
            $table->enum('status_kehadiran_ortu', ['Ada', 'Tidak Ada'])->default('Ada')->after('no_hp_ortu');
            $table->string('yang_menemani')->nullable()->after('status_kehadiran_ortu');
            $table->text('kondisi_lingkungan')->nullable()->after('hasil');
            $table->text('kesimpulan')->nullable()->after('kondisi_lingkungan');
            $table->text('rekomendasi')->nullable()->after('kesimpulan');
        });

        // Buat tabel foto
        Schema::create('home_visit_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_visit_id')->constrained('home_visits')->onDelete('cascade');
            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('home_visits', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_surat', 'jam_mulai', 'jam_selesai',
                'alamat', 'nama_ortu', 'no_hp_ortu',
                'status_kehadiran_ortu', 'yang_menemani',
                'kondisi_lingkungan', 'kesimpulan', 'rekomendasi',
            ]);
        });

        Schema::dropIfExists('home_visit_fotos');
    }
};