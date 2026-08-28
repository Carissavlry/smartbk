<?php
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $guruBk = User::role('guru_bk')
            ->whereHas('kelasBindaan', function($q) use ($user) {
                $q->where('id', $user->kelas_id);
            })->first();

        $messages = collect();
        if ($guruBk) {
            $messages = Message::where(function($q) use ($user, $guruBk) {
                $q->where('sender_id', $user->id)->where('receiver_id', $guruBk->id);
            })->orWhere(function($q) use ($user, $guruBk) {
                $q->where('sender_id', $guruBk->id)->where('receiver_id', $user->id);
            })
            ->whereIn('type', ['chat', 'text', 'surat_peringatan', null])
            ->orderBy('created_at')
            ->with('suratPeringatan')
            ->get();

            Message::where('sender_id', $guruBk->id)
                ->where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return view('siswa.chat.index', compact('messages', 'guruBk'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'body'        => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $siswa  = Auth::user();
        $guruBk = User::find($request->receiver_id);

        Message::create([
            'sender_id'   => $siswa->id,
            'receiver_id' => $guruBk->id,
            'body'        => $request->body,
            'type'        => 'text',
        ]);

        // Notifikasi ke Guru BK
        Notification::create([
            'user_id' => $guruBk->id,
            'judul'   => 'Pesan dari ' . $siswa->name,
            'pesan'   => Str::limit($request->body, 80),
            'tipe'    => 'chat',
            'url'     => '/guru-bk/chat/' . $siswa->id,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    public function unreadCount()
    {
        $userId = Auth::id();
        // Hitung pesan yang belum dibaca dari guru BK (bukan dari siswa sendiri)
        $count = \App\Models\Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function unreadMessages(Request $request)
    {
        $userId = Auth::id();

        // Kalau ada query ?mark_all=1, langsung tandai semua dibaca
        if ($request->query('mark_all') == '1') {
            \App\Models\Message::where('receiver_id', $userId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
            return response()->json(['count' => 0, 'items' => []]);
        }

        $messages = \App\Models\Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return response()->json([
            'count' => $messages->count(),
            'items' => $messages->map(fn($m) => [
                'id'    => $m->id,
                'judul' => $m->type === 'surat_peringatan' ? 'Surat Peringatan Diterbitkan' : 'Pesan Baru dari Guru BK',
                'pesan' => $m->body,
                'tipe'  => $m->type === 'surat_peringatan' ? 'surat_peringatan' : 'chat',
                'url'   => route('siswa.chat.index'),
                'waktu' => $m->created_at->setTimezone('Asia/Jakarta')->diffForHumans(),
            ]),
        ]);
    }
}