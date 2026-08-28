<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE notifications MODIFY COLUMN tipe ENUM('konseling','warning','success','info','chat','surat_peringatan','sistem','alert_pelanggaran','pelanggaran') NOT NULL DEFAULT 'info'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifications MODIFY COLUMN tipe ENUM('konseling','warning','success','info','chat','surat_peringatan','sistem','alert_pelanggaran') NOT NULL DEFAULT 'info'");
    }
};
