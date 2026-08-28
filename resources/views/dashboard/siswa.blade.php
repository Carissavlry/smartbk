@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')

@section('content')
@php
    $poinWarning = $totalPoin >= 75;
    $poinDanger  = $totalPoin >= 100;
@endphp

{{-- ===== HERO BANNER ===== --}}
<div style="background:linear-gradient(135deg,#021024 0%,#052659 60%,#3A000C 100%);border-radius:20px;padding:28px 32px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="width:46px;height:46px;border-radius:14px;background:rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg style="width:24px;height:24px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <div style="color:white;font-size:1.2rem;font-weight:700;margin-bottom:3px;">
                <span style="display:inline-flex;align-items:center;gap:8px;">
                    Halo, {{ explode(' ', $user->name)[0] }}!
                    <svg style="width:22px;height:22px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg>
                </span>
            </div>
            <div style="color:#93c5fd;font-size:0.83rem;">
                Kelas {{ $user->kelas->nama ?? '-' }} &mdash; Pantau perkembangan & aktivitas BK kamu di sini.
            </div>
        </div>
    </div>
    <div style="text-align:right;">
        <div style="background:rgba(255,255,255,0.12);color:white;font-size:0.82rem;font-weight:600;padding:8px 18px;border-radius:12px;margin-bottom:6px;display:flex;align-items:center;gap:8px;justify-content:flex-end;">
            <svg style="width:15px;height:15px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
        <div style="color:#bfdbfe;font-size:0.75rem;">
            Status Poin: <strong style="color:{{ $poinDanger ? '#fca5a5' : ($poinWarning ? '#fde68a' : '#86efac') }};">
                <span style="display:inline-flex;align-items:center;gap:5px;">
                @if($poinDanger)
                    <svg style="width:14px;height:14px;" fill="none" stroke="#fca5a5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg> Kritis
                @elseif($poinWarning)
                    <svg style="width:14px;height:14px;" fill="none" stroke="#fde68a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg> Perhatian
                @else
                    <svg style="width:14px;height:14px;" fill="none" stroke="#86efac" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Aman
                @endif
            </span>
            </strong>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px;">

    {{-- Konseling --}}
    <div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ede9fe;display:flex;align-items:center;justify-content:center;">
                <svg style="width:22px;height:22px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <span style="font-size:0.7rem;font-weight:700;color:#7c3aed;background:#ede9fe;padding:3px 10px;border-radius:20px;">Konseling</span>
        </div>
        <div style="font-size:2rem;font-weight:800;color:#0f172a;line-height:1;">{{ $totalKonseling }}</div>
        <div style="font-size:0.78rem;color:#94a3b8;margin-top:4px;">Total Sesi Konseling</div>
    </div>

    {{-- Poin Pelanggaran --}}
    <div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:{{ $poinDanger ? '#fee2e2' : ($poinWarning ? '#fef9c3' : '#f0fdf4') }};display:flex;align-items:center;justify-content:center;">
                <svg style="width:22px;height:22px;" fill="none" stroke="{{ $poinDanger ? '#dc2626' : ($poinWarning ? '#ca8a04' : '#16a34a') }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
            </div>
            <span style="font-size:0.7rem;font-weight:700;color:{{ $poinDanger ? '#dc2626' : ($poinWarning ? '#ca8a04' : '#16a34a') }};background:{{ $poinDanger ? '#fee2e2' : ($poinWarning ? '#fef9c3' : '#f0fdf4') }};padding:3px 10px;border-radius:20px;">
                {{ $poinDanger ? 'Kritis' : ($poinWarning ? 'Perhatian' : 'Aman') }}
            </span>
        </div>
        <div style="font-size:2rem;font-weight:800;color:#0f172a;line-height:1;">{{ $totalPoin }}</div>
        <div style="font-size:0.78rem;color:#94a3b8;margin-top:4px;">Akumulasi Poin Pelanggaran</div>
    </div>

    {{-- Prestasi --}}
    <div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#fef9c3;display:flex;align-items:center;justify-content:center;">
                <svg style="width:22px;height:22px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <span style="font-size:0.7rem;font-weight:700;color:#ca8a04;background:#fef9c3;padding:3px 10px;border-radius:20px;">Prestasi</span>
        </div>
        <div style="font-size:2rem;font-weight:800;color:#0f172a;line-height:1;">{{ $totalPrestasi }}</div>
        <div style="font-size:0.78rem;color:#94a3b8;margin-top:4px;">Total Prestasi Tercatat</div>
    </div>

    {{-- Notifikasi --}}
    <div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                <svg style="width:22px;height:22px;" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
            </div>
            <span style="font-size:0.7rem;font-weight:700;color:#2563eb;background:#eff6ff;padding:3px 10px;border-radius:20px;">Notifikasi</span>
        </div>
        <div style="font-size:2rem;font-weight:800;color:#0f172a;line-height:1;">{{ $notifBelumDibaca }}</div>
        <div style="font-size:0.78rem;color:#94a3b8;margin-top:4px;">Notifikasi Belum Dibaca</div>
    </div>

</div>

{{-- ===== ROW 2: JADWAL + PENGUMUMAN ===== --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    {{-- Jadwal Konseling Mendatang --}}
    <div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:28px;height:28px;border-radius:8px;background:#ede9fe;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:15px;height:15px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span style="font-size:0.85rem;font-weight:700;color:#374151;">Jadwal Konseling Mendatang</span>
            </div>
            <a href="{{ route('siswa.konseling.pengajuan') }}" style="font-size:0.75rem;color:#7c3aed;text-decoration:none;font-weight:600;">+ Ajukan &rarr;</a>
        </div>
        @forelse($jadwalMendatang as $jadwal)
        <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid #f8fafc;">
            <div style="width:40px;height:40px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div style="flex:1;">
                <div style="font-size:0.83rem;font-weight:600;color:#0f172a;">{{ $jadwal->topik ?? 'Konseling' }}</div>
                <div style="font-size:0.75rem;color:#94a3b8;">{{ \Carbon\Carbon::parse($jadwal->tanggal_diajukan)->translatedFormat('d F Y') }} &bull; {{ $jadwal->jam_diajukan ?? '' }}</div>
            </div>
            <span style="font-size:0.7rem;font-weight:600;padding:3px 10px;border-radius:20px;background:#ede9fe;color:#7c3aed;">Disetujui</span>
        </div>
        @empty
        <div style="text-align:center;padding:28px 0;color:#94a3b8;">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:36px;height:36px;margin:0 auto 8px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p style="font-size:0.82rem;">Tidak ada jadwal konseling mendatang</p>
        </div>
        @endforelse
    </div>

    {{-- Pengumuman BK --}}
    <div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:28px;height:28px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:15px;height:15px;" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <span style="font-size:0.85rem;font-weight:700;color:#374151;">Pengumuman BK</span>
            </div>
            <a href="{{ route('siswa.pengumuman.index') }}" style="font-size:0.75rem;color:#2563eb;text-decoration:none;font-weight:600;">Lihat Semua &rarr;</a>
        </div>
        @forelse($pengumuman as $p)
        <div style="display:flex;align-items:flex-start;gap:10px;padding:10px 0;border-bottom:1px solid #f8fafc;">
            @if($p->is_pinned)
            <div style="width:30px;height:30px;border-radius:50%;background:#fef9c3;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                <svg style="width:14px;height:14px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            </div>
            @else
            <div style="width:30px;height:30px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                <svg style="width:14px;height:14px;" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            @endif
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.82rem;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->judul }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ \Carbon\Carbon::parse($p->published_at)->diffForHumans() }}</div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:28px 0;color:#94a3b8;font-size:0.82rem;">Belum ada pengumuman</div>
        @endforelse
    </div>

</div>

{{-- ===== ROW 3: RIWAYAT KONSELING + PELANGGARAN ===== --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    {{-- Riwayat Konseling --}}
    <div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:28px;height:28px;border-radius:8px;background:#ede9fe;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:15px;height:15px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <span style="font-size:0.85rem;font-weight:700;color:#374151;">Riwayat Konseling</span>
            </div>
            <a href="{{ route('siswa.konseling.index') }}" style="font-size:0.75rem;color:#7c3aed;text-decoration:none;font-weight:600;">Lihat Semua &rarr;</a>
        </div>
        @forelse($konselings as $k)
        <div style="display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #f8fafc;">
            <div style="width:30px;height:30px;border-radius:50%;background:{{ $k->status === 'selesai' ? '#dcfce7' : ($k->status === 'aktif' ? '#ede9fe' : '#fef9c3') }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:14px;height:14px;" fill="none" stroke="{{ $k->status === 'selesai' ? '#16a34a' : ($k->status === 'aktif' ? '#7c3aed' : '#ca8a04') }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.82rem;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $k->kategori ?? 'Konseling Umum' }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;">{{ \Carbon\Carbon::parse($k->created_at)->translatedFormat('d F Y') }}</div>
            </div>
            <span style="font-size:0.7rem;font-weight:600;padding:2px 9px;border-radius:20px;flex-shrink:0;
                background:{{ $k->status === 'selesai' ? '#dcfce7' : ($k->status === 'aktif' ? '#ede9fe' : '#fef9c3') }};
                color:{{ $k->status === 'selesai' ? '#166534' : ($k->status === 'aktif' ? '#6d28d9' : '#92400e') }};">
                {{ ucfirst($k->status ?? '-') }}
            </span>
        </div>
        @empty
        <div style="text-align:center;padding:24px 0;color:#94a3b8;font-size:0.82rem;">Belum ada riwayat konseling</div>
        @endforelse
    </div>

    {{-- Pelanggaran Terbaru --}}
    <div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:28px;height:28px;border-radius:8px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:15px;height:15px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                </div>
                <span style="font-size:0.85rem;font-weight:700;color:#374151;">Pelanggaran Terbaru</span>
            </div>
            <a href="{{ route('siswa.pelanggaran.index') }}" style="font-size:0.75rem;color:#dc2626;text-decoration:none;font-weight:600;">Lihat Semua &rarr;</a>
        </div>
        @forelse($pelanggaranTerbaru as $pl)
        <div style="display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #f8fafc;">
            <div style="width:34px;height:34px;border-radius:8px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.82rem;font-weight:800;color:#dc2626;">{{ $pl->poin ?? 0 }}</div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.82rem;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $pl->jenisPelanggaran->nama ?? '-' }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;">{{ \Carbon\Carbon::parse($pl->tanggal)->translatedFormat('d F Y') }}</div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:24px 0;color:#94a3b8;">
            <svg fill="none" stroke="#16a34a" stroke-width="1.5" viewBox="0 0 24 24" style="width:32px;height:32px;margin:0 auto 6px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span style="font-size:0.82rem;">Tidak ada pelanggaran tercatat</span>
        </div>
        @endforelse
    </div>

</div>

{{-- ===== AKSES CEPAT ===== --}}
<div style="background:white;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px;">
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
        <div style="width:28px;height:28px;border-radius:8px;background:#fef9c3;display:flex;align-items:center;justify-content:center;">
            <svg style="width:15px;height:15px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <span style="font-size:0.85rem;font-weight:700;color:#374151;">Akses Cepat</span>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
        <a href="{{ route('siswa.konseling.pengajuan') }}" style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 12px;background:#ede9fe;border-radius:14px;text-decoration:none;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
            <div style="width:42px;height:42px;border-radius:12px;background:#7c3aed;display:flex;align-items:center;justify-content:center;">
                <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            </div>
            <span style="font-size:0.78rem;font-weight:700;color:#6d28d9;text-align:center;">Ajukan Konseling</span>
        </a>
        <a href="{{ route('siswa.chat.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 12px;background:#eff6ff;border-radius:14px;text-decoration:none;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
            <div style="width:42px;height:42px;border-radius:12px;background:#2563eb;display:flex;align-items:center;justify-content:center;">
                <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <span style="font-size:0.78rem;font-weight:700;color:#1d4ed8;text-align:center;">Chat Guru BK</span>
        </a>
        <a href="{{ route('siswa.pelanggaran.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 12px;background:#fff1f2;border-radius:14px;text-decoration:none;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
            <div style="width:42px;height:42px;border-radius:12px;background:#dc2626;display:flex;align-items:center;justify-content:center;">
                <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
            </div>
            <span style="font-size:0.78rem;font-weight:700;color:#b91c1c;text-align:center;">Cek Pelanggaran</span>
        </a>
        <a href="{{ route('siswa.pengumuman.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 12px;background:#f0fdf4;border-radius:14px;text-decoration:none;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
            <div style="width:42px;height:42px;border-radius:12px;background:#16a34a;display:flex;align-items:center;justify-content:center;">
                <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            <span style="font-size:0.78rem;font-weight:700;color:#15803d;text-align:center;">Pengumuman BK</span>
        </a>
    </div>
</div>

@endsection