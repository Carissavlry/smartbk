@extends('layouts.admin')

@section('title', 'Jenis Pelanggaran')
@section('page-title', 'Data Master')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-primary { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; background:var(--navy-dark); color:white; border-radius:10px; font-size:0.83rem; font-weight:600; text-decoration:none; transition:all 0.2s; border:none; cursor:pointer; }
    .btn-primary:hover { background:var(--navy-darkest); color:white; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .filter-grid { display:grid; grid-template-columns:2fr 1fr 1fr auto; gap:12px; align-items:end; }
    .form-group { display:flex; flex-direction:column; gap:5px; }
    .form-group label { font-size:0.78rem; font-weight:600; color:#374151; }
    .form-group input, .form-group select { padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.83rem; color:#1e293b; background:white; transition:border 0.2s; }
    .form-group input:focus, .form-group select:focus { border-color:var(--navy-mid); outline:none; }
    .btn-filter { padding:8px 16px; background:var(--navy-dark); color:white; border:none; border-radius:9px; font-size:0.83rem; font-weight:600; cursor:pointer; }
    .btn-reset { padding:8px 16px; background:white; color:#64748b; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.83rem; font-weight:600; text-decoration:none; }
    .stats-row { display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap; }
    .stat-pill { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:0.78rem; font-weight:600; }
    .stat-all { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .stat-ringan { background:#fefce8; color:#854d0e; border:1px solid #fde68a; }
    .stat-sedang { background:#fff7ed; color:#9a3412; border:1px solid #fed7aa; }
    .stat-berat { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    table { width:100%; border-collapse:collapse; }
    thead th { font-size:0.73rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; padding:10px 14px; border-bottom:2px solid #e8edf5; text-align:left; }
    tbody td { padding:12px 14px; border-bottom:1px solid #f1f5f9; font-size:0.85rem; color:#1e293b; vertical-align:middle; }
    tbody tr:hover { background:#f8fafc; }
    tbody tr:last-child td { border-bottom:none; }
    .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:0.73rem; font-weight:600; }
    .badge-yellow { background:#fefce8; color:#854d0e; border:1px solid #fde68a; }
    .badge-orange { background:#fff7ed; color:#9a3412; border:1px solid #fed7aa; }
    .badge-red { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .badge-green { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .badge-gray { background:#f8fafc; color:#64748b; border:1px solid #e2e8f0; }
    .poin-badge { display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:50%; font-size:0.82rem; font-weight:700; }
    .poin-ringan { background:#fefce8; color:#854d0e; }
    .poin-sedang { background:#fff7ed; color:#9a3412; }
    .poin-berat { background:#fef2f2; color:#991b1b; }
    .action-btn { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; border:1.5px solid; transition:all 0.2s; text-decoration:none; }
    .btn-edit { color:#2563eb; border-color:#bfdbfe; background:#eff6ff; }
    .btn-edit:hover { background:#dbeafe; }
    .btn-delete { color:#dc2626; border-color:#fecaca; background:#fef2f2; }
    .btn-delete:hover { background:#fee2e2; }
    .btn-toggle { color:#16a34a; border-color:#bbf7d0; background:#f0fdf4; }
    .btn-toggle:hover { background:#dcfce7; }
    .empty-state { text-align:center; padding:48px 20px; color:#94a3b8; }
    .empty-state svg { width:48px; height:48px; margin:0 auto 12px; display:block; opacity:0.4; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Master Jenis Pelanggaran</div>
        <div class="page-header__sub">Kelola jenis pelanggaran dan poin sanksi</div>
    </div>
    <a href="{{ route('admin.jenis-pelanggaran.create') }}" class="btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Jenis
    </a>
</div>

@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 18px;margin-bottom:20px;font-size:0.83rem;color:#15803d;display:flex;align-items:center;gap:8px;">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- Filter --}}
<div class="card" style="margin-bottom:16px;">
    <form method="GET" action="{{ route('admin.jenis-pelanggaran.index') }}">
        <div class="filter-grid">
            <div class="form-group">
                <label>CARI PELANGGARAN</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Ketik nama pelanggaran...">
            </div>
            <div class="form-group">
                <label>KATEGORI</label>
                <select name="kategori">
                    <option value="">Semua Kategori</option>
                    <option value="ringan" {{ request('kategori') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="sedang" {{ request('kategori') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="berat"  {{ request('kategori') === 'berat'  ? 'selected' : '' }}>Berat</option>
                </select>
            </div>
            <div class="form-group">
                <label>STATUS</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <div style="display:flex;gap:8px;">
                    <button type="submit" class="btn-filter">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;display:inline;margin-right:4px;vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
                        Cari
                    </button>
                    <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="btn-reset">Reset</a>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-pill stat-all">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
        Total: {{ $data->count() }} jenis
    </div>
    <div class="stat-pill stat-ringan">Ringan: {{ $data->where('kategori','ringan')->count() }}</div>
    <div class="stat-pill stat-sedang">Sedang: {{ $data->where('kategori','sedang')->count() }}</div>
    <div class="stat-pill stat-berat">Berat: {{ $data->where('kategori','berat')->count() }}</div>
</div>

{{-- Tabel --}}
<div class="card" style="padding:0;overflow:hidden;">
    @if($data->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width:40px;">NO</th>
                <th>NAMA PELANGGARAN</th>
                <th>KATEGORI</th>
                <th style="text-align:center;">POIN</th>
                <th>DESKRIPSI</th>
                <th style="text-align:center;">STATUS</th>
                <th style="text-align:center;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $item)
            <tr>
                <td style="color:#94a3b8;font-size:0.78rem;">{{ $i + 1 }}</td>
                <td>
                    <div style="font-weight:600;color:#1e293b;">{{ $item->nama }}</div>
                </td>
                <td>
                    <span class="badge badge-{{ $item->kategori_badge === 'badge-yellow' ? 'yellow' : ($item->kategori_badge === 'badge-orange' ? 'orange' : 'red') }}">
                        {{ $item->kategori_label }}
                    </span>
                </td>
                <td style="text-align:center;">
                    <div class="poin-badge poin-{{ $item->kategori }}">{{ $item->poin }}</div>
                </td>
                <td style="color:#64748b;font-size:0.82rem;max-width:200px;">
                    {{ $item->deskripsi ?? '-' }}
                </td>
                <td style="text-align:center;">
                    @if($item->is_aktif)
                        <span class="badge badge-green">Aktif</span>
                    @else
                        <span class="badge badge-gray">Nonaktif</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <a href="{{ route('admin.jenis-pelanggaran.edit', $item) }}" class="action-btn btn-edit" title="Edit">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.jenis-pelanggaran.destroy', $item) }}"
                              onsubmit="return confirm('Hapus jenis pelanggaran {{ $item->nama }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn btn-delete" title="Hapus">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
        <div style="font-weight:600;margin-bottom:4px;">Belum ada data jenis pelanggaran</div>
        <div style="font-size:0.8rem;">Klik tombol "Tambah Jenis" untuk menambahkan data pertama.</div>
    </div>
    @endif
</div>
@endsection