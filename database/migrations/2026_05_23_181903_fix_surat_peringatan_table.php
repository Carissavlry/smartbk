<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom isi_surat jika belum ada
        Schema::table('surat_peringatan', function (Blueprint $table) {
            if (!Schema::hasColumn('surat_peringatan', 'isi_surat')) {
                $table->text('isi_surat')->nullable()->after('catatan');
            }
        });

        // 2. Ubah level dari int ke string dulu
        DB::statement("ALTER TABLE surat_peringatan MODIFY COLUMN level VARCHAR(20) NOT NULL DEFAULT 'kuning'");

        // 3. Migrate data level lama (int → string)
        DB::statement("UPDATE surat_peringatan SET level = CASE 
            WHEN level = '1' THEN 'kuning'
            WHEN level = '2' THEN 'merah'
            WHEN level = '3' THEN 'hitam'
            ELSE 'kuning'
        END");

        // 4. Reset semua status lama ke 'terkirim' dulu (pakai VARCHAR sementara)
        DB::statement("ALTER TABLE surat_peringatan MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'terkirim'");
        DB::statement("UPDATE surat_peringatan SET status = 'terkirim'");

        // 5. Baru ubah ke enum baru
        DB::statement("ALTER TABLE surat_peringatan MODIFY COLUMN status ENUM('terkirim','diakui') NOT NULL DEFAULT 'terkirim'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE surat_peringatan MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'draft'");
        DB::statement("UPDATE surat_peringatan SET status = 'draft'");
        DB::statement("ALTER TABLE surat_peringatan MODIFY COLUMN level INT NOT NULL DEFAULT 1");

        Schema::table('surat_peringatan', function (Blueprint $table) {
            if (Schema::hasColumn('surat_peringatan', 'isi_surat')) {
                $table->dropColumn('isi_surat');
            }
        });
    }
};