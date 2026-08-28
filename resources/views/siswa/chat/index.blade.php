@extends('layouts.siswa')

@section('title', 'Chat Guru BK')
@section('page-title', 'Chat Guru BK')

@section('content')
<style>
.chat-wrap { display:flex; flex-direction:column; height:calc(100vh - 160px); background:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(2,16,36,0.12); overflow:hidden; }

/* HEADER */
.chat-header { display:flex; align-items:center; gap:12px; padding:16px 20px; border-bottom:1px solid rgba(255,255,255,0.1); background:linear-gradient(135deg, #021024 0%, #052659 60%, #550B18 100%); }
.chat-header-avatar { width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,0.15); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.95rem; overflow:hidden; flex-shrink:0; border:2px solid rgba(255,255,255,0.25); }
.chat-header-name { font-size:0.92rem; font-weight:700; color:#ffffff; }
.chat-header-sub { font-size:0.73rem; color:rgba(255,255,255,0.55); margin-top:1px; }

/* MESSAGES */
.chat-messages { flex:1; overflow-y:auto; padding:20px; display:flex; flex-direction:column; gap:12px; background:#f1f5f9; }
.chat-messages::-webkit-scrollbar { width:4px; }
.chat-messages::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:4px; }

/* BUBBLE */
.bubble-wrap { display:flex; flex-direction:column; max-width:68%; }
.bubble-wrap.mine { align-self:flex-end; align-items:flex-end; }
.bubble-wrap.theirs { align-self:flex-start; align-items:flex-start; }
.bubble { padding:10px 15px; border-radius:16px; font-size:0.85rem; line-height:1.6; word-break:break-word; }
.bubble.mine { background:linear-gradient(135deg,#052659,#021024); color:#fff; border-bottom-right-radius:4px; box-shadow:0 2px 8px rgba(5,38,89,0.25); }
.bubble.theirs { background:#ffffff; color:#1e293b; border:1px solid #e2e8f0; border-bottom-left-radius:4px; box-shadow:0 1px 4px rgba(0,0,0,0.06); }
.bubble-time { font-size:0.67rem; color:#94a3b8; margin-top:4px; }

/* SURAT PERINGATAN */
.bubble-surat { background:#fff7ed; border:1px solid #fed7aa; border-radius:12px; padding:12px 16px; max-width:320px; }
.surat-label { font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#c2410c; margin-bottom:6px; display:flex; align-items:center; gap:4px; }
.surat-title { font-size:0.85rem; font-weight:700; color:#1e293b; margin-bottom:4px; }
.surat-meta { font-size:0.75rem; color:#78716c; }

/* INPUT */
.chat-input-wrap { padding:14px 20px; border-top:1px solid rgba(255,255,255,0.1); background:linear-gradient(135deg, #021024 0%, #052659 60%, #550B18 100%); }
.chat-input-form { display:flex; gap:10px; align-items:flex-end; }
.chat-input-form textarea { flex:1; border:1.5px solid rgba(255,255,255,0.2); border-radius:12px; padding:10px 15px; font-size:0.85rem; resize:none; font-family:inherit; line-height:1.5; max-height:120px; outline:none; transition:border .15s; background:rgba(255,255,255,0.95); color:#0f172a; }
.chat-input-form textarea:focus { border-color:rgba(255,255,255,0.6); }
.btn-send { background:linear-gradient(135deg,#75162E,#3A000C); color:#fff; border:none; border-radius:12px; padding:10px 20px; cursor:pointer; display:flex; align-items:center; gap:6px; font-size:0.82rem; font-weight:600; transition:opacity .15s; flex-shrink:0; box-shadow:0 2px 8px rgba(117,22,46,0.4); }
.btn-send:hover { opacity:0.88; }

.date-divider { text-align:center; font-size:0.72rem; color:#94a3b8; margin:4px 0; }
.date-divider span { background:#e2e8f0; padding:3px 12px; border-radius:20px; }
</style>

<a href="{{ route('siswa.dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;color:#64748b;font-size:0.82rem;text-decoration:none;padding:6px 10px;border-radius:8px;transition:background .15s;margin-bottom:14px;" onmouseover="this.style.background='#f1f5f9';this.style.color='#1e3a5f'" onmouseout="this.style.background='transparent';this.style.color='#64748b'">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
    </svg>
    Kembali ke Dashboard
</a>

{{-- judul dihapus --}}

@if(!$guruBk)
<div style="background:white;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:48px 20px;text-align:center;">
    <div style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:4px;">Guru BK Belum Tersedia</div>
    <div style="font-size:0.82rem;color:#64748b;">Kamu belum memiliki Guru BK yang ditugaskan. Hubungi admin sekolah.</div>
</div>

@else
<div class="chat-wrap">

    {{-- HEADER --}}
    <div class="chat-header">
        <div class="chat-header-avatar">
            @if($guruBk->foto)
                <img src="{{ asset('storage/' . $guruBk->foto) }}" alt="{{ $guruBk->name }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                {{ strtoupper(substr($guruBk->name, 0, 1)) }}
            @endif
        </div>
        <div>
            <div class="chat-header-name">{{ $guruBk->name }}</div>
            <div class="chat-header-sub">Guru BK &middot; {{ $guruBk->email }}</div>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div class="chat-messages" id="chatMessages">
        @if($messages->isEmpty())
            <div style="text-align:center;color:#94a3b8;font-size:0.82rem;margin:auto;">
                Belum ada pesan. Mulai percakapan sekarang.
            </div>
        @else
            @php $lastDate = null; @endphp
            @foreach($messages as $msg)
                @php
                    $msgDate = \Carbon\Carbon::parse($msg->created_at)->setTimezone('Asia/Jakarta')->format('d F Y');
                    $isMine  = $msg->sender_id === Auth::id();
                @endphp

                @if($msgDate !== $lastDate)
                    <div class="date-divider"><span>{{ $msgDate }}</span></div>
                    @php $lastDate = $msgDate; @endphp
                @endif

                <div class="bubble-wrap {{ $isMine ? 'mine' : 'theirs' }}">
                    @if($msg->type === 'surat_peringatan' && $msg->suratPeringatan)
                    <div class="bubble-surat">
                        <div class="surat-label">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                            </svg>
                            Surat Peringatan Otomatis
                        </div>
                        <div class="surat-title">{{ $msg->suratPeringatan->nomor_surat }}</div>
                        <div class="surat-meta" style="margin-bottom:10px;">
                            Level: {{ ucfirst($msg->suratPeringatan->level) }} &middot;
                            {{ $msg->suratPeringatan->total_poin }} Poin
                        </div>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <a href="{{ route('siswa.surat-peringatan.show', $msg->suratPeringatan) }}"
                            style="display:inline-flex;align-items:center;gap:4px;font-size:0.72rem;font-weight:600;padding:5px 10px;border-radius:7px;text-decoration:none;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Lihat
                            </a>
                            <a href="{{ route('siswa.surat-peringatan.download', $msg->suratPeringatan) }}"
                            target="_blank"
                            style="display:inline-flex;align-items:center;gap:4px;font-size:0.72rem;font-weight:600;padding:5px 10px;border-radius:7px;text-decoration:none;background:#dc2626;color:#fff;border:none;">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                    @else
                        <div class="bubble {{ $isMine ? 'mine' : 'theirs' }}">{{ $msg->body }}</div>
                    @endif
                    <span class="bubble-time">
                        {{ \Carbon\Carbon::parse($msg->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
                    </span>
                </div>
            @endforeach
        @endif
    </div>

    {{-- INPUT --}}
    <div class="chat-input-wrap">
        @if(session('success'))
            <div style="font-size:0.78rem;color:#16a34a;margin-bottom:8px;display:flex;align-items:center;gap:6px;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        <form class="chat-input-form" method="POST" action="{{ route('siswa.chat.send') }}">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $guruBk->id }}">
            <textarea name="body" rows="1" placeholder="Tulis pesan..."
                onInput="this.style.height='auto';this.style.height=this.scrollHeight+'px'"
                onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();this.form.submit();}">{{ old('body') }}</textarea>
            <button type="submit" class="btn-send">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                </svg>
                Kirim
            </button>
        </form>
    </div>

</div>
@endif

<script>
    const chatMessages = document.getElementById('chatMessages');
    if(chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;
</script>
@endsection