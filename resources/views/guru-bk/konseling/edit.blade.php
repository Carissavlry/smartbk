@extends('layouts.guru')

@section('title', 'Edit Kasus Konseling')

@section('content')
<style>
    .page-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:#374151; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-back:hover { background:#f8fafc; }
    .alert-warn { background:#fffbeb; border:1px solid #fde68a; border-radius:10px; padding:12px 18px; margin-bottom:20px; font-size:0.83rem; color:#92400e; display:flex; align-items:flex-start; gap:8px; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; overflow:hidden; }
    .card-header { padding:18px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
    .card-header-title { font-size:0.82rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
    .card-body { padding:24px; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { font-size:0.78rem; font-weight:600; color:#374151; }
    .form-group label span.req { color:#ef4444; margin-left:2px; }
    .form-control { padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; color:#1e293b; background:white; width:100%; box-sizing:border-box; transition:border-color .2s; }
    .form-control:focus { outline:none; border-color:var(--navy-dark); }
    textarea.form-control { resize:vertical; min-height:90px; }
    .lock-field { padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; color:#64748b; background:#f8fafc; display:flex; align-items:center; gap:8px; width:100%; box-sizing:border-box; }
    .footer-actions { display:flex; justify-content:flex-end; gap:12px; padding:20px 24px; border-top:1px solid #f1f5f9; }
    .btn-cancel { padding:9px 20px; background:white; color:#374151; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; }
    .btn-submit { padding:9px 24px; background:var(--navy-dark); color:white; border:none; border-radius:9px; font-size:0.85rem; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:8px; }
    .btn-submit:hover { background:var(--navy-darkest); }
    .alert-error { background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:12px 18px; margin-bottom:20px; font-size:0.83rem; color:#dc2626; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Edit Kasus Konseling</div>
        <div class="page-header__sub">Koreksi data kasus yang salah</div>
    </div>
    <a href="{{ route('guru-bk.konseling.show', $konseling) }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div class="alert-warn">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
    <div>Form ini hanya untuk <strong>koreksi data kasus</strong>. Untuk menambah sesi baru, gunakan tombol <strong>Lanjut Konseling</strong> di halaman detail.</div>
</div>

@if($errors->any())
<div class="alert-error">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('guru-bk.konseling.update', $konseling) }}">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="card-header-title">Data Kasus</span>
        </div>
        <div class="card-body">
            <div class="form-grid">
                <div class="form-group">
                    <label>Siswa</label>
                    <div class="lock-field">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;color:#94a3b8;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        {{ $konseling->siswa->name }}
                    </div>
                </div>
                <div class="form-group">
                    <label>Kategori Masalah <span class="req">*</span></label>
                    <select name="kategori" class="form-control" required>
                        @foreach(['Pribadi','Sosial','Belajar','Karir','Keluarga'] as $kat)
                            <option value="{{ $kat }}" {{ $konseling->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group full">
                    <label>Deskripsi Masalah <span class="req">*</span></label>
                    <textarea name="deskripsi_masalah" class="form-control" required>{{ old('deskripsi_masalah', $konseling->deskripsi_masalah) }}</textarea>
                </div>
            </div>
        </div>
        <div class="footer-actions">
            <a href="{{ route('guru-bk.konseling.show', $konseling) }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>

@endsection