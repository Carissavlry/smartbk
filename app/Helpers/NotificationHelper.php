<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper
{
    /**
     * Kirim notifikasi ke satu user
     */
    public static function send(int $userId, string $judul, string $pesan, string $tipe = 'info', ?string $url = null): void
    {
        Notification::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'tipe'    => $tipe,
            'url'     => $url,
        ]);
    }

    /**
     * Kirim notifikasi ke banyak user sekaligus
     */
    public static function sendBulk(array $userIds, string $judul, string $pesan, string $tipe = 'info', ?string $url = null): void
    {
        $now = now();
        $data = array_map(fn($id) => [
            'user_id'    => $id,
            'judul'      => $judul,
            'pesan'      => $pesan,
            'tipe'       => $tipe,
            'url'        => $url,
            'created_at' => $now,
            'updated_at' => $now,
        ], $userIds);

        Notification::insert($data);
    }
}