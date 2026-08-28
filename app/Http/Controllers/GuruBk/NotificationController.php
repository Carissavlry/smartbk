<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Halaman semua notifikasi
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByRaw('read_at IS NOT NULL')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('guru-bk.notifications.index', compact('notifications'));
    }

    // Tandai satu notifikasi sebagai dibaca + redirect
    public function read(Notification $notification)
    {
        abort_if($notification->user_id !== Auth::id(), 403);

        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        return redirect($notification->url ?? route('guru-bk.dashboard'));
    }

    // Tandai semua sebagai dibaca
    public function readAll()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    // API — ambil notifikasi unread (untuk polling navbar)
    public function unread()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $count = $notifications->count();

        return response()->json([
            'count' => $count,
            'items' => $notifications->map(fn($n) => [
                'id'      => $n->id,
                'judul'   => $n->judul,
                'pesan'   => $n->pesan,
                'tipe'    => $n->tipe,
                'url'     => $n->url,
                'waktu'   => $n->created_at->setTimezone('Asia/Jakarta')->diffForHumans(),
            ]),
        ]);
    }
}