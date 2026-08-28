@extends('layouts.admin')

@section('title', 'Manajemen Kelas')
@section('page-title', 'Kelas')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-primary { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; background:linear-gradient(135deg,var(--navy-dark),var(--navy-darkest)); color:white; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; border:none; cursor:pointer; transition:all 0.2s; box-shadow:0 4px 12px rgba(5,38,89,0.2); }
    .btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(5,38,89,0.28); }
    .btn-primary svg { width:16px; height:16px; }
    .alert { padding:12px 16px; border-radius:10px; font-size:0.82rem; font-weight:500; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
    .alert--success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
    .alert--error   { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
    .alert svg { width:18px; height:18px; flex-shrink:0; }

    /* Filter Bar */
    .filter-bar { background:white; border-radius:14px; border:1px solid #e8edf5; padding:18px 20px; margin-bottom:20px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
    .filter-row { display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; }
    .filter-group { display:flex; flex-direction:column; gap:5px; flex:1; min-width:160px; }
    .filter-group label { font-size:0.72rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; }
    .filter-control { padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.82rem; color:var(--navy-darkest); background:white; font-family:inherit; transition:border 0.2s; }
    .filter-control:focus { outline:none; border-color:var(--navy-mid); }
    .filter-actions { display:flex; gap:8px; }
    .btn-filter { padding:8px 18px; background:linear-gradient(135deg,var(--navy-dark),var(--navy-darkest)); color:white; border:none; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-filter:hover { transform:translateY(-1px); }
    .btn-reset { padding:8px 14px; background:#f1f5f9; color:#64748b; border:none; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; }
    .btn-reset:hover { background:#e2e8f0; }

    /* Stats */
    .stats-row { display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
    .stat-chip { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:0.78rem; font-weight:600; }
    .stat-chip--all  { background:rgba(5,38,89,0.07);  color:var(--navy-dark); }
    .stat-chip--x    { background:rgba(5,38,89,0.07);  color:var(--navy-dark); }
    .stat-chip--xi   { background:rgba(117,22,46,0.08); color:var(--maroon-mid); }
    .stat-chip--xii  { background:rgba(13,148,136,0.08); color:#0d9488; }

    .card { background:white; border-radius:16px; border:1px solid #e8edf5; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.82rem; }
    thead { background:#f8fafc; border-bottom:1px solid #e8edf5; }
    th { padding:13px 18px; text-align:left; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#64748b; white-space:nowrap; }
    td { padding:14px 18px; color:var(--navy-darkest); border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#fafbff; }
    .badge { display:inline-flex; align-items:center; padding:4px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge--x      { background:rgba(5,38,89,0.08);   color:var(--navy-dark); }
    .badge--xi     { background:rgba(117,22,46,0.08);  color:var(--maroon-mid); }
    .badge--xii    { background:rgba(13,148,136,0.08); color:#0d9488; }
    .badge--noguru { background:#fff7ed; color:#c2410c; }
    .action-btns { display:flex; align-items:center; gap:8px; }
    .btn-sm { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:8px; font-size:0.74rem; font-weight:600; text-decoration:none; border:none; cursor:pointer; transition:all 0.2s; }
    .btn-sm svg { width:13px; height:13px; }
    .btn-edit   { background:rgba(5,38,89,0.08);   color:var(--navy-dark); }
    .btn-edit:hover { background:rgba(5,38,89,0.15); }
    .btn-danger { background:rgba(220,38,38,0.08); color:#dc2626; }
    .btn-danger:hover { background:rgba(220,38,38,0.15); }
    .empty-state { padding:60px 20px; text-align:center; color:#94a3b8; }
    .empty-state svg { width:48px; height:48px; margin:0 auto 12px; opacity:0.4; }
    .empty-state__title { font-size:0.9rem; font-weight:600; margin-bottom:4px; }
    .empty-state__sub { font-size:0.78rem; }
    .guru-name { font-size:0.78rem; color:#64748b; }
    .hasil-info { font-size:0.78rem; color:#64748b; padding:12px 20px; border-bottom:1px solid #f1f5f9; }
    .hasil-info strong { color:var(--navy-dark); }
</style>

<!-- Header -->
<div class="page-header">
    <div>
        <div class="page-header__title">Manajemen Kelas</div>
        <div class="page-header__sub">Kelola data kelas dan penugasan Guru BK</div>
    </div>
    <a href="{{ route('admin.kelas.create') }}" class="btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Kelas
    </a>
</div>

<!-- Alert -->
@if(session('success'))
<div class="alert alert--success">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert--error">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('error') }}
</div>
@endif

<!-- Filter Bar -->
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.kelas.index') }}">
        <div class="filter-row">
            <div class="filter-group" style="flex:2; min-width:200px;">
                <label>Cari Kelas / Jurusan</label>
                <input type="text" name="search" class="filter-control"
                    placeholder="Ketik nama kelas atau jurusan..."
                    value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <label>Tingkat</label>
                <select name="tingkat" class="filter-control">
                    <option value="">Semua Tingkat</option>
                    <option value="X"   {{ request('tingkat')=='X'   ? 'selected':'' }}>Kelas X</option>
                    <option value="XI"  {{ request('tingkat')=='XI'  ? 'selected':'' }}>Kelas XI</option>
                    <option value="XII" {{ request('tingkat')=='XII' ? 'selected':'' }}>Kelas XII</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Tahun Ajaran</label>
                <select name="tahun_ajaran_id" class="filter-control">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunAjarans as $ta)
                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id')==$ta->id ? 'selected':'' }}>
                        {{ $ta->nama }} — {{ $ta->semester }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn-filter">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;display:inline;margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari
                </button>
                <a href="{{ route('admin.kelas.index') }}" class="btn-reset">Reset</a>
            </div>
        </div>
    </form>
</div>

<!-- Stats -->
<div class="stats-row">
    <span class="stat-chip stat-chip--all">
        📋 Total: {{ $kelas->count() }} kelas
    </span>
    <span class="stat-chip stat-chip--x">
        X: {{ $kelas->where('tingkat','X')->count() }}
    </span>
    <span class="stat-chip stat-chip--xi">
        XI: {{ $kelas->where('tingkat','XI')->count() }}
    </span>
    <span class="stat-chip stat-chip--xii">
        XII: {{ $kelas->where('tingkat','XII')->count() }}
    </span>
</div>

<!-- Tabel -->
<div class="card">
    @if(request()->hasAny(['search','tingkat','tahun_ajaran_id']) && request()->anyFilled(['search','tingkat','tahun_ajaran_id']))
    <div class="hasil-info">
        Menampilkan <strong>{{ $kelas->count() }}</strong> hasil pencarian
        @if(request('search')) untuk "<strong>{{ request('search') }}</strong>"@endif
    </div>
    @endif
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                    <th>Guru BK</th>
                    <th>Tahun Ajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $k->nama }}</strong></td>
                    <td>
                        <span class="badge badge--{{ strtolower($k->tingkat) }}">
                            Kelas {{ $k->tingkat }}
                        </span>
                    </td>
                    <td>{{ $k->jurusan ?? '-' }}</td>
                    <td>
                        @if($k->guru)
                            <span class="guru-name">{{ $k->guru->name }}</span>
                        @else
                            <span class="badge badge--noguru">Belum ditugaskan</span>
                        @endif
                    </td>
                    <td>{{ $k->tahunAjaran->nama ?? '-' }} — {{ $k->tahunAjaran->semester ?? '' }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.kelas.edit', $k) }}" class="btn-sm btn-edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.kelas.destroy', $k) }}"
                                  onsubmit="return confirm('Hapus kelas {{ $k->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <div class="empty-state__title">
                                @if(request()->anyFilled(['search','tingkat','tahun_ajaran_id']))
                                    Tidak ada kelas yang cocok
                                @else
                                    Belum ada kelas
                                @endif
                            </div>
                            <div class="empty-state__sub">
                                @if(request()->anyFilled(['search','tingkat','tahun_ajaran_id']))
                                    Coba ubah kata kunci atau filter pencarian
                                @else
                                    Klik tombol "Tambah Kelas" untuk memulai
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection