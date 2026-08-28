<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE notifications MODIFY COLUMN tipe ENUM('konseling','warning','success','info','chat','surat_peringatan','sistem','alert_pelanggaran') NOT NULL DEFAULT 'info'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifications MODIFY COLUMN tipe ENUM('konseling','warning','success','info','chat','surat_peringatan','sistem') NOT NULL DEFAULT 'info'");
    }
};