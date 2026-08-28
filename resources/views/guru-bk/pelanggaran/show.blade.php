@extends('layouts.guru')
@section('title', 'Detail Pelanggaran')
@section('page-title', 'Pelanggaran & Poin')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .header-actions { display:flex; gap:10px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-edit { display:inline-flex; align-items:center; gap:6px; padding:8px 18px; background:var(--maroon-mid); color:white; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-edit:hover { background:var(--maroon-dark); }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .section-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--navy-dark); padding-bottom:10px; border-bottom:2px solid #e8edf5; margin-bottom:18px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .info-item { display:flex; flex-direction:column; gap:3px; }
    .info-item.full { grid-column:1/-1; }
    .info-label { font-size:0.72rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; }
    .info-value { font-size:0.88rem; color:#1e293b; font-weight:500; }
    .info-value.empty { color:#cbd5e1; font-style:italic; }
    .badge-poin { display:inline-flex; align-items:center; gap:4px; background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:8px; padding:4px 12px; font-size:0.88rem; font-weight:700; }
    .siswa-card { display:flex; align-items:center; gap:14px; background:#f8fafc; border-radius:12px; padding:16px; margin-bottom:20px; border:1px solid #e8edf5; }
    .siswa-avatar { width:48px; height:48px; border-radius:50%; background:linear-gradient(135deg,var(--navy-dark),var(--maroon-mid)); display:flex; align-items:center; justify-content:center; color:white; font-size:1rem; font-weight:700; flex-shrink:0; overflow:hidden; }
    .siswa-avatar img { width:100%; height:100%; object-fit:cover; }
    .siswa-name { font-size:0.95rem; font-weight:700; color:var(--navy-darkest); }
    .siswa-meta { font-size:0.78rem; color:#64748b; margin-top:2px; display:flex; gap:10px; flex-wrap:wrap; }
    .total-poin-card { background:linear-gradient(135deg,#fef2f2,#fff5f5); border:1px solid #fecaca; border-radius:12px; padding:16px 20px; display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
    .total-poin-label { font-size:0.78rem; font-weight:600; color:#dc2626; }
    .total-poin-value { font-size:1.8rem; font-weight:900; color:#dc2626; }
    .catatan-box { background:#f8fafc; border-radius:10px; padding:14px 16px; font-size:0.85rem; color:#334155; line-height:1.7; border:1px solid #e8edf5; white-space:pre-wrap; }
    .catatan-box.empty { color:#cbd5e1; font-style:italic; }
    .danger-zone { background:#fff8f8; border:1px solid #fee2e2; border-radius:12px; padding:16px 20px; }
    .danger-title { font-size:0.75rem; font-weight:700; text-transform:uppercase; color:#dc2626; margin-bottom:10px; }
    .btn-danger { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:#dc2626; border:1.5px solid #fca5a5; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; }
    .btn-danger:hover { background:#fef2f2; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Detail Pelanggaran</div>
        <div class="page-header__sub">{{ $pelanggaran->tanggal->translatedFormat('d F Y') }}</div>
    </div>
    <div class="header-actions">
        <a href="{{ route('guru-bk.pelanggaran.index') }}" class="btn-back">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
        <a href="{{ route('guru-bk.pelanggaran.edit', $pelanggaran) }}" class="btn-edit">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
            Edit
        </a>
    </div>
</div>

{{-- Total Poin Siswa --}}
<div class="total-poin-card">
    <div>
        <div class="total-poin-label">Total Poin Pelanggaran Siswa</div>
        <div style="font-size:0.75rem;color:#94a3b8;margin-top:2px;">{{ $pelanggaran->siswa->name }}</div>
    </div>
    <div class="total-poin-value">{{ $totalPoin }} <span style="font-size:1rem;">poin</span></div>
</div>

<div class="card">
    <div class="section-title">Data Siswa</div>
    <div class="siswa-card">
        <div class="siswa-avatar">
            @if($pelanggaran->siswa->foto)
                <img src="{{ asset('storage/'.$pelanggaran->siswa->foto) }}" alt="Foto">
            @else
                {{ strtoupper(substr($pelanggaran->siswa->name,0,1)) }}
            @endif
        </div>
        <div>
            <div class="siswa-name">{{ $pelanggaran->siswa->name }}</div>
            <div class="siswa-meta">
                <span>NIS: {{ $pelanggaran->siswa->nis }}</span>
                <span>•</span>
                <span>{{ $pelanggaran->siswa->kelas->nama ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="section-title">Detail Pelanggaran</div>
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Jenis Pelanggaran</div>
            <div class="info-value">{{ $pelanggaran->jenisPelanggaran->nama ?? '-' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Tanggal</div>
            <div class="info-value">{{ $pelanggaran->tanggal->translatedFormat('d F Y') }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Poin</div>
            <div class="info-value">
                <span class="badge-poin">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                    {{ $pelanggaran->poin }} poin
                </span>
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Dicatat Oleh</div>
            <div class="info-value">{{ $pelanggaran->pencatat->name ?? '-' }}</div>
        </div>
        <div class="info-item full">
            <div class="info-label">Keterangan</div>
            <div class="catatan-box {{ !$pelanggaran->keterangan ? 'empty' : '' }}">
                {{ $pelanggaran->keterangan ?? 'Tidak ada keterangan' }}
            </div>
        </div>
    </div>
</div>

<div class="danger-zone">
    <div class="danger-title">⚠ Zona Berbahaya</div>
    <form method="POST" action="{{ route('guru-bk.pelanggaran.destroy', $pelanggaran) }}"
          onsubmit="return confirm('Hapus data pelanggaran ini secara permanen?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-danger">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            Hapus Pelanggaran
        </button>
    </form>
</div>
@endsection