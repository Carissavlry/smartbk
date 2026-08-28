<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])
                  ->nullable()
                  ->after('nip');
            $table->string('no_hp', 20)
                  ->nullable()
                  ->after('jenis_kelamin');
            $table->string('pendidikan_terakhir', 10)
                  ->nullable()
                  ->after('no_hp');
            $table->year('tahun_mulai_bertugas')
                  ->nullable()
                  ->after('pendidikan_terakhir');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'no_hp',
                'pendidikan_terakhir',
                'tahun_mulai_bertugas',
            ]);
        });
    }
};