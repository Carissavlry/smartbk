@extends('layouts.admin')

@section('title', 'Backup & Restore Database')
@section('page-title', 'Backup & Restore')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:28px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:24px; }
    .card-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; color:var(--navy-dark); padding-bottom:10px; border-bottom:2px solid #e8edf5; margin-bottom:20px; }
    .btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:10px; font-size:0.83rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all 0.2s; }
    .btn-primary { background:var(--navy-dark); color:white; }
    .btn-primary:hover { background:var(--navy-darkest); color:white; }
    .btn-danger { background:#fee2e2; color:#dc2626; }
    .btn-danger:hover { background:#fecaca; }
    .btn-success { background:#dcfce7; color:#16a34a; }
    .btn-success:hover { background:#bbf7d0; }
    .btn-warning { background:#fef9c3; color:#ca8a04; }
    .btn-warning:hover { background:#fef08a; }
    .alert { padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:0.85rem; font-weight:500; }
    .alert-success { background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0; }
    .alert-error { background:#fee2e2; color:#dc2626; border:1px solid #fecaca; }
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.84rem; }
    th { background:#f8fafc; color:#64748b; font-weight:600; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em; padding:10px 14px; text-align:left; border-bottom:1px solid #e8edf5; }
    td { padding:12px 14px; border-bottom:1px solid #f1f5f9; color:#1e293b; vertical-align:middle; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#f8fafc; }
    .empty-state { text-align:center; padding:40px; color:#94a3b8; }
    .file-icon { font-size:1.5rem; }
    .restore-zone { border:2px dashed #cbd5e1; border-radius:12px; padding:24px; text-align:center; background:#f8fafc; }
    .restore-zone input[type=file] { margin:12px auto; display:block; font-size:0.84rem; }
    .warning-box { background:#fef9c3; border:1px solid #fde68a; border-radius:10px; padding:12px 16px; font-size:0.82rem; color:#92400e; margin-bottom:16px; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Backup & Restore Database</div>
        <div class="page-header__sub">Kelola backup database sistem SmartBK</div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif

{{-- CARD: Buat Backup --}}
<div class="card">
    <div class="card-title">🗄️ Buat Backup Database</div>
    <p style="font-size:0.85rem;color:#64748b;margin-bottom:16px;">
        Backup akan menyimpan seluruh data database ke file <strong>.sql</strong> di server.
        Proses ini aman dan tidak mengganggu operasional sistem.
    </p>
    <form method="POST" action="{{ route('admin.backup.store') }}"
          onsubmit="this.querySelector('button').disabled=true; this.querySelector('button').textContent='Memproses...';">
        @csrf
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Buat Backup Sekarang
        </button>
    </form>
</div>

{{-- CARD: Daftar File Backup --}}
<div class="card">
    <div class="card-title">📁 Daftar File Backup</div>
    @if(count($files) > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama File</th>
                        <th>Ukuran</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($files as $i => $file)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <span style="font-family:monospace;font-size:0.82rem;">{{ $file['name'] }}</span>
                        </td>
                        <td>{{ $file['size'] }}</td>
                        <td>{{ $file['created_at'] }}</td>
                        <td>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <a href="{{ route('admin.backup.download', $file['name']) }}" class="btn btn-success" style="padding:6px 12px;font-size:0.78rem;">
                                    ⬇️ Download
                                </a>
                                <form method="POST" action="{{ route('admin.backup.destroy', $file['name']) }}"
                                      onsubmit="return confirm('Hapus file backup ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding:6px 12px;font-size:0.78rem;">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="file-icon">📭</div>
            <p style="margin-top:8px;font-size:0.85rem;">Belum ada file backup. Buat backup pertama kamu di atas.</p>
        </div>
    @endif
</div>

{{-- CARD: Restore Database --}}
<div class="card">
    <div class="card-title">♻️ Restore Database</div>
    <div class="warning-box">
        ⚠️ <strong>Perhatian:</strong> Restore akan <strong>menimpa seluruh data database saat ini</strong> dengan data dari file backup.
        Pastikan kamu sudah membuat backup terbaru sebelum melakukan restore.
    </div>
    <div class="restore-zone">
        <p style="font-size:0.85rem;color:#64748b;margin-bottom:8px;">Upload file <strong>.sql</strong> untuk restore database</p>
        <form method="POST" action="{{ route('admin.backup.restore') }}" enctype="multipart/form-data"
              onsubmit="return confirm('YAKIN ingin restore? Seluruh data saat ini akan DITIMPA!');">
            @csrf
            <input type="file" name="file" accept=".sql" required>
            @error('file') <p style="color:#dc2626;font-size:0.8rem;margin-top:4px;">{{ $message }}</p> @enderror
            <button type="submit" class="btn btn-warning" style="margin-top:12px;">
                ♻️ Restore Database
            </button>
        </form>
    </div>
</div>
@endsection