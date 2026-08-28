@extends('layouts.admin')

@section('title', 'Import Siswa')
@section('page-title', 'Siswa')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-back:hover { background:#f8fafc; border-color:var(--navy-dark); }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .section-title { display:flex; align-items:center; gap:8px; font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--navy-dark); padding-bottom:10px; border-bottom:2px solid #e8edf5; margin-bottom:20px; }
    .section-title svg { width:15px; height:15px; flex-shrink:0; }
    .upload-area { border:2px dashed #c7d6e8; border-radius:12px; padding:40px 20px; text-align:center; background:#f8faff; transition:all 0.2s; cursor:pointer; }
    .upload-area:hover { border-color:var(--navy-dark); background:#eff6ff; }
    .upload-area svg { width:48px; height:48px; color:#94a3b8; margin:0 auto 12px; display:block; }
    .upload-area p { font-size:0.88rem; color:#64748b; margin-bottom:4px; }
    .upload-area span { font-size:0.75rem; color:#94a3b8; }
    .file-input { display:none; }
    .file-selected { margin-top:12px; padding:10px 16px; background:#f0fdf4; border:1px solid #86efac; border-radius:8px; font-size:0.83rem; color:#15803d; display:none; }
    .btn-submit { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:linear-gradient(135deg,var(--navy-dark),var(--navy-darkest)); color:white; border:none; border-radius:10px; font-size:0.85rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(5,38,89,0.25); }
    .btn-template { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; background:#f0fdf4; color:#15803d; border:1.5px solid #86efac; border-radius:10px; font-size:0.83rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-template:hover { background:#dcfce7; }
    .info-box { background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:16px 20px; margin-bottom:20px; }
    .info-box__title { display:flex; align-items:center; gap:7px; font-size:0.83rem; color:#1d4ed8; font-weight:600; margin-bottom:8px; }
    .info-box__title svg { width:15px; height:15px; flex-shrink:0; }
    .info-box ul { font-size:0.8rem; color:#3b82f6; padding-left:20px; }
    .info-box ul li { margin-bottom:4px; }
    .col-table { width:100%; border-collapse:collapse; margin-top:12px; }
    .col-table th { background:#f8faff; padding:8px 12px; text-align:left; font-size:0.75rem; font-weight:700; color:#64748b; text-transform:uppercase; border-bottom:1px solid #e8edf5; }
    .col-table td { padding:8px 12px; font-size:0.82rem; border-bottom:1px solid #f1f5f9; color:var(--navy-darkest); }
    .badge-wajib { background:#fef2f2; color:#dc2626; padding:2px 8px; border-radius:6px; font-size:0.72rem; font-weight:600; }
    .badge-opsional { background:#f0fdf4; color:#16a34a; padding:2px 8px; border-radius:6px; font-size:0.72rem; font-weight:600; }
</style>

{{-- Alert Error --}}
@if($errors->any())
<div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:0.85rem;">
    <strong>Terdapat kesalahan:</strong>
    <ul style="margin:6px 0 0 18px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Header --}}
<div class="page-header">
    <div>
        <div class="page-header__title">Import Data Siswa</div>
        <div class="page-header__sub">Upload file Excel/CSV untuk menambah banyak siswa sekaligus</div>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
</div>

{{-- Info Box --}}
<div class="info-box">
    <div class="info-box__title">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Petunjuk Import:
    </div>
    <ul>
        <li>Download template CSV terlebih dahulu sebagai panduan format</li>
        <li>NIS yang sudah ada di sistem akan <strong>dilewati otomatis</strong> (tidak error)</li>
        <li>Password default siswa = NIS masing-masing</li>
        <li>Nama kelas harus <strong>sama persis</strong> dengan data kelas di sistem</li>
        <li>Format jenis kelamin: <strong>Laki-laki</strong> atau <strong>Perempuan</strong> (atau L/P)</li>
        <li>Ukuran file maksimal: <strong>5MB</strong></li>
    </ul>
</div>

{{-- Template Download --}}
<div class="card">
    <div class="section-title">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Step 1 — Download Template
    </div>
    <p style="font-size:0.83rem;color:#64748b;margin-bottom:16px;">Download template CSV berikut sebagai panduan format data yang harus diisi.</p>

    <a href="{{ route('admin.siswa.template') }}" class="btn-template">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Download Template CSV
    </a>

    <table class="col-table" style="margin-top:20px;">
        <thead>
            <tr>
                <th>Kolom</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Contoh</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>nis</td><td>Nomor Induk Siswa</td><td><span class="badge-wajib">Wajib</span></td><td>1234567890</td></tr>
            <tr><td>nama_lengkap</td><td>Nama lengkap siswa</td><td><span class="badge-wajib">Wajib</span></td><td>Budi Santoso</td></tr>
            <tr><td>jenis_kelamin</td><td>Laki-laki / Perempuan / L / P</td><td><span class="badge-wajib">Wajib</span></td><td>Laki-laki</td></tr>
            <tr><td>kelas</td><td>Nama kelas (harus sama persis)</td><td><span class="badge-opsional">Opsional</span></td><td>XI RPL 1</td></tr>
            <tr><td>no_hp</td><td>Nomor HP siswa</td><td><span class="badge-opsional">Opsional</span></td><td>08123456789</td></tr>
            <tr><td>email</td><td>Email siswa</td><td><span class="badge-opsional">Opsional</span></td><td>budi@gmail.com</td></tr>
            <tr><td>nama_orang_tua</td><td>Nama orang tua/wali</td><td><span class="badge-opsional">Opsional</span></td><td>Slamet</td></tr>
            <tr><td>no_hp_orang_tua</td><td>No HP orang tua</td><td><span class="badge-opsional">Opsional</span></td><td>08198765432</td></tr>
            <tr><td>alamat</td><td>Alamat lengkap siswa</td><td><span class="badge-opsional">Opsional</span></td><td>Jl. Merdeka No.1</td></tr>
        </tbody>
    </table>
</div>

{{-- Upload Form --}}
<div class="card">
    <div class="section-title">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
        </svg>
        Step 2 — Upload File
    </div>
    <form method="POST" action="{{ route('admin.siswa.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="upload-area" onclick="document.getElementById('fileInput').click()">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
            </svg>
            <p><strong>Klik untuk pilih file</strong> atau drag & drop di sini</p>
            <span>Format: .xlsx, .xls, .csv — Maks. 5MB</span>
            <div class="file-selected" id="fileSelected">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;display:inline;margin-right:4px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span id="fileName"></span>
            </div>
        </div>
        <input type="file" name="file" id="fileInput" class="file-input" accept=".xlsx,.xls,.csv" onchange="showFileName(this)">

        <div style="display:flex;justify-content:flex-end;margin-top:20px;">
            <button type="submit" class="btn-submit">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                Import Sekarang
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function showFileName(input) {
    if (input.files && input.files[0]) {
        document.getElementById('fileName').textContent = input.files[0].name;
        document.getElementById('fileSelected').style.display = 'block';
    }
}
</script>
@endpush

@endsection