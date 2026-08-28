@extends('layouts.guru')

@section('title', 'Detail Surat Peringatan')
@section('page-title', 'Detail Surat Peringatan')

@section('content')
<style>
.back-btn { display:inline-flex; align-items:center; gap:6px; color:#64748b; font-size:0.82rem; text-decoration:none; margin-bottom:20px; }
.back-btn:hover { color:var(--navy-dark); }
.card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); margin-bottom:20px; overflow:hidden; }
.card-header { padding:16px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
.card-header-title { font-size:0.85rem; font-weight:700; color:var(--navy-darkest); text-transform:uppercase; letter-spacing:0.04em; }
.card-body { padding:24px; }
.info-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px; }
.info-item label { font-size:0.72rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.04em; display:block; margin-bottom:4px; }
.info-item span { font-size:0.9rem; color:#1e293b; font-weight:600; }
.badge { display:inline-flex; align-items:center; gap:4px; padding:4px 12px; border-radius:20px; font-size:0.78rem; font-weight:700; }
.badge-kuning { background:#fef9c3; color:#854d0e; }
.badge-merah { background:#fee2e2; color:#991b1b; }
.badge-hitam { background:#1e293b; color:#fff; }
.badge-diakui { background:#dcfce7; color:#166534; }
.btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all .18s; }
.btn-primary { background:var(--navy-dark); color:#fff; }
.btn-primary:hover { background:var(--navy-darkest); color:#fff; }
.btn-outline { background:#fff; border:1.5px solid #e2e8f0; color:#374151; }
.btn-outline:hover { border-color:var(--navy-dark); color:var(--navy-dark); }
.btn-success { background:#16a34a; color:#fff; }
.btn-success:hover { background:#15803d; color:#fff; }
.isi-surat { background:#f8fafc; border-radius:10px; padding:20px; font-size:0.88rem; line-height:1.8; color:#1e293b; white-space:pre-line; border:1px solid #e2e8f0; }
.action-bar { display:flex; gap:10px; flex-wrap:wrap; margin-top:20px; }
</style>

<a href="{{ route('guru-bk.surat-peringatan.index') }}" class="back-btn">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
    </svg>
    Kembali ke Daftar
</a>

{{-- Alert --}}
@if(session('success'))
    <div style="background:#dcfce7;color:#166534;padding:12px 18px;border-radius:10px;margin-bottom:16px;font-size:0.85rem;font-weight:600;display:flex;align-items:center;gap:10px;">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- Info Surat --}}
<div class="card">
    <div class="card-header">
        <span class="card-header-title">Informasi Surat Peringatan</span>
        @if($suratPeringatan->level === 'kuning')
            <span class="badge badge-kuning">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                </svg>
                SP Kuning
            </span>
        @elseif($suratPeringatan->level === 'merah')
            <span class="badge badge-merah">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                </svg>
                SP Merah
            </span>
        @else
            <span class="badge badge-hitam">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
                SP Hitam
            </span>
        @endif
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>Nomor Surat</label>
                <span>{{ $suratPeringatan->nomor_surat }}</span>
            </div>
            <div class="info-item">
                <label>Nama Siswa</label>
                <span>{{ $suratPeringatan->siswa->name ?? '-' }}</span>
            </div>
            <div class="info-item">
                <label>Kelas</label>
                <span>{{ $suratPeringatan->siswa->kelas->nama_kelas ?? '-' }}</span>
            </div>
            <div class="info-item">
                <label>Total Poin Pelanggaran</label>
                <span style="color:#dc2626;font-size:1.1rem;">{{ $suratPeringatan->total_poin }}</span>
            </div>
            <div class="info-item">
                <label>Dibuat oleh</label>
                <span>{{ $suratPeringatan->guruBk->name ?? '-' }}</span>
            </div>
            <div class="info-item">
                <label>Tanggal Dibuat</label>
                <span>{{ $suratPeringatan->created_at->setTimezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</span>
            </div>
            <div class="info-item">
                <label>Status</label>
                <span>
                    <span class="badge" style="background:#f1f5f9;color:#64748b;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                        Terkirim
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>

{{-- Isi Surat --}}
<div class="card">
    <div class="card-header">
        <span class="card-header-title">Isi Surat</span>
    </div>
    <div class="card-body">
        <div class="isi-surat">{{ $suratPeringatan->isi_surat }}</div>
    </div>
</div>

{{-- Action Bar --}}
<div class="action-bar">
    <a href="{{ route('guru-bk.surat-peringatan.pdf', $suratPeringatan) }}"
       class="btn btn-primary" target="_blank">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
        </svg>
        Download PDF
    </a>
</div>
@endsection