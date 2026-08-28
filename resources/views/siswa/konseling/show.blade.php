@extends('layouts.siswa')
@section('title', 'Detail Konseling')
@section('page-title', 'Detail Konseling')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- BACK + HEADER --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
        <a href="{{ route('siswa.konseling.index') }}"
           style="width:36px;height:36px;border-radius:10px;background:white;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
            <svg style="width:18px;height:18px;" fill="none" stroke="#475569" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 style="font-size:1.25rem;font-weight:800;color:#0f172a;margin:0;">Detail Konseling</h1>
            <p style="font-size:0.8rem;color:#64748b;margin:3px 0 0;">{{ $konseling->kategori ?? 'Konseling Umum' }}</p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;">

        {{-- KIRI: Info Utama --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- Card Info Konseling --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
                <div style="background:linear-gradient(135deg,#1e3a5f,#6b1d1d);padding:20px 24px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <div style="font-size:0.75rem;color:rgba(255,255,255,0.7);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Kategori</div>
                            <div style="font-size:1.1rem;font-weight:800;color:white;margin-top:4px;">{{ $konseling->kategori ?? 'Konseling Umum' }}</div>
                        </div>
                        <span style="background:rgba(255,255,255,0.15);color:white;font-size:0.78rem;font-weight:700;padding:6px 14px;border-radius:20px;">
                            {{ ucfirst($konseling->status ?? '-') }}
                        </span>
                    </div>
                </div>
                <div style="padding:20px 24px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                        <div>
                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">Tanggal</div>
                            <div style="font-size:0.88rem;font-weight:700;color:#0f172a;">{{ \Carbon\Carbon::parse($konseling->created_at)->translatedFormat('d F Y') }}</div>
                        </div>
                        <div>
                            <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">Guru BK</div>
                            <div style="font-size:0.88rem;font-weight:700;color:#0f172a;">{{ $konseling->guruBk->name ?? '-' }}</div>
                        </div>
                    </div>
                    @if($konseling->catatan)
                    <div>
                        <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Catatan Konseling</div>
                        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;font-size:0.85rem;color:#374151;line-height:1.6;border-left:3px solid #1e3a5f;">
                            {{ $konseling->catatan }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sesi Konseling --}}
            @if($konseling->sesi && $konseling->sesi->count() > 0)
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px 24px;">
                <div style="font-size:0.9rem;font-weight:700;color:#0f172a;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <div style="width:28px;height:28px;border-radius:8px;background:#ede9fe;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:15px;height:15px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    Riwayat Sesi
                </div>
                @foreach($konseling->sesi as $i => $sesi)
                <div style="display:flex;gap:14px;margin-bottom:16px;">
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);color:white;font-size:0.75rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $i+1 }}</div>
                        @if(!$loop->last)<div style="width:2px;background:#e2e8f0;flex:1;margin:4px 0;"></div>@endif
                    </div>
                    <div style="flex:1;background:#f8fafc;border-radius:10px;padding:12px 14px;margin-bottom:{{ $loop->last ? '0' : '4px' }};">
                        <div style="font-size:0.8rem;font-weight:700;color:#0f172a;">Sesi {{ $i+1 }}</div>
                        <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">{{ \Carbon\Carbon::parse($sesi->created_at)->translatedFormat('d F Y, H:i') }}</div>
                        @if($sesi->catatan)
                        <div style="font-size:0.82rem;color:#374151;margin-top:8px;line-height:1.5;">{{ $sesi->catatan }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- KANAN: Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- Info Siswa --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
                <div style="font-size:0.82rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:14px;">Informasi Kamu</div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                    <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);display:flex;align-items:center;justify-content:center;color:white;font-size:1rem;font-weight:800;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:0.9rem;font-weight:700;color:#0f172a;">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.78rem;color:#64748b;">{{ Auth::user()->kelas->nama_kelas ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
                <div style="font-size:0.82rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:14px;">Aksi</div>
                <a href="{{ route('siswa.chat.index') }}"
                   style="display:flex;align-items:center;gap:10px;background:#eff6ff;border-radius:10px;padding:12px 14px;text-decoration:none;margin-bottom:10px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:#2563eb;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:16px;height:16px;" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:700;color:#1d4ed8;">Chat Guru BK</div>
                        <div style="font-size:0.72rem;color:#64748b;">Tanya langsung ke guru BK</div>
                    </div>
                </a>
                <a href="{{ route('siswa.konseling.pengajuan') }}"
                   style="display:flex;align-items:center;gap:10px;background:#f0fdf4;border-radius:10px;padding:12px 14px;text-decoration:none;">
                    <div style="width:32px;height:32px;border-radius:8px;background:#16a34a;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:16px;height:16px;" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:700;color:#15803d;">Ajukan Konseling Baru</div>
                        <div style="font-size:0.72rem;color:#64748b;">Buat pengajuan konseling</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection