@extends('layouts.guru')
@section('title', 'Prestasi Siswa')
@section('page-title', 'Prestasi Siswa')

@section('content')
<style>
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.page-header__title { font-size:1.25rem; font-weight:700; color:var(--navy-darkest); margin:0; }
.page-header__sub { font-size:0.78rem; color:#64748b; margin:2px 0 0; }
.btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all .18s; }
.btn-primary { background:var(--navy-dark); color:#fff; }
.btn-primary:hover { background:var(--navy-darkest); color:#fff; }
.card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); margin-bottom:20px; overflow:hidden; }
.card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
.card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
.filter-bar { display:flex; flex-wrap:wrap; gap:10px; padding:16px 20px; align-items:center; }
.filter-bar > div { flex:1; min-width:200px; }
.filter-bar select { flex:0 0 160px; width:160px; }
.filter-bar select, .filter-bar input { padding:9px 14px; border:1.5px solid #cbd5e1; border-radius:8px; font-size:0.82rem; color:#374151; background:#fff; outline:none; box-shadow:0 1px 2px rgba(0,0,0,0.04); transition:border .15s,box-shadow .15s; width:100%; }
.filter-bar select:focus, .filter-bar input:focus { border-color:var(--navy-dark); box-shadow:0 0 0 3px rgba(5,38,89,0.08); }
.filter-bar .btn { flex-shrink:0; }
.filter-bar .btn-reset { flex-shrink:0; }
.btn-filter { padding:9px 20px; border-radius:8px; font-size:0.82rem; font-weight:600; border:none; cursor:pointer; transition:all .15s; }
.btn-reset { background:#f1f5f9; color:#64748b; text-decoration:none; display:inline-flex; align-items:center; }
.btn-reset:hover { background:#e2e8f0; color:#374151; }
.table-wrap { overflow-x:auto; }
table { width:100%; border-collapse:collapse; }
th { font-size:0.72rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; padding:12px 16px; text-align:left; border-bottom:2px solid #f1f5f9; background:#fafbfc; white-space:nowrap; }
th:first-child { border-top-left-radius:0; }
td { padding:13px 16px; font-size:0.83rem; color:#374151; border-bottom:1px solid #f8fafc; vertical-align:middle; }
tr:last-child td { border-bottom:none; }
tr:hover td { background:#f8fafc; }
.badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
.badge-akademik { background:#dbeafe; color:#1d4ed8; }
.badge-non { background:#fef3c7; color:#b45309; }
.badge-sekolah { background:#f1f5f9; color:#475569; }
.badge-kota { background:#dcfce7; color:#15803d; }
.badge-provinsi { background:#ede9fe; color:#6d28d9; }
.badge-nasional { background:#fee2e2; color:#dc2626; }
.badge-internasional { background:#fdf4ff; color:#a21caf; }
.badge-kecamatan { background:#e0f2fe; color:#0369a1; }
.action-btn { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:7px; border:none; cursor:pointer; transition:all .15s; text-decoration:none; }
.action-view { background:#eff6ff; color:#3b82f6; }
.action-view:hover { background:#dbeafe; }
.action-edit { background:#f0fdf4; color:#22c55e; }
.action-edit:hover { background:#dcfce7; }
.action-del { background:#fff1f2; color:#f43f5e; }
.empty-state { text-align:center; padding:48px 20px; color:#94a3b8; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.empty-state svg { width:48px; height:48px; margin-bottom:12px; opacity:.4; display:block; }
.pagination-wrap { padding:14px 20px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; }
</style>

<div class="page-header">
    <div>
        <h1 class="page-header__title">Prestasi Siswa</h1>
        <p class="page-header__sub">Kelola data prestasi siswa binaan Anda</p>
    </div>
    <a href="{{ route('guru-bk.prestasi.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Prestasi
    </a>
</div>

@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:0.83rem;display:flex;align-items:center;gap:8px;">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- FILTER CARD --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
        <span class="card-header-title">Filter & Pencarian</span>
    </div>
    <form method="GET" action="{{ route('guru-bk.prestasi.index') }}">
        <div class="filter-bar" style="align-items:center;">
            <div style="position:relative;display:flex;align-items:center;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    style="position:absolute;left:10px;width:15px;height:15px;color:#94a3b8;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Cari nama / NIS siswa..."
                    style="padding-left:32px;min-width:240px;">
            </div>
            <select name="jenis">
                <option value="">Semua Jenis</option>
                <option value="Akademik" {{ $jenis=='Akademik'?'selected':'' }}>Akademik</option>
                <option value="Non-Akademik" {{ $jenis=='Non-Akademik'?'selected':'' }}>Non-Akademik</option>
            </select>
            <select name="tingkat">
                <option value="">Semua Tingkat</option>
                @foreach(['Sekolah','Kecamatan','Kota','Provinsi','Nasional','Internasional'] as $t)
                <option value="{{ $t }}" {{ $tingkat==$t?'selected':'' }}>{{ $t }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-filter">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                </svg>
                Cari
            </button>
            <a href="{{ route('guru-bk.prestasi.index') }}" class="btn-filter btn-reset">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;margin-right:4px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset
            </a>
        </div>
    </form>
</div>

{{-- DATA CARD --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        <span class="card-header-title">Data Prestasi Siswa</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Siswa</th>
                    <th>Nama Prestasi</th>
                    <th>Jenis</th>
                    <th>Tingkat</th>
                    <th>Peringkat</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestasis as $i => $p)
                <tr>
                    <td>{{ $prestasis->firstItem() + $i }}</td>
                    <td>
                        <div style="font-weight:600;color:var(--navy-darkest);">{{ $p->siswa->name }}</div>
                        <div style="font-size:0.72rem;color:#94a3b8;">{{ $p->siswa->nis ?? '-' }}</div>
                    </td>
                    <td>{{ $p->nama_prestasi }}</td>
                    <td>
                        <span class="badge {{ $p->jenis=='Akademik' ? 'badge-akademik' : 'badge-non' }}">
                            {{ $p->jenis }}
                        </span>
                    </td>
                    <td>
                        @php
                        $tingkatClass = [
                            'Sekolah'=>'badge-sekolah','Kecamatan'=>'badge-kecamatan',
                            'Kota'=>'badge-kota','Provinsi'=>'badge-provinsi',
                            'Nasional'=>'badge-nasional','Internasional'=>'badge-internasional'
                        ][$p->tingkat] ?? 'badge-sekolah';
                        @endphp
                        <span class="badge {{ $tingkatClass }}">{{ $p->tingkat }}</span>
                    </td>
                    <td>{{ $p->peringkat ?? '-' }}</td>
                    <td>{{ $p->tanggal->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <a href="{{ route('guru-bk.prestasi.show', $p) }}" class="action-btn action-view" title="Detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('guru-bk.prestasi.edit', $p) }}" class="action-btn action-edit" title="Edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('guru-bk.prestasi.destroy', $p) }}" onsubmit="return confirm('Hapus prestasi ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-del" title="Hapus">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            <p>Belum ada data prestasi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($prestasis->hasPages())
    <div class="pagination-wrap">{{ $prestasis->withQueryString()->links() }}</div>
    @endif
</div>
@endsection