@extends('layouts.guru')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Guru BK')

@section('content')
<style>
    /* WELCOME */
    .welcome-banner {
        background:linear-gradient(135deg, var(--navy-darkest) 0%, var(--navy-dark) 60%, #1a3a6e 100%);
        border-radius:16px; padding:22px 28px; margin-bottom:20px;
        display:flex; align-items:center; justify-content:space-between;
        position:relative; overflow:hidden;
    }
    .welcome-banner::before { content:''; position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:rgba(117,22,46,0.25); }
    .welcome-banner::after  { content:''; position:absolute; bottom:-20px; right:100px; width:90px; height:90px; border-radius:50%; background:rgba(84,131,179,0.15); }
    .welcome-text { position:relative; z-index:2; }
    .welcome-greeting { color:rgba(193,232,255,0.75); font-size:0.78rem; font-weight:500; }
    .welcome-name { color:white; font-size:1.15rem; font-weight:800; margin-top:2px; }
    .welcome-sub { color:rgba(193,232,255,0.55); font-size:0.73rem; margin-top:3px; }
    .welcome-date { position:relative; z-index:2; text-align:right; color:rgba(255,255,255,0.7); font-size:0.78rem; }

    /* STAT CARDS */
    .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px; }
    .stat-card { background:white; border-radius:14px; padding:18px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); display:flex; align-items:center; gap:14px; }
    .stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .stat-icon svg { width:20px; height:20px; }
    .stat-icon.blue   { background:#eff6ff; color:#1d4ed8; }
    .stat-icon.green  { background:#f0fdf4; color:#15803d; }
    .stat-icon.yellow { background:#fffbeb; color:#d97706; }
    .stat-icon.maroon { background:#fff1f2; color:#9B1B37; }
    .stat-value { font-size:1.6rem; font-weight:800; color:var(--navy-darkest); line-height:1; }
    .stat-label { font-size:0.73rem; color:#64748b; margin-top:3px; font-weight:500; }

    /* ALERT SECTION */
    .alert-section { margin-bottom:20px; }
    .alert-card { background:white; border-radius:14px; border:1px solid #fecaca; box-shadow:0 1px 4px rgba(220,38,38,0.08); overflow:hidden; }
    .alert-header { padding:14px 20px; background:#fef2f2; border-bottom:1px solid #fecaca; display:flex; align-items:center; justify-content:space-between; }
    .alert-title { font-size:0.85rem; font-weight:700; color:#dc2626; display:flex; align-items:center; gap:8px; }
    .alert-body { padding:0; }

    /* MAIN GRID */
    .main-grid { display:grid; grid-template-columns:1.2fr 0.8fr; gap:16px; margin-bottom:16px; }

    /* CARD */
    .card { background:white; border-radius:14px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); overflow:hidden; }
    .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
    .card-title { font-size:0.85rem; font-weight:700; color:var(--navy-darkest); }
    .card-body { padding:18px; }

    /* TABLE */
    table { width:100%; border-collapse:collapse; }
    th { font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; padding:10px 14px; text-align:left; border-bottom:1px solid #f1f5f9; white-space:nowrap; background:#fafbfc; }
    td { font-size:0.82rem; color:#1e293b; padding:11px 14px; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#fafbff; }

    /* BADGE */
    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:0.7rem; font-weight:600; }
    .badge-baru    { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .badge-proses  { background:#fffbeb; color:#d97706; border:1px solid #fcd34d; }
    .badge-selesai { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }

    /* STATUS GRID */
    .status-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
    .status-item { text-align:center; padding:14px 8px; border-radius:12px; border:1px solid #e8edf5; }
    .status-num { font-size:1.5rem; font-weight:800; }
    .status-lbl { font-size:0.7rem; color:#64748b; margin-top:3px; font-weight:500; }

    /* KATEGORI */
    .kat-item { display:flex; flex-direction:column; gap:4px; margin-bottom:10px; }
    .kat-header { display:flex; justify-content:space-between; font-size:0.78rem; font-weight:600; color:#374151; }
    .kat-count { color:#64748b; }
    .progress-bar { height:7px; background:#f1f5f9; border-radius:99px; overflow:hidden; }
    .progress-fill { height:100%; border-radius:99px; }
    .fill-pribadi  { background:linear-gradient(90deg,#3b82f6,#1d4ed8); }
    .fill-sosial   { background:linear-gradient(90deg,#10b981,#059669); }
    .fill-belajar  { background:linear-gradient(90deg,#f59e0b,#d97706); }
    .fill-karir    { background:linear-gradient(90deg,#8b5cf6,#7c3aed); }
    .fill-keluarga { background:linear-gradient(90deg,#ef4444,#dc2626); }

    /* BTN */
    .btn-sm { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:8px; font-size:0.75rem; font-weight:600; text-decoration:none; }
    .btn-primary { background:var(--navy-dark); color:white; }
    .btn-primary:hover { background:var(--navy-darkest); color:white; }
    .btn-danger  { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }

    .empty-state { text-align:center; padding:28px 20px; color:#94a3b8; font-size:0.82rem; }
    .empty-state svg { width:36px; height:36px; margin:0 auto 8px; opacity:0.35; display:block; }

    @media(max-width:900px) {
        .stats-grid { grid-template-columns:repeat(2,1fr); }
        .main-grid  { grid-template-columns:1fr; }
    }
</style>

{{-- Welcome Banner --}}
<div class="welcome-banner">
    <div class="welcome-text">
        <div class="welcome-greeting">Selamat datang kembali,</div>
        <div class="welcome-name">{{ $guruBk->name }}</div>
        <div class="welcome-sub">Guru Bimbingan & Konseling — SmartBK</div>
    </div>
    <div class="welcome-date">
        <div style="font-size:1rem;font-weight:700;color:white;">{{ now()->translatedFormat('d F Y') }}</div>
        <div style="margin-top:2px;">{{ now()->translatedFormat('l') }}</div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
        </div>
        <div><div class="stat-value">{{ $siswaBinaan }}</div><div class="stat-label">Siswa Binaan</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon maroon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        </div>
        <div><div class="stat-value">{{ $konselingBulanIni }}</div><div class="stat-label">Konseling Bulan Ini</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div><div class="stat-value">{{ $konselingSelesai }}</div><div class="stat-label">Konseling Selesai</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div><div class="stat-value">{{ $totalKonseling }}</div><div class="stat-label">Total Konseling</div></div>
    </div>
</div>

{{-- ALERT THRESHOLD --}}
@if($siswaThreshold->count() > 0)
<div class="alert-section">
    <div class="alert-card">
        <div class="alert-header">
            <div class="alert-title">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                Alert Pelanggaran — {{ $siswaThreshold->count() }} Siswa Melewati Batas Poin
            </div>
            <a href="{{ route('guru-bk.pelanggaran.index') }}" class="btn-sm btn-danger">Lihat Semua</a>
        </div>
        <div class="alert-body">
            <table>
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Total Poin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaThreshold as $item)
                    @php
                        $level = $item['level'];
                        $styles = [
                            'kuning' => 'background:#fefce8;color:#a16207;border:1px solid #fde047;',
                            'merah'  => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                            'hitam'  => 'background:#1e1e2e;color:#f8fafc;border:1px solid #374151;',
                        ];
                        $labels = ['kuning'=>'Peringatan','merah'=>'Tindakan','hitam'=>'Kritis'];
                        $svgs = [
                            'kuning' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>',
                            'merah'  => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374L10.051 3.378c.866-1.5 3.032-1.5 3.898 0l7.354 12.748z"/></svg>',
                            'hitam'  => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                        ];
                    @endphp
                    <tr>
                        <td>
                            <div style="font-weight:600;">{{ $item['siswa']->name }}</div>
                            <div style="font-size:0.72rem;color:#94a3b8;">{{ $item['siswa']->nis }}</div>
                        </td>
                        <td style="color:#475569;">{{ $item['siswa']->kelas->nama ?? '-' }}</td>
                        <td><span style="font-weight:800;color:#dc2626;">{{ $item['total_poin'] }} poin</span></td>
                        <td>
                            <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 10px;border-radius:20px;font-size:0.7rem;font-weight:700;{{ $styles[$level] }}">
                                {!! $svgs[$level] !!} {{ $labels[$level] }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('guru-bk.siswa-binaan.show', $item['siswa']) }}" class="btn-sm" style="background:#eff6ff;color:#1d4ed8;">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- Main Grid --}}
<div class="main-grid">

    {{-- Konseling Terbaru --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">Konseling Terbaru</div>
            <a href="{{ route('guru-bk.konseling.index') }}" class="btn-sm btn-primary">Lihat Semua</a>
        </div>
        <div style="padding:0;">
            @if($konselingTerbaru->isEmpty())
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Belum ada data konseling
            </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($konselingTerbaru as $k)
                    <tr>
                        <td>
                            <div style="font-weight:600;">{{ $k->siswa->name }}</div>
                            <div style="font-size:0.72rem;color:#94a3b8;">{{ $k->siswa->nis }}</div>
                        </td>
                        <td style="color:#475569;font-size:0.78rem;">{{ $k->kategori }}</td>
                        <td style="color:#94a3b8;font-size:0.78rem;">{{ $k->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($k->status == 'Baru')
                                <span class="badge badge-baru">Baru</span>
                            @elseif($k->status == 'Dalam Proses')
                                <span class="badge badge-proses">Proses</span>
                            @else
                                <span class="badge badge-selesai">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    {{-- Right Column --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Status Konseling --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Status Konseling</div>
            </div>
            <div class="card-body">
                <div class="status-grid">
                    <div class="status-item" style="background:#eff6ff;border-color:#bfdbfe;">
                        <div class="status-num" style="color:#1d4ed8;">{{ $konselingBaru }}</div>
                        <div class="status-lbl">Baru</div>
                    </div>
                    <div class="status-item" style="background:#fffbeb;border-color:#fcd34d;">
                        <div class="status-num" style="color:#d97706;">{{ $konselingProses }}</div>
                        <div class="status-lbl">Dalam Proses</div>
                    </div>
                    <div class="status-item" style="background:#f0fdf4;border-color:#bbf7d0;">
                        <div class="status-num" style="color:#15803d;">{{ $konselingSelesai }}</div>
                        <div class="status-lbl">Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kategori Konseling --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Konseling per Kategori</div>
            </div>
            <div class="card-body">
                @php
                    $kategoriList = ['Pribadi','Sosial','Belajar','Karir','Keluarga'];
                    $maxKategori  = $kategoriStats->max() ?: 1;
                    $fillClass    = ['Pribadi'=>'fill-pribadi','Sosial'=>'fill-sosial','Belajar'=>'fill-belajar','Karir'=>'fill-karir','Keluarga'=>'fill-keluarga'];
                @endphp
                @foreach($kategoriList as $kat)
                @php $count = $kategoriStats[$kat] ?? 0; @endphp
                <div class="kat-item">
                    <div class="kat-header">
                        <span>{{ $kat }}</span>
                        <span class="kat-count">{{ $count }}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill {{ $fillClass[$kat] }}" style="width:{{ $maxKategori > 0 ? ($count/$maxKategori*100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection