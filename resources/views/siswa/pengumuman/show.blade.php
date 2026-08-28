@extends('layouts.siswa')

@section('title', $pengumuman->judul)
@section('page-title', 'Detail Pengumuman')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- BACK BUTTON --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('siswa.pengumuman.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;font-size:0.82rem;font-weight:700;color:#475569;text-decoration:none;padding:8px 14px;background:white;border:1px solid #e2e8f0;border-radius:10px;"
           onmouseover="this.style.background='#f8fafc'"
           onmouseout="this.style.background='white'">
            <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Pengumuman
        </a>
    </div>

    {{-- CARD UTAMA --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">

        {{-- HEADER GRADIENT --}}
        <div style="padding:28px 32px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
                @if($pengumuman->is_pinned)
                <span style="font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(251,191,36,0.2);color:#fbbf24;">
                    <svg style="width:11px;height:11px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>Disematkan
                </span>
                @endif
                <span style="font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(255,255,255,0.15);color:white;">
                    {{ $pengumuman->kategoriLabel() }}
                </span>
                @if($pengumuman->published_at >= now()->subDays(3))
                <span style="font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(74,222,128,0.2);color:#4ade80;">
                    <svg style="width:11px;height:11px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#4ade80" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>Baru
                </span>
                @endif
            </div>

            <h1 style="font-size:1.4rem;font-weight:900;color:white;margin:0 0 16px;line-height:1.4;">
                {{ $pengumuman->judul }}
            </h1>

            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                <span style="font-size:0.78rem;color:rgba(255,255,255,0.8);display:flex;align-items:center;gap:5px;">
                    <svg style="width:14px;height:14px;display:inline;vertical-align:middle;margin-right:4px;" fill="none" stroke="rgba(255,255,255,0.8)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ $pengumuman->published_at->translatedFormat('d F Y, H:i') }}
                </span>
                @if($pengumuman->guruBk)
                <span style="font-size:0.78rem;color:rgba(255,255,255,0.8);display:flex;align-items:center;gap:5px;">
                    <svg style="width:14px;height:14px;display:inline;vertical-align:middle;margin-right:4px;" fill="none" stroke="rgba(255,255,255,0.8)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>{{ $pengumuman->guruBk->name }}
                </span>
                @endif
                @if($pengumuman->target)
                <span style="font-size:0.78rem;color:rgba(255,255,255,0.8);display:flex;align-items:center;gap:5px;">
                    <svg style="width:14px;height:14px;display:inline;vertical-align:middle;margin-right:4px;" fill="none" stroke="rgba(255,255,255,0.8)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ $pengumuman->target }}
                </span>
                @endif
            </div>
        </div>

        {{-- ISI KONTEN --}}
        <div style="padding:32px;">
            <div style="font-size:0.92rem;color:#334155;line-height:1.8;white-space:pre-wrap;">{{ $pengumuman->isi }}</div>
        </div>

        {{-- FOOTER --}}
        <div style="padding:16px 32px;border-top:1px solid #f1f5f9;background:#f8fafc;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <span style="font-size:0.75rem;color:#94a3b8;">
                Dipublikasikan {{ $pengumuman->published_at->diffForHumans() }}
            </span>
            <a href="{{ route('siswa.pengumuman.index') }}"
               style="font-size:0.82rem;font-weight:700;color:#1e3a5f;text-decoration:none;display:flex;align-items:center;gap:4px;">
                ← Kembali ke daftar pengumuman
            </a>
        </div>
    </div>

</div>
@endsection