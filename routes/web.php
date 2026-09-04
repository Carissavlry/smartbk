<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SettingController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Auth (Breeze)
require __DIR__.'/auth.php';

// Route OAuth Google
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])
    ->name('auth.google');

Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'callback'])
    ->name('auth.google.callback');

// Google Connect (untuk user yang sudah login)
Route::middleware(['auth'])->get('/auth/google/connect', [App\Http\Controllers\Auth\GoogleAuthController::class, 'connectRedirect'])
    ->name('auth.google.connect');

// Route Ganti Password Pertama Login
Route::middleware(['auth', 'first.login'])->group(function () {
    Route::get('/first-login', [App\Http\Controllers\Auth\FirstLoginController::class, 'create'])
        ->name('first-login.form');
    Route::post('/first-login', [App\Http\Controllers\Auth\FirstLoginController::class, 'store'])
        ->name('first-login.update');
});

// Route setelah login — redirect ke dashboard sesuai role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'first.login'])
    ->name('dashboard');

// Dashboard Admin Sekolah
Route::middleware(['auth', 'first.login', 'role:admin_sekolah'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // Tahun Ajaran
        Route::resource('tahun-ajaran', \App\Http\Controllers\Admin\TahunAjaranController::class);
        Route::patch('tahun-ajaran/{tahunAjaran}/set-aktif', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'setAktif'])
            ->name('tahun-ajaran.set-aktif');

        // Kelas
        Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class)
             ->parameters(['kelas' => 'kelas']);

        // Guru BK
        Route::resource('guru-bk', \App\Http\Controllers\Admin\GuruBkController::class)
             ->parameters(['guru-bk' => 'gurubk']);
        Route::patch('guru-bk/{gurubk}/reset-password', [\App\Http\Controllers\Admin\GuruBkController::class, 'resetPassword'])
             ->name('guru-bk.reset-password');

        // Siswa — static routes HARUS di atas resource()
        Route::get('siswa/import', [\App\Http\Controllers\Admin\SiswaController::class, 'importForm'])
            ->name('siswa.import.form');
        Route::post('siswa/import', [\App\Http\Controllers\Admin\SiswaController::class, 'import'])
            ->name('siswa.import');
        Route::get('siswa/template', [\App\Http\Controllers\Admin\SiswaController::class, 'downloadTemplate'])
            ->name('siswa.template');
        Route::delete('siswa-bulk-delete', [\App\Http\Controllers\Admin\SiswaController::class, 'bulkDelete'])
            ->name('siswa.bulk-delete');
        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class)
            ->parameters(['siswa' => 'siswa']);
        Route::patch('siswa/{siswa}/reset-password', [\App\Http\Controllers\Admin\SiswaController::class, 'resetPassword'])
            ->name('siswa.reset-password');
        Route::get('siswa/{siswa}/kartu', [\App\Http\Controllers\Admin\SiswaController::class, 'kartu'])
            ->name('siswa.kartu');
        Route::get('siswa/{siswa}/kartu/print', [\App\Http\Controllers\Admin\SiswaController::class, 'kartuPrint'])
            ->name('siswa.kartu.print');
        
        // Jenis Pelanggaran
        Route::resource('jenis-pelanggaran', \App\Http\Controllers\Admin\JenisPelanggaranController::class)
             ->parameters(['jenis-pelanggaran' => 'jenisPelanggaran']);

        // Mutasi Siswa
        Route::resource('mutasi-siswa', \App\Http\Controllers\Admin\MutasiSiswaController::class);

        Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
        Route::put('setting', [SettingController::class, 'update'])->name('setting.update');

        // Approval Akun Murid/Guru
        Route::get('approval', [\App\Http\Controllers\Admin\UserApprovalController::class, 'index'])
            ->name('approval.index');
        Route::patch('approval/{user}/approve', [\App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])
            ->name('approval.approve');
        Route::patch('approval/{user}/reject', [\App\Http\Controllers\Admin\UserApprovalController::class, 'reject'])
            ->name('approval.reject');

        // Log Aktivitas
        Route::get('activity-log', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])
            ->name('activity-log.index');
        Route::delete('activity-log/clear', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])
            ->name('activity-log.clear');

        // Backup & Restore
        Route::get('backup', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
        Route::post('backup', [App\Http\Controllers\Admin\BackupController::class, 'backup'])->name('backup.store');
        Route::get('backup/download/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
        Route::delete('backup/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backup.destroy');
        Route::post('backup/restore', [App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('backup.restore');


    });

// ===== GURU BK ROUTES =====
Route::middleware(['auth', 'first.login', 'role:guru_bk'])
    ->prefix('guru-bk')
    ->name('guru-bk.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\GuruBk\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('konseling', App\Http\Controllers\GuruBk\KonselingController::class);
        Route::patch('konseling/{konseling}/status', [App\Http\Controllers\GuruBk\KonselingController::class, 'updateStatus'])->name('konseling.updateStatus');
        Route::get('konseling/{konseling}/sesi/create', [App\Http\Controllers\GuruBk\KonselingController::class, 'sesiCreate'])->name('konseling.sesi.create');
        Route::post('konseling/{konseling}/sesi', [App\Http\Controllers\GuruBk\KonselingController::class, 'sesiStore'])->name('konseling.sesi.store');
        Route::get('konseling/{konseling}/sesi/{sesi}', [App\Http\Controllers\GuruBk\KonselingController::class, 'sesiShow'])->name('konseling.sesi.show');
        Route::resource('pelanggaran', App\Http\Controllers\GuruBk\PelanggaranController::class);
        // Siswa Binaan
        Route::get('siswa-binaan', [App\Http\Controllers\GuruBk\SiswaBinaanController::class, 'index'])->name('siswa-binaan.index');
        Route::get('siswa-binaan/{siswa}', [App\Http\Controllers\GuruBk\SiswaBinaanController::class, 'show'])->name('siswa-binaan.show');
        Route::get('siswa-binaan/{siswa}/kartu', [App\Http\Controllers\GuruBk\SiswaBinaanController::class, 'kartu'])->name('siswa-binaan.kartu');
        // Home Visit
        Route::resource('home-visit', App\Http\Controllers\GuruBk\HomeVisitController::class);
        Route::delete('home-visit-foto/{foto}', [App\Http\Controllers\GuruBk\HomeVisitController::class, 'destroyFoto'])->name('home-visit.foto.destroy');
        Route::resource('prestasi', \App\Http\Controllers\GuruBK\PrestasiController::class);
        // Surat Peringatan
        Route::resource('surat-peringatan', \App\Http\Controllers\GuruBK\SuratPeringatanController::class)
            ->only(['index', 'show']);
        Route::post('surat-peringatan/generate', [\App\Http\Controllers\GuruBK\SuratPeringatanController::class, 'generate'])
            ->name('surat-peringatan.generate');
        Route::get('surat-peringatan/{suratPeringatan}/pdf', [\App\Http\Controllers\GuruBK\SuratPeringatanController::class, 'downloadPdf'])
            ->name('surat-peringatan.pdf');
        Route::post('surat-peringatan/{suratPeringatan}/acknowledge', [\App\Http\Controllers\GuruBK\SuratPeringatanController::class, 'acknowledge'])
            ->name('surat-peringatan.acknowledge');
        Route::delete('surat-peringatan/{suratPeringatan}', [\App\Http\Controllers\GuruBK\SuratPeringatanController::class, 'destroy'])
            ->name('surat-peringatan.destroy');
        // Chat Guru BK
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/', [\App\Http\Controllers\GuruBK\ChatController::class, 'index'])->name('index');
            Route::get('/{siswa}', [\App\Http\Controllers\GuruBK\ChatController::class, 'show'])->name('show');
            Route::post('/{siswa}/send', [\App\Http\Controllers\GuruBK\ChatController::class, 'send'])->name('send');
        });
        // B.13 - Notifikasi
        Route::get('/notifications', [App\Http\Controllers\GuruBK\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{notification}/read', [App\Http\Controllers\GuruBK\NotificationController::class, 'read'])->name('notifications.read');
        Route::post('/notifications/read-all', [App\Http\Controllers\GuruBK\NotificationController::class, 'readAll'])->name('notifications.read-all');
        Route::get('/notifications/unread', [App\Http\Controllers\GuruBK\NotificationController::class, 'unread'])->name('notifications.unread');
        // B.12 - Papan Pengumuman
        Route::resource('pengumuman', \App\Http\Controllers\GuruBK\PengumumanController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::post('pengumuman/{pengumuman}/toggle-pin', [\App\Http\Controllers\GuruBK\PengumumanController::class, 'togglePin'])
            ->name('pengumuman.toggle-pin');
        // B.3 - Konseling Pengajuan (Guru BK)
        Route::get('/konseling-pengajuan', [App\Http\Controllers\GuruBk\KonselingPengajuanController::class, 'index'])->name('konseling-pengajuan.index');
        Route::get('/konseling-pengajuan/{konselingPengajuan}', [App\Http\Controllers\GuruBk\KonselingPengajuanController::class, 'show'])->name('konseling-pengajuan.show');
        Route::post('/konseling-pengajuan/{konselingPengajuan}/setujui', [App\Http\Controllers\GuruBk\KonselingPengajuanController::class, 'setujui'])->name('konseling-pengajuan.setujui');
        Route::post('/konseling-pengajuan/{konselingPengajuan}/tolak', [App\Http\Controllers\GuruBk\KonselingPengajuanController::class, 'tolak'])->name('konseling-pengajuan.tolak');
        Route::post('/konseling-pengajuan/{konselingPengajuan}/reschedule', [App\Http\Controllers\GuruBk\KonselingPengajuanController::class, 'reschedule'])->name('konseling-pengajuan.reschedule');
        // Profil Guru BK
        Route::get('/profil/google/connect', [\App\Http\Controllers\GuruBK\ProfilController::class, 'googleConnect'])->name('profil.google.connect');
        Route::delete('/profil/google/disconnect', [\App\Http\Controllers\GuruBK\ProfilController::class, 'googleDisconnect'])->name('profil.google.disconnect');
        Route::get('/profil', [\App\Http\Controllers\GuruBK\ProfilController::class, 'index'])->name('profil.index');
        Route::put('/profil', [\App\Http\Controllers\GuruBK\ProfilController::class, 'update'])->name('profil.update');
        Route::put('/profil/password', [\App\Http\Controllers\GuruBK\ProfilController::class, 'password'])->name('profil.password');
        // B.14 — Laporan PDF
        Route::get('/laporan', [App\Http\Controllers\GuruBk\LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/konseling', [App\Http\Controllers\GuruBk\LaporanController::class, 'konseling'])->name('laporan.konseling');
        Route::post('/laporan/pelanggaran', [App\Http\Controllers\GuruBk\LaporanController::class, 'pelanggaran'])->name('laporan.pelanggaran');
        Route::post('/laporan/prestasi', [App\Http\Controllers\GuruBk\LaporanController::class, 'prestasi'])->name('laporan.prestasi');
        Route::post('/laporan/home-visit', [App\Http\Controllers\GuruBk\LaporanController::class, 'homeVisit'])->name('laporan.home-visit');
        Route::post('/laporan/rekap-umum', [App\Http\Controllers\GuruBk\LaporanController::class, 'rekapUmum'])->name('laporan.rekap-umum');
        // Excel Export
        Route::post('/laporan/excel/konseling',   [App\Http\Controllers\GuruBk\LaporanController::class, 'excelKonseling'])->name('laporan.excel.konseling');
        Route::post('/laporan/excel/pelanggaran', [App\Http\Controllers\GuruBk\LaporanController::class, 'excelPelanggaran'])->name('laporan.excel.pelanggaran');
        Route::post('/laporan/excel/prestasi',    [App\Http\Controllers\GuruBk\LaporanController::class, 'excelPrestasi'])->name('laporan.excel.prestasi');
        Route::post('/laporan/excel/home-visit',  [App\Http\Controllers\GuruBk\LaporanController::class, 'excelHomeVisit'])->name('laporan.excel.home-visit');
        Route::post('/laporan/excel/rekap-umum',  [App\Http\Controllers\GuruBk\LaporanController::class, 'excelRekapUmum'])->name('laporan.excel.rekap-umum');
    });

// Dashboard Siswa
Route::middleware(['auth', 'first.login', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');

        // Pengumuman
        Route::get('/pengumuman', [App\Http\Controllers\Siswa\PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('/pengumuman/{pengumuman}', [App\Http\Controllers\Siswa\PengumumanController::class, 'show'])->name('pengumuman.show');

        // Konseling
        Route::get('/konseling', [App\Http\Controllers\Siswa\KonselingController::class, 'index'])->name('konseling.index');
        Route::get('/konseling/{konseling}', [App\Http\Controllers\Siswa\KonselingController::class, 'show'])->name('konseling.show');

        // Pengajuan Konseling
        Route::get('/pengajuan-konseling', [App\Http\Controllers\Siswa\KonselingController::class, 'pengajuan'])->name('konseling.pengajuan');
        Route::post('/pengajuan-konseling', [App\Http\Controllers\Siswa\KonselingController::class, 'storePengajuan'])->name('konseling.pengajuan.store');
        Route::get('/pengajuan-konseling/{pengajuan}', [App\Http\Controllers\Siswa\KonselingController::class, 'showPengajuan'])->name('konseling.pengajuan.show');

        // Chat
        Route::get('/chat', [App\Http\Controllers\Siswa\ChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/unread-count', [App\Http\Controllers\Siswa\ChatController::class, 'unreadCount'])->name('chat.unread-count');
        Route::get('/chat/unread-messages', [App\Http\Controllers\Siswa\ChatController::class, 'unreadMessages'])->name('chat.unread-messages');
        Route::post('/chat/send', [App\Http\Controllers\Siswa\ChatController::class, 'send'])->name('chat.send');

        // Profil Siswa
        Route::get('/profil/google/connect', [\App\Http\Controllers\Siswa\ProfilController::class, 'googleConnect'])->name('profil.google.connect');
        Route::delete('/profil/google/disconnect', [\App\Http\Controllers\Siswa\ProfilController::class, 'googleDisconnect'])->name('profil.google.disconnect');
        Route::get('/profil', [App\Http\Controllers\Siswa\ProfilController::class, 'index'])->name('profil.index');
        Route::put('/profil', [App\Http\Controllers\Siswa\ProfilController::class, 'update'])->name('profil.update');
        Route::put('/profil/password', [App\Http\Controllers\Siswa\ProfilController::class, 'password'])->name('profil.password');

        // Notifikasi Siswa
        Route::get('/notifications', [App\Http\Controllers\Siswa\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/unread', [App\Http\Controllers\Siswa\NotificationController::class, 'unread'])->name('notifications.unread');
        Route::post('/notifications/read-all', [App\Http\Controllers\Siswa\NotificationController::class, 'readAll'])->name('notifications.read-all');
        Route::get('/notifications/{notification}/read', [App\Http\Controllers\Siswa\NotificationController::class, 'read'])->name('notifications.read');

        Route::get('/surat-peringatan/{suratPeringatan}', [App\Http\Controllers\Siswa\SuratPeringatanController::class, 'show'])->name('surat-peringatan.show');
        Route::get('/surat-peringatan/{suratPeringatan}/download', [App\Http\Controllers\Siswa\SuratPeringatanController::class, 'download'])->name('surat-peringatan.download');

        // Pelanggaran
        Route::get('/pelanggaran', [App\Http\Controllers\Siswa\PelanggaranController::class, 'index'])->name('pelanggaran.index');

        // Prestasi
        Route::get('/prestasi', [App\Http\Controllers\Siswa\PrestasiController::class, 'index'])->name('prestasi.index');


    });