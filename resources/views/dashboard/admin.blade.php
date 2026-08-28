@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

<div style="background: linear-gradient(135deg, #021024 0%, #052659 60%, #3A000C 100%); border-radius:20px; padding:28px 32px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div style="display:flex; align-items:center; gap:14px;">
        <div style="width:46px; height:46px; border-radius:14px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg style="width:24px;height:24px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </div>
        <div>
            <div style="color:white; font-size:1.2rem; font-weight:700; margin-bottom:3px;">Selamat Datang, Admin Sekolah!</div>
            <div style="color:#93c5fd; font-size:0.83rem;">Kelola data sekolah dan pantau seluruh aktivitas BK di sini.</div>
        </div>
    </div>
    <div style="text-align:right;">
        <div style="background:rgba(255,255,255,0.12); color:white; font-size:0.82rem; font-weight:600; padding:8px 18px; border-radius:12px; margin-bottom:6px; display:flex; align-items:center; gap:8px; justify-content:flex-end;">
            <svg style="width:15px;height:15px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
        @if($tahunAjaran)
        <div style="color:#bfdbfe; font-size:0.75rem;">
            Tahun Ajaran Aktif: <strong style="color:white;">{{ $tahunAjaran->nama }}</strong>
        </div>
        @endif
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:20px;">
    <div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:#eff6ff; display:flex; align-items:center; justify-content:center;">
                <svg style="width:22px;height:22px;" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <span style="font-size:0.7rem; font-weight:700; color:#2563eb; background:#eff6ff; padding:3px 10px; border-radius:20px;">Siswa</span>
        </div>
        <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">{{ $totalSiswa }}</div>
        <div style="font-size:0.78rem; color:#94a3b8; margin-top:4px;">Total Siswa Terdaftar</div>
    </div>
    <div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:#faf5ff; display:flex; align-items:center; justify-content:center;">
                <svg style="width:22px;height:22px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span style="font-size:0.7rem; font-weight:700; color:#7c3aed; background:#faf5ff; padding:3px 10px; border-radius:20px;">Guru BK</span>
        </div>
        <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">{{ $totalGuru }}</div>
        <div style="font-size:0.78rem; color:#94a3b8; margin-top:4px;">Total Guru BK Aktif</div>
    </div>
    <div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:#f0fdf4; display:flex; align-items:center; justify-content:center;">
                <svg style="width:22px;height:22px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <span style="font-size:0.7rem; font-weight:700; color:#16a34a; background:#f0fdf4; padding:3px 10px; border-radius:20px;">Kelas</span>
        </div>
        <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">{{ $totalKelas }}</div>
        <div style="font-size:0.78rem; color:#94a3b8; margin-top:4px;">Total Kelas Aktif</div>
    </div>
    <div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:#fff7ed; display:flex; align-items:center; justify-content:center;">
                <svg style="width:22px;height:22px;" fill="none" stroke="#ea580c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
            <span style="font-size:0.7rem; font-weight:700; color:#ea580c; background:#fff7ed; padding:3px 10px; border-radius:20px;">Mutasi</span>
        </div>
        <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">{{ $totalMutasi }}</div>
        <div style="font-size:0.78rem; color:#94a3b8; margin-top:4px;">Total Mutasi Siswa</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:20px;">
    <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:16px; padding:16px; display:flex; align-items:center; gap:14px;">
        <div style="width:42px; height:42px; border-radius:12px; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg style="width:20px;height:20px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg>
        </div>
        <div>
            <div style="font-size:1.6rem; font-weight:800; color:#15803d; line-height:1;">{{ $mutasiMasuk }}</div>
            <div style="font-size:0.75rem; color:#16a34a; font-weight:600; margin-top:2px;">Mutasi Masuk</div>
        </div>
    </div>
    <div style="background:#fff1f2; border:1px solid #fecdd3; border-radius:16px; padding:16px; display:flex; align-items:center; gap:14px;">
        <div style="width:42px; height:42px; border-radius:12px; background:#ffe4e6; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg style="width:20px;height:20px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </div>
        <div>
            <div style="font-size:1.6rem; font-weight:800; color:#b91c1c; line-height:1;">{{ $mutasiKeluar }}</div>
            <div style="font-size:0.75rem; color:#dc2626; font-weight:600; margin-top:2px;">Mutasi Keluar</div>
        </div>
    </div>
    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:16px; padding:16px; display:flex; align-items:center; gap:14px;">
        <div style="width:42px; height:42px; border-radius:12px; background:#dbeafe; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg style="width:20px;height:20px;" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
        </div>
        <div>
            <div style="font-size:1.6rem; font-weight:800; color:#1d4ed8; line-height:1;">{{ $mutasiInternal }}</div>
            <div style="font-size:0.75rem; color:#2563eb; font-weight:600; margin-top:2px;">Mutasi Internal</div>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
    <div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
            <div style="width:28px; height:28px; border-radius:8px; background:#eff6ff; display:flex; align-items:center; justify-content:center;">
                <svg style="width:15px;height:15px;" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <span style="font-size:0.85rem; font-weight:700; color:#374151;">Distribusi Siswa per Kelas</span>
        </div>
        @forelse($siswaPerKelas as $kelas)
        @php $persen = $totalSiswa > 0 ? ($kelas->siswas_count / $totalSiswa) * 100 : 0; @endphp
        <div style="margin-bottom:14px;">
            <div style="display:flex; justify-content:space-between; font-size:0.78rem; margin-bottom:5px;">
                <span style="color:#374151; font-weight:500;">{{ $kelas->nama }}</span>
                <span style="color:#0f172a; font-weight:700;">{{ $kelas->siswas_count }} siswa</span>
            </div>
            <div style="background:#f1f5f9; border-radius:99px; height:7px; overflow:hidden;">
                <div style="background:linear-gradient(90deg,#052659,#3A000C); height:100%; border-radius:99px; width:{{ $persen }}%;"></div>
            </div>
        </div>
        @empty
        <div style="text-align:center; color:#94a3b8; font-size:0.82rem; padding:20px 0;">Belum ada data kelas.</div>
        @endforelse
    </div>
    <div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:8px; background:#f0fdf4; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:15px;height:15px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <span style="font-size:0.85rem; font-weight:700; color:#374151;">Siswa Terbaru Didaftarkan</span>
            </div>
            <a href="{{ route('admin.siswa.index') }}" style="font-size:0.75rem; color:#2563eb; text-decoration:none; font-weight:600;">Lihat Semua &rarr;</a>
        </div>
        @forelse($siswaTerbaru as $siswa)
        <div style="display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f8fafc;">
            <div style="width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#052659,#3A000C); display:flex; align-items:center; justify-content:center; color:white; font-size:0.78rem; font-weight:700; flex-shrink:0;">
                {{ strtoupper(substr($siswa->name,0,1)) }}
            </div>
            <div style="flex:1; min-width:0;">
                <div style="font-size:0.82rem; font-weight:600; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $siswa->name }}</div>
                <div style="font-size:0.72rem; color:#94a3b8;">{{ $siswa->nis }} &bull; {{ $siswa->kelas->nama ?? '-' }}</div>
            </div>
            <div style="font-size:0.7rem; color:#94a3b8; flex-shrink:0;">{{ $siswa->created_at->diffForHumans() }}</div>
        </div>
        @empty
        <div style="text-align:center; color:#94a3b8; font-size:0.82rem; padding:20px 0;">Belum ada siswa terdaftar.</div>
        @endforelse
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
    <div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:8px; background:#fff7ed; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:15px;height:15px;" fill="none" stroke="#ea580c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <span style="font-size:0.85rem; font-weight:700; color:#374151;">Mutasi Terbaru</span>
            </div>
            <a href="{{ route('admin.mutasi-siswa.index') }}" style="font-size:0.75rem; color:#2563eb; text-decoration:none; font-weight:600;">Lihat Semua &rarr;</a>
        </div>
        @forelse($mutasiTerbaru as $mutasi)
        <div style="display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f8fafc;">
            @if($mutasi->jenis_mutasi === 'masuk')
                <div style="width:30px; height:30px; border-radius:50%; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg>
                </div>
            @elseif($mutasi->jenis_mutasi === 'keluar')
                <div style="width:30px; height:30px; border-radius:50%; background:#ffe4e6; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </div>
            @else
                <div style="width:30px; height:30px; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
            @endif
            <div style="flex:1; min-width:0;">
                <div style="font-size:0.82rem; font-weight:600; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $mutasi->siswa->name ?? '-' }}</div>
                <div style="font-size:0.72rem; color:#94a3b8; text-transform:capitalize;">{{ $mutasi->jenis_mutasi }} &bull; {{ $mutasi->tanggal_mutasi?->format('d M Y') }}</div>
            </div>
        </div>
        @empty
        <div style="text-align:center; color:#94a3b8; font-size:0.82rem; padding:20px 0;">Belum ada data mutasi.</div>
        @endforelse
    </div>
    <div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:8px; background:#faf5ff; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:15px;height:15px;" fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span style="font-size:0.85rem; font-weight:700; color:#374151;">Aktivitas Terbaru</span>
            </div>
            <a href="{{ route('admin.activity-log.index') }}" style="font-size:0.75rem; color:#2563eb; text-decoration:none; font-weight:600;">Lihat Semua &rarr;</a>
        </div>
        @forelse($logTerbaru as $log)
        <div style="display:flex; align-items:flex-start; gap:10px; padding:8px 0; border-bottom:1px solid #f8fafc;">
            <div style="width:30px; height:30px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px;">
                <svg style="width:13px;height:13px;" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div style="flex:1; min-width:0;">
                <div style="font-size:0.78rem; color:#374151; line-height:1.4;">{{ $log->description }}</div>
                <div style="font-size:0.7rem; color:#94a3b8; margin-top:2px;">{{ $log->user_name ?? 'System' }} &bull; {{ $log->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @empty
        <div style="text-align:center; color:#94a3b8; font-size:0.82rem; padding:20px 0;">Belum ada aktivitas tercatat.</div>
        @endforelse
    </div>
</div>

<div style="background:white; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:20px;">
    <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
        <div style="width:28px; height:28px; border-radius:8px; background:#fef9c3; display:flex; align-items:center; justify-content:center;">
            <svg style="width:15px;height:15px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <span style="font-size:0.85rem; font-weight:700; color:#374151;">Akses Cepat</span>
    </div>
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px;">
        <a href="{{ route('admin.siswa.create') }}" style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px 12px; background:#eff6ff; border-radius:14px; text-decoration:none;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
            <div style="width:42px; height:42px; border-radius:12px; background:#2563eb; display:flex; align-items:center; justify-content:center;">
                <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <span style="font-size:0.78rem; font-weight:700; color:#1d4ed8; text-align:center;">Tambah Siswa</span>
        </a>
        <a href="{{ route('admin.guru-bk.create') }}" style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px 12px; background:#faf5ff; border-radius:14px; text-decoration:none;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
            <div style="width:42px; height:42px; border-radius:12px; background:#7c3aed; display:flex; align-items:center; justify-content:center;">
                <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span style="font-size:0.78rem; font-weight:700; color:#6d28d9; text-align:center;">Tambah Guru BK</span>
        </a>
        <a href="{{ route('admin.kelas.index') }}" style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px 12px; background:#f0fdf4; border-radius:14px; text-decoration:none;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
            <div style="width:42px; height:42px; border-radius:12px; background:#16a34a; display:flex; align-items:center; justify-content:center;">
                <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <span style="font-size:0.78rem; font-weight:700; color:#15803d; text-align:center;">Kelola Kelas</span>
        </a>
        <a href="{{ route('admin.tahun-ajaran.index') }}" style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px 12px; background:#fff7ed; border-radius:14px; text-decoration:none;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
            <div style="width:42px; height:42px; border-radius:12px; background:#ea580c; display:flex; align-items:center; justify-content:center;">
                <svg style="width:20px;height:20px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <span style="font-size:0.78rem; font-weight:700; color:#c2410c; text-align:center;">Tahun Ajaran</span>
        </a>
    </div>
</div>

@endsection