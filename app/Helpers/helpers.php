<?php
use App\Models\Setting;

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        $val = \Illuminate\Support\Facades\Cache::remember(
            "setting_{$key}", 60,
            fn() => \App\Models\Setting::where('key', $key)->value('value')
        );
        return $val ?? $default;
    }

    if (!function_exists('sendNotification')) {
        function sendNotification(int $userId, string $judul, string $pesan, string $tipe = 'info', ?string $url = null): void
        {
            \App\Models\Notification::create([
                'user_id' => $userId,
                'judul'   => $judul,
                'pesan'   => $pesan,
                'tipe'    => $tipe,
                'url'     => $url,
            ]);
        }
    }

    if (!function_exists('sendNotificationBulk')) {
        function sendNotificationBulk(array $userIds, string $judul, string $pesan, string $tipe = 'info', ?string $url = null): void
        {
            $now  = now();
            $data = array_map(fn($id) => [
                'user_id'    => $id,
                'judul'      => $judul,
                'pesan'      => $pesan,
                'tipe'       => $tipe,
                'url'        => $url,
                'created_at' => $now,
                'updated_at' => $now,
            ], $userIds);

            \App\Models\Notification::insert($data);
        }
    }
}