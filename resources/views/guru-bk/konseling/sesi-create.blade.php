@extends('layouts.guru')

@section('title', 'Lanjut Konseling')

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
    .locked-note { display:flex; align-items:center; gap:6px; margin-top:14px; font-size:0.78rem; color:#94a3b8; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { font-size:0.78rem; font-weight:600; color:#374151; }
    .form-group label span.req { color:#ef4444; margin-left:2px; }
    .form-control { padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; color:#1e293b; background:white; width:100%; box-sizing:border-box; transition:border-color .2s; }
    .form-control:focus { outline:none; border-color:var(--navy-dark); }
    textarea.form-control { resize:vertical; min-height:90px; }
    .form-hint { font-size:0.72rem; color:#94a3b8; margin-top:2px; }
    .sesi-badge { display:inline-flex; align-items:center; background:#eff6ff; color:#1d4ed8; border:1.5px solid #bfdbfe; border-radius:8px; padding:4px 12px; font-size:0.82rem; font-weight:700; }
    .lock-field { padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; color:#64748b; background:#f8fafc; display:flex; align-items:center; gap:8px; }
    .lock-icon { width:14px; height:14px; color:#94a3b8; flex-shrink:0; }
    .footer-actions { display:flex; justify-content:flex-end; gap:12px; padding:20px 24px; border-top:1px solid #f1f5f9; }
    .btn-cancel { padding:9px 20px; background:white; color:#374151; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; }
    .btn-submit { padding:9px 24px; background:var(--navy-dark); color:white; border:none; border-radius:9px; font-size:0.85rem; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:8px; }
    .btn-submit:hover { background:var(--navy-darkest); }
    .alert-error { background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:12px 18px; margin-bottom:20px; font-size:0.83rem; color:#dc2626; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Lanjut Konseling</div>
        <div class="page-header__sub">{{ $konseling->siswa->name }} &mdash; Sesi ke-{{ $sesiKe }}</div>
    </div>
    <a href="{{ route('guru-bk.konseling.show', $konseling) }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

@if($errors->any())
<div class="alert-error">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
    {{ $errors->first() }}
</div>
@endif

{{-- Info Kasus --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm0 0V7m0 4v4m-4 4h8a2 2 0 002-2V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <span class="card-header-title">Informasi Kasus (Terkunci)</span>
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>Siswa</label>
                <div class="value">{{ $konseling->siswa->name }}</div>
            </div>
            <div class="info-item">
                <label>Kelas</label>
                <div class="value">{{ $konseling->siswa->kelas->nama_kelas ?? '-' }}</div>
            </div>
            <div class="info-item">
                <label>Kategori Masalah</label>
                <div class="value">{{ $konseling->kategori }}</div>
            </div>
            <div class="info-item">
                <label>Sesi</label>
                <div class="value"><span class="sesi-badge">Sesi ke-{{ $sesiKe }}</span></div>
            </div>
        </div>
        <div class="locked-note">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Data siswa dan kategori tidak dapat diubah
        </div>
    </div>
</div>

{{-- Form Catatan Sesi --}}
<form method="POST" action="{{ route('guru-bk.konseling.sesi.store', $konseling) }}">
    @csrf
    <div class="card">
        <div class="card-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <span class="card-header-title">Catatan Sesi</span>
        </div>
        <div class="card-body">
            <div class="form-grid">
                <div class="form-group">
                    <label>Tanggal Konseling <span class="req">*</span></label>
                    <input type="date" name="tanggal" class="form-control"
                           value="{{ old('tanggal_konseling', date('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label>Durasi <span class="req">*</span></label>
                    <input type="number" name="durasi" class="form-control" placeholder="menit"
                           value="{{ old('durasi', 30) }}" min="1" required>
                    <span class="form-hint">Durasi dalam menit</span>
                </div>
                <div class="form-group full">
                    <label>Deskripsi Masalah <span class="req">*</span></label>
                    <textarea name="deskripsi_masalah" class="form-control" placeholder="Tuliskan masalah yang disampaikan siswa pada sesi ini..." required>{{ old('deskripsi_masalah') }}</textarea>
                </div>
                <div class="form-group full">
                    <label>Tindakan Konselor <span class="req">*</span></label>
                    <textarea name="tindakan_konselor" class="form-control" placeholder="Tuliskan tindakan dan pendekatan yang dilakukan konselor...">{{ old('tindakan_konselor') }}</textarea>
                </div>
                <div class="form-group full">
                    <label>Rekomendasi</label>
                    <textarea name="rekomendasi" class="form-control" placeholder="Tuliskan rekomendasi untuk siswa (opsional)...">{{ old('rekomendasi') }}</textarea>
                </div>
                <div class="form-group full">
                    <label>Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" class="form-control" placeholder="Rencana tindak lanjut berikutnya (opsional)...">{{ old('tindak_lanjut') }}</textarea>
                </div>
            </div>
        </div>
        <div class="footer-actions">
            <a href="{{ route('guru-bk.konseling.show', $konseling) }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Simpan Sesi
            </button>
        </div>
    </div>
</form>

@endsection