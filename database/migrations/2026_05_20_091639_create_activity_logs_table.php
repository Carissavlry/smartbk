<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->nullable();        // nama snapshot saat aksi terjadi
            $table->string('role')->nullable();             // role saat aksi: admin_sekolah, guru_bk, siswa
            $table->string('action');                       // LOGIN, LOGOUT, CREATE, UPDATE, DELETE, IMPORT, RESTORE
            $table->string('module');                       // Siswa, Guru BK, Kelas, Konseling, dst
            $table->text('description')->nullable();        // deskripsi detail aksi
            $table->string('subject_type')->nullable();     // model yang terdampak, misal: App\Models\User
            $table->unsignedBigInteger('subject_id')->nullable(); // ID record yang terdampak
            $table->string('ip_address', 45)->nullable();   // IPv4 & IPv6
            $table->string('user_agent')->nullable();       // browser/device info
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};