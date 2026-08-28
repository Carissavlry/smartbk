<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    protected string $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');
    }

    // Halaman utama backup
    public function index()
    {
        $files = [];

        if (is_dir($this->backupPath)) {
            $rawFiles = glob($this->backupPath . '/*.sql');
            rsort($rawFiles); // terbaru di atas

            foreach ($rawFiles as $file) {
                $files[] = [
                    'name'       => basename($file),
                    'size'       => $this->formatSize(filesize($file)),
                    'created_at' => date('d/m/Y H:i:s', filemtime($file)),
                ];
            }
        }

        return view('admin.backup.index', compact('files'));
    }

    // Proses backup database
    public function backup()
    {
        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }

        $db       = config('database.connections.mysql.database');
        $user     = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port', 3306);

        $filename  = 'backup_' . $db . '_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $filepath  = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        // Bangun perintah mysqldump
        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers %s > %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($user),
            escapeshellarg($password),
            escapeshellarg($db),
            escapeshellarg($filepath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($filepath) || filesize($filepath) === 0) {
            return redirect()->route('admin.backup.index')
                             ->with('error', 'Backup gagal. Pastikan mysqldump tersedia dan konfigurasi database benar.');
        }

        ActivityLog::record('CREATE', 'Backup', "Backup database berhasil: {$filename}");

        return redirect()->route('admin.backup.index')
                         ->with('success', "Backup berhasil dibuat: {$filename}");
    }

    // Download file backup
    public function download(string $filename)
    {
        // Keamanan: pastikan filename tidak mengandung path traversal
        $filename = basename($filename);
        $filepath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        if (!file_exists($filepath)) {
            return redirect()->route('admin.backup.index')
                             ->with('error', 'File backup tidak ditemukan.');
        }

        ActivityLog::record('CREATE', 'Backup', "Download backup: {$filename}");

        return response()->download($filepath);
    }

    // Hapus file backup
    public function destroy(string $filename)
    {
        $filename = basename($filename);
        $filepath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        if (file_exists($filepath)) {
            unlink($filepath);
            ActivityLog::record('DELETE', 'Backup', "Menghapus file backup: {$filename}");
        }

        return redirect()->route('admin.backup.index')
                         ->with('success', 'File backup berhasil dihapus.');
    }

    // Proses restore dari file .sql yang diupload
    public function restore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:sql|max:51200', // max 50MB
        ]);

        $db       = config('database.connections.mysql.database');
        $user     = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port', 3306);

        $tmpPath = $request->file('file')->getRealPath();
        $originalName = $request->file('file')->getClientOriginalName();

        $command = sprintf(
            'mysql --host=%s --port=%s --user=%s --password=%s %s < %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($user),
            escapeshellarg($password),
            escapeshellarg($db),
            escapeshellarg($tmpPath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return redirect()->route('admin.backup.index')
                             ->with('error', 'Restore gagal. Pastikan file .sql valid.');
        }

        ActivityLog::record('RESTORE', 'Backup', "Restore database dari file: {$originalName}");

        return redirect()->route('admin.backup.index')
                         ->with('success', "Database berhasil direstore dari: {$originalName}");
    }

    // Helper: format ukuran file
    private function formatSize(int $bytes): string
    {
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}