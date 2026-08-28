<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByRaw('read_at IS NOT NULL')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('siswa.notifications.index', compact('notifications'));
    }

    public function read(Notification $notification)
    {
        abort_if($notification->user_id !== Auth::id(), 403);

        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        return redirect($notification->url ?? route('siswa.dashboard'));
    }

    public function readAll()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }

    public function unread()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return response()->json([
            'count' => $notifications->count(),
            'items' => $notifications->map(fn($n) => [
                'id'    => $n->id,
                'judul' => $n->judul,
                'pesan' => $n->pesan,
                'tipe'  => $n->tipe,
                'url'   => $n->url,
                'waktu' => $n->created_at->setTimezone('Asia/Jakarta')->diffForHumans(),
            ]),
        ]);
    }
}