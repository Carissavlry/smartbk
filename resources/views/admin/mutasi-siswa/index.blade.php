@extends('layouts.admin')

@section('title', 'Mutasi Siswa')
@section('page-title', 'Mutasi Siswa')

@section('content')
<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
    .page-header__title { font-size: 1.1rem; font-weight: 700; color: var(--navy-darkest); }
    .page-header__sub { font-size: 0.78rem; color: #64748b; margin-top: 2px; }
    .btn-add {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 20px;
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-darkest));
        color: white; border: none; border-radius: 10px;
        font-size: 0.84rem; font-weight: 600; text-decoration: none;
        box-shadow: 0 4px 12px rgba(5,38,89,0.18); transition: all 0.2s;
    }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(5,38,89,0.28); color: white; }
    .btn-add svg { width: 16px; height: 16px; }

    .filter-bar { background: white; border-radius: 14px; border: 1px solid #e8edf5; padding: 16px 20px; margin-bottom: 20px; display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 0.75rem; font-weight: 600; color: #64748b; }
    .filter-group input, .filter-group select {
        padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: 0.83rem; color: var(--navy-darkest); background: #fafbff;
        outline: none; transition: border-color 0.2s; min-width: 160px;
    }
    .filter-group input:focus, .filter-group select:focus { border-color: var(--navy-dark); }
    .btn-filter { padding: 8px 18px; background: var(--navy-dark); color: white; border: none; border-radius: 8px; font-size: 0.83rem; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-filter:hover { background: var(--navy-darkest); color: white; }
    .btn-reset { padding: 8px 14px; background: #f1f5f9; color: #64748b; border: none; border-radius: 8px; font-size: 0.83rem; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .btn-reset:hover { background: #e2e8f0; color: #374151; }

    .card { background: white; border-radius: 16px; border: 1px solid #e8edf5; box-shadow: 0 1px 4px rgba(0,0,0,0.05); overflow: hidden; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th { background: #f8faff; padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e8edf5; white-space: nowrap; }
    tbody td { padding: 13px 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.84rem; color: var(--navy-darkest); vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #f8faff; }

    .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 0.73rem; font-weight: 600; }
    .badge-masuk  { background: #dcfce7; color: #15803d; }
    .badge-keluar { background: #fff1f2; color: #e11d48; }
    .badge-internal { background: #fef9c3; color: #a16207; }

    .action-group { display: flex; gap: 6px; }
    .btn-action { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .btn-action svg { width: 15px; height: 15px; }
    .btn-view   { background: #eff6ff; color: #3b82f6; }
    .btn-view:hover   { background: #dbeafe; }
    .btn-edit   { background: #f0fdf4; color: #16a34a; }
    .btn-edit:hover   { background: #dcfce7; }
    .btn-delete { background: #fff1f2; color: #e11d48; }
    .btn-delete:hover { background: #ffe4e6; }

    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state svg { width: 48px; height: 48px; margin: 0 auto 12px; opacity: 0.4; }
    .empty-state p { font-size: 0.9rem; }

    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #f1f5f9; }
    .alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 8px; }
    .summary-bar { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
    .summary-chip { background: white; border: 1px solid #e8edf5; border-radius: 20px; padding: 5px 14px; font-size: 0.78rem; font-weight: 600; color: #64748b; }
    .summary-chip span { color: var(--navy-darkest); }
</style>

{{-- Alert --}}
@if(session('success'))
<div class="alert-success">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Header --}}
<div class="page-header">
    <div>
        <div class="page-header__title">Mutasi Siswa</div>
        <div class="page-header__sub">Kelola data mutasi masuk, keluar, dan internal siswa</div>
    </div>
    <a href="{{ route('admin.mutasi-siswa.create') }}" class="btn-add">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Mutasi
    </a>
</div>

{{-- Summary --}}
<div class="summary-bar">
    <div class="summary-chip">Total: <span>{{ $mutasi->total() }} data mutasi</span></div>
    @if(request('jenis_mutasi'))
        <div class="summary-chip">Filter: <span>{{ ucfirst(request('jenis_mutasi')) }}</span></div>
    @endif
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.mutasi-siswa.index') }}">
<div class="filter-bar">
    <div class="filter-group" style="flex:1; min-width:200px;">
        <label>Cari Nama Siswa</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama siswa...">
    </div>
    <div class="filter-group">
        <label>Jenis Mutasi</label>
        <select name="jenis_mutasi">
            <option value="">Semua Jenis</option>
            <option value="masuk"    {{ request('jenis_mutasi') == 'masuk'    ? 'selected' : '' }}>Mutasi Masuk</option>
            <option value="keluar"   {{ request('jenis_mutasi') == 'keluar'   ? 'selected' : '' }}>Mutasi Keluar</option>
            <option value="internal" {{ request('jenis_mutasi') == 'internal' ? 'selected' : '' }}>Mutasi Internal</option>
        </select>
    </div>
    <div style="display:flex; gap:8px; align-items:flex-end;">
        <button type="submit" class="btn-filter">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
            </svg>
            Cari
        </button>
        <a href="{{ route('admin.mutasi-siswa.index') }}" class="btn-reset">Reset</a>
    </div>
</div>
</form>

{{-- Table --}}
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px">No</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Mutasi</th>
                    <th>Kelas Asal</th>
                    <th>Kelas / Sekolah Tujuan</th>
                    <th>Tanggal</th>
                    <th>Dicatat Oleh</th>
                    <th style="width:120px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mutasi as $i => $m)
                <tr>
                    <td style="color:#94a3b8; font-size:0.78rem;">{{ $mutasi->firstItem() + $i }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $m->siswa->name ?? '-' }}</div>
                        <div style="font-size:0.75rem; color:#94a3b8;">{{ $m->siswa->nis ?? '' }}</div>
                    </td>
                    <td>
                        @if($m->jenis_mutasi === 'masuk')
                            <span class="badge badge-masuk">Masuk</span>
                        @elseif($m->jenis_mutasi === 'keluar')
                            <span class="badge badge-keluar">Keluar</span>
                        @else
                            <span class="badge badge-internal">Internal</span>
                        @endif
                    </td>
                    <td style="font-size:0.82rem;">{{ $m->kelasAsal->nama ?? ($m->sekolah_asal ?? '—') }}</td>
                    <td style="font-size:0.82rem;">{{ $m->kelasTujuan->nama ?? ($m->sekolah_tujuan ?? '—') }}</td>
                    <td style="font-size:0.82rem;">{{ $m->tanggal_mutasi->format('d M Y') }}</td>
                    <td style="font-size:0.82rem;">{{ $m->dicatatOleh->name ?? '—' }}</td>
                    <td>
                        <div class="action-group" style="justify-content:center;">
                            <a href="{{ route('admin.mutasi-siswa.show', $m->id) }}" class="btn-action btn-view" title="Detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('admin.mutasi-siswa.edit', $m->id) }}" class="btn-action btn-edit" title="Edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.mutasi-siswa.destroy', $m->id) }}" style="display:inline;" onsubmit="return confirm('Hapus data mutasi ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <p>Belum ada data mutasi siswa.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($mutasi->hasPages())
    <div class="pagination-wrap">
        {{ $mutasi->links() }}
    </div>
    @endif
</div>
@endsection