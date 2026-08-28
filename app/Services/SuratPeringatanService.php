<?php
namespace App\Services;

use App\Models\Message;
use App\Models\Notification;
use App\Models\SuratPeringatan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SuratPeringatanService
{
    public function checkAndGenerate(User $siswa, User $guruBk): ?SuratPeringatan
    {
        $totalPoin = $siswa->pelanggarans()->sum('poin');

        $thresholdKuning = (int) setting('threshold_kuning', 25);
        $thresholdMerah  = (int) setting('threshold_merah',  50);
        $thresholdHitam  = (int) setting('threshold_hitam',  75);

        $level = null;
        if ($totalPoin >= $thresholdHitam) {
            $level = 'hitam';
        } elseif ($totalPoin >= $thresholdMerah) {
            $level = 'merah';
        } elseif ($totalPoin >= $thresholdKuning) {
            $level = 'kuning';
        }

        if (!$level) return null;

        // TIDAK ADA CEK ANTI-SPAM — langsung generate selalu
        return DB::transaction(function () use ($siswa, $guruBk, $level, $totalPoin) {

            $levelLabel  = ['kuning' => 'SP-1 (Kuning)', 'merah' => 'SP-2 (Merah)', 'hitam' => 'SP-3 (Hitam)'];
            $namaLevel   = $levelLabel[$level];
            $namaSekolah = setting('nama_sekolah', 'Sekolah');

            $isiSurat = "Sehubungan dengan akumulasi poin pelanggaran tata tertib {$namaSekolah}, dengan ini kami memberitahukan bahwa siswa yang bersangkutan telah mencapai total {$totalPoin} poin pelanggaran sehingga diterbitkan {$namaLevel}.\n\nSiswa diharapkan untuk segera memperbaiki sikap dan perilaku serta mematuhi seluruh peraturan sekolah yang berlaku. Apabila poin pelanggaran terus bertambah, maka akan dikenakan sanksi yang lebih berat sesuai tata tertib sekolah.";

            $surat = SuratPeringatan::create([
                'nomor_surat'   => SuratPeringatan::generateNomor($level),
                'user_id'       => $siswa->id,
                'jenis_surat'   => 'peringatan',
                'level'         => $level,
                'total_poin'    => $totalPoin,
                'tanggal_surat' => now()->toDateString(),
                'isi_surat'     => $isiSurat,
                'catatan'       => "Diterbitkan otomatis oleh sistem pada " . now()->format('d/m/Y H:i'),
                'dibuat_oleh'   => $guruBk->id,
                'status'        => 'terkirim',
            ]);

            // Kirim pesan ke siswa
            Message::create([
                'sender_id'           => $guruBk->id,
                'receiver_id'         => $siswa->id,
                'type'                => 'surat_peringatan',
                'body'                => "{$namaLevel} telah diterbitkan. Total poin pelanggaran Anda: {$totalPoin} poin. Silakan unduh surat untuk informasi lengkap.",
                'surat_peringatan_id' => $surat->id,
            ]);

            // Notifikasi siswa
            Notification::create([
                'user_id' => $siswa->id,
                'judul'   => "Surat Peringatan Diterbitkan",
                'pesan'   => "Anda menerima {$namaLevel} karena total poin pelanggaran mencapai {$totalPoin} poin. Cek chat untuk melihat & mengunduh surat.",
                'tipe'    => 'surat_peringatan',
                'url'     => '/siswa/chat',
            ]);

            // Notifikasi guru BK
            Notification::create([
                'user_id' => $guruBk->id,
                'judul'   => "{$namaLevel} Auto-Generated: {$siswa->name}",
                'pesan'   => "{$namaLevel} diterbitkan otomatis untuk {$siswa->name} dengan total {$totalPoin} poin.",
                'tipe'    => 'surat_peringatan',
                'url'     => '/guru-bk/surat-peringatan',
            ]);

            return $surat;
        });
    }
}