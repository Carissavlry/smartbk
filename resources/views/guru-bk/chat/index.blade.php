@extends('layouts.guru')

@section('title', 'Chat Siswa Binaan')
@section('page-title', 'Chat Siswa Binaan')

@section('content')
<style>
.chat-list { display:flex; flex-direction:column; gap:0; background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); overflow:hidden; }
.chat-item { display:flex; align-items:center; gap:14px; padding:14px 20px; border-bottom:1px solid #f1f5f9; text-decoration:none; color:inherit; transition:background .15s; }
.chat-item:last-child { border-bottom:none; }
.chat-item:hover { background:#f8fafc; }
.chat-avatar { width:44px; height:44px; border-radius:50%; background:var(--navy-dark); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1rem; flex-shrink:0; overflow:hidden; }
.chat-avatar img { width:100%; height:100%; object-fit:cover; }
.chat-info { flex:1; min-width:0; }
.chat-name { font-size:0.88rem; font-weight:700; color:#1e293b; margin-bottom:2px; }
.chat-preview { font-size:0.78rem; color:#94a3b8; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.chat-meta { display:flex; flex-direction:column; align-items:flex-end; gap:4px; flex-shrink:0; }
.chat-time { font-size:0.72rem; color:#cbd5e1; }
.chat-badge { background:#dc2626; color:#fff; font-size:0.65rem; font-weight:700; padding:2px 7px; border-radius:20px; min-width:20px; text-align:center; }
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.page-header h2 { font-size:1rem; font-weight:700; color:var(--navy-darkest); }
.empty-state { text-align:center; padding:60px 20px; color:#94a3b8; }
.empty-state svg { width:48px; height:48px; margin:0 auto 12px; opacity:.4; }
</style>

<div class="page-header">
    <h2>Chat Siswa Binaan</h2>
</div>

{{-- Filter Bar --}}
<div class="card" style="background:#fff;border-radius:14px;box-shadow:0 1px 6px rgba(30,41,59,.07);margin-bottom:16px;overflow:hidden;">
    <div style="padding:12px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
        </svg>
        <span style="font-size:0.72rem;font-weight:700;color:var(--navy-darkest);text-transform:uppercase;letter-spacing:0.05em;">Filter & Pencarian</span>
    </div>
    <div style="padding:16px 20px;">
        <form method="GET" action="{{ route('guru-bk.chat.index') }}">
            <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:14px;align-items:flex-end;">
                <div style="display:flex;flex-direction:column;gap:4px;">
                    <label style="font-size:0.72rem;font-weight:600;color:#64748b;">Cari Siswa</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Nama / NIS..."
                           style="padding:7px 10px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.82rem;color:#1e293b;background:white;width:100%;font-family:inherit;outline:none;">
                </div>
                <div style="display:flex;flex-direction:column;gap:4px;">
                    <label style="font-size:0.72rem;font-weight:600;color:#64748b;">Kelas</label>
                    <select name="kelas_id"
                            style="padding:7px 10px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.82rem;color:#1e293b;background:white;width:100%;font-family:inherit;outline:none;">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasBinaan as $kelas)
                            <option value="{{ $kelas->id }}" {{ ($kelasId ?? '') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="display:flex;gap:8px;">
                    <button type="submit"
                            style="padding:8px 20px;background:var(--navy-dark);color:white;border:none;border-radius:8px;font-size:0.82rem;font-weight:600;cursor:pointer;">
                        Cari
                    </button>
                    <a href="{{ route('guru-bk.chat.index') }}"
                       style="padding:8px 16px;background:white;color:#64748b;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;">
                        Reset
                    </a>
                </div>
            </div>
            @if($search || $kelasId)
            <p style="font-size:0.78rem;color:#94a3b8;margin-top:10px;">
                Menampilkan <strong style="color:#1e293b;">{{ $siswaList->count() }}</strong> siswa ditemukan
            </p>
            @endif
        </form>
   </div>
</div>

@if($siswaList->isEmpty())
    <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
        </svg>
        <p>Belum ada siswa binaan.</p>
    </div>
@else
    <div class="chat-list">
        @foreach($siswaList as $siswa)
        <a href="{{ route('guru-bk.chat.show', $siswa) }}" class="chat-item">
            <div class="chat-avatar">
                @if($siswa->foto)
                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->name }}">
                @else
                    {{ strtoupper(substr($siswa->name, 0, 1)) }}
                @endif
            </div>
            <div class="chat-info">
                <div class="chat-name">{{ $siswa->name }}</div>
                <div class="chat-preview">
                    @if($siswa->last_message)
                        @if($siswa->last_message->type === 'surat_peringatan')
                            [Surat Peringatan Otomatis]
                        @else
                            {{ \Str::limit($siswa->last_message->body, 50) }}
                        @endif
                    @else
                        Belum ada pesan
                    @endif
                </div>
            </div>
            <div class="chat-meta">
                @if($siswa->last_message)
                    <span class="chat-time">
                        {{ $siswa->last_message->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}
                    </span>
                @endif
                @if($siswa->unread_count > 0)
                    <span class="chat-badge">{{ $siswa->unread_count }}</span>
                @endif
            </div>
        </a>
        @endforeach
    </div>
@endif
@endsection