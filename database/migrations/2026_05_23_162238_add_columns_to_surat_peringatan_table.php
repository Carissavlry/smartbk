<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_peringatan', function (Blueprint $table) {
            $table->string('nomor_surat')->nullable()->after('id');
            $table->enum('status', ['draft','terkirim','dibaca'])->default('draft')->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('surat_peringatan', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat', 'status']);
        });
    }
};