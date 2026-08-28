@extends('layouts.guru')

@section('title', 'Detail Sesi')

@section('content')
<style>
    .page-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:#374151; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-back:hover { background:#f8fafc; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; overflow:hidden; }
    .card-header { padding:18px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
    .card-header-title { font-size:0.82rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
    .card-body { padding:24px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px 24px; }
    .info-item label { font-size:0.7rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; display:block; margin-bottom:4px; }
    .info-item .value { font-size:0.9rem; font-weight:600; color:#1e293b; }
    .sesi-badge { display:inline-flex; align-items:center; background:#eff6ff; color:#1d4ed8; border:1.5px solid #bfdbfe; border-radius:8px; padding:4px 12px; font-size:0.82rem; font-weight:700; }
    .section-label { font-size:0.72rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:6px; }
    .section-value { font-size:0.88rem; color:#1e293b; line-height:1.6; }
    .section-value.empty { color:#94a3b8; font-style:italic; }
    .divider { border:none; border-top:1px solid #f1f5f9; margin:18px 0; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">
            Detail Sesi
            <span class="sesi-badge" style="margin-left:8px;font-size:0.8rem;">Sesi {{ $sesi->ke }}</span>
        </div>
        <div class="page-header__sub">{{ $sesi->konseling->siswa->name }} &mdash; {{ $sesi->konseling->kategori }}</div>
    </div>
    <a href="{{ route('guru-bk.konseling.show', $sesi->konseling) }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Kasus
    </a>
</div>

<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="card-header-title">Informasi Sesi</span>
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>Siswa</label>
                <div class="value">{{ $sesi->konseling->siswa->name }}</div>
            </div>
            <div class="info-item">
                <label>Sesi</label>
                <div class="value"><span class="sesi-badge">Sesi ke-{{ $sesi->ke }}</span></div>
            </div>
            <div class="info-item">
                <label>Tanggal</label>
                <div class="value">{{ \Carbon\Carbon::parse($sesi->tanggal)->translatedFormat('d F Y') }}</div>
            </div>
            <div class="info-item">
                <label>Durasi</label>
                <div class="value">{{ $sesi->durasi }} menit</div>
            </div>
            <div class="info-item">
                <label>Kategori Masalah</label>
                <div class="value">{{ $sesi->konseling->kategori }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        <span class="card-header-title">Catatan Konseling</span>
    </div>
    <div class="card-body">
        <div class="section-label">Deskripsi Masalah</div>
        <div class="section-value">{{ $sesi->deskripsi_masalah ?: '-' }}</div>

        <hr class="divider">

        <div class="section-label">Tindakan Konselor</div>
        <div class="section-value {{ !$sesi->tindakan_konselor ? 'empty' : '' }}">
            {{ $sesi->tindakan_konselor ?: 'Belum diisi' }}
        </div>

        <hr class="divider">

        <div class="section-label">Rekomendasi</div>
        <div class="section-value {{ !$sesi->rekomendasi ? 'empty' : '' }}">
            {{ $sesi->rekomendasi ?: 'Tidak ada rekomendasi' }}
        </div>

        <hr class="divider">

        <div class="section-label">Tindak Lanjut</div>
        <div class="section-value {{ !$sesi->tindak_lanjut ? 'empty' : '' }}">
            {{ $sesi->tindak_lanjut ?: 'Tidak ada tindak lanjut' }}
        </div>
    </div>
</div>

@endsection