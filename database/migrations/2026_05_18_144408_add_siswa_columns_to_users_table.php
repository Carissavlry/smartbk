<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('kelas_id');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('alamat')->nullable()->after('tanggal_lahir');
            $table->string('nama_ortu')->nullable()->after('alamat');
            $table->string('no_hp_ortu')->nullable()->after('nama_ortu');
            $table->string('foto')->nullable()->after('no_hp_ortu');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'nama_ortu',
                'no_hp_ortu',
                'foto',
            ]);
        });
    }
};