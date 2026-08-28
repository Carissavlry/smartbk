<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $guruBk = Auth::user();
        $search  = $request->get('search');
        $kelasId = $request->get('kelas_id');

        // Ambil kelas binaan untuk dropdown
        $kelasBinaan = \App\Models\Kelas::where('guru_id', $guruBk->id)->orderBy('nama')->get();

        $siswaList = User::role('siswa')
            ->whereHas('kelas', function ($q) use ($guruBk) {
                $q->where('guru_id', $guruBk->id);
            })
            ->with('kelas')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%');
                });
            })
            ->when($kelasId, function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            })
            ->get()
            ->map(function ($siswa) use ($guruBk) {
                $lastMessage = Message::where(function ($q) use ($guruBk, $siswa) {
                        $q->where('sender_id', $guruBk->id)->where('receiver_id', $siswa->id);
                    })
                    ->orWhere(function ($q) use ($guruBk, $siswa) {
                        $q->where('sender_id', $siswa->id)->where('receiver_id', $guruBk->id);
                    })
                    ->latest()
                    ->first();

                $unread = Message::where('sender_id', $siswa->id)
                    ->where('receiver_id', $guruBk->id)
                    ->whereNull('read_at')
                    ->count();

                $siswa->last_message = $lastMessage;
                $siswa->unread_count = $unread;
                return $siswa;
            })
            ->sortByDesc(fn($s) => optional($s->last_message)->created_at)
            ->values();

        return view('guru-bk.chat.index', compact('siswaList', 'search', 'kelasId', 'kelasBinaan'));
    }

    public function show(User $siswa)
    {
        $guruBk = Auth::user();

        $messages = Message::where(function ($q) use ($guruBk, $siswa) {
                $q->where('sender_id', $guruBk->id)->where('receiver_id', $siswa->id);
            })
            ->orWhere(function ($q) use ($guruBk, $siswa) {
                $q->where('sender_id', $siswa->id)->where('receiver_id', $guruBk->id);
            })
            ->with(['suratPeringatan', 'sender'])
            ->orderBy('created_at')
            ->get();

        Message::where('sender_id', $siswa->id)
            ->where('receiver_id', $guruBk->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('guru-bk.chat.show', compact('siswa', 'messages'));
    }

    public function send(Request $request, User $siswa)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $guruBk = Auth::user();

        Message::create([
            'sender_id'   => $guruBk->id,
            'receiver_id' => $siswa->id,
            'type'        => 'text',
            'body'        => $request->body,
        ]);

        Notification::create([
            'user_id' => $siswa->id,
            'judul'   => 'Pesan dari Guru BK',
            'pesan'   => \Str::limit($request->body, 80),
            'tipe'    => 'chat',
            'url'     => '/siswa/chat',
        ]);

        return redirect()->route('guru-bk.chat.show', $siswa)
            ->with('success', 'Pesan berhasil dikirim.');
    }
}