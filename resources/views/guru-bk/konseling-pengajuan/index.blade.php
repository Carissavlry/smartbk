@extends('layouts.guru')

@section('title', 'Pengajuan Konseling')
@section('page-title', 'Pengajuan Konseling')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.25rem; font-weight:700; color:var(--navy-darkest); margin:0; }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin:2px 0 0; }
    .stat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
    .stat-card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); padding:18px 20px; display:flex; align-items:center; gap:14px; }
    .stat-icon { width:44px; height:44px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .stat-icon-warning { background:#fef9c3; color:#ca8a04; }
    .stat-icon-success { background:#dcfce7; color:#16a34a; }
    .stat-icon-danger { background:#fee2e2; color:#dc2626; }
    .stat-val { font-size:1.5rem; font-weight:800; color:var(--navy-darkest); line-height:1; }
    .stat-label { font-size:0.75rem; color:#64748b; margin-top:3px; }
    .card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); margin-bottom:20px; overflow:hidden; }
    .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
    .card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
    .filter-input { padding:8px 12px 8px 32px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.82rem; color:#1e293b; background:#fff; outline:none; width:100%; box-sizing:border-box; }
    .filter-input:focus { border-color:var(--navy-dark); }
    .filter-select { padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.82rem; color:#1e293b; background:#fff; outline:none; cursor:pointer; width:100%; box-sizing:border-box; }
    .filter-select:focus { border-color:var(--navy-dark); }
    .filter-label { font-size:0.72rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:4px; display:block; }
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.82rem; }
    thead th { background:#f8fafc; padding:11px 16px; text-align:left; font-weight:700; color:#64748b; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid #e2e8f0; white-space:nowrap; }
    tbody td { padding:13px 16px; border-bottom:1px solid #f1f5f9; color:#1e293b; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover { background:#f8fafc; }
    .siswa-name { font-weight:600; color:#1e293b; }
    .siswa-sub { font-size:0.72rem; color:#94a3b8; }
    .badge { display:inline-flex; align-items:center; gap:4px; padding:4px 12px; border-radius:20px; font-size:0.72rem; font-weight:700; }
    .badge-warning { background:#fef9c3; color:#854d0e; }
    .badge-success { background:#dcfce7; color:#166534; }
    .badge-danger { background:#fee2e2; color:#991b1b; }
    .badge-info { background:#dbeafe; color:#1e40af; }
    .badge-secondary { background:#f1f5f9; color:#475569; }
    .btn-icon { width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; transition:all .15s; text-decoration:none; }
    .btn-icon-view { background:#eff6ff; color:#2563eb; }
    .btn-icon-view:hover { background:#dbeafe; }
    .empty-state { text-align:center; padding:48px 20px; color:#94a3b8; }
    .empty-state svg { width:48px; height:48px; margin:0 auto 12px; display:block; opacity:.4; }
    .empty-state p { font-size:0.85rem; }
    .alert-success { background:#dcfce7; color:#166534; padding:12px 18px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; font-weight:600; display:flex; align-items:center; gap:10px; }
    .alert-danger { background:#fee2e2; color:#991b1b; padding:12px 18px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; font-weight:600; display:flex; align-items:center; gap:10px; }
    .pagination-wrap { padding:16px 20px; border-top:1px solid #f1f5f9; }
    .btn-cari { padding:8px 18px; background:var(--navy-dark); color:#fff; border:none; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; }
    .btn-reset { padding:8px 14px; background:#f1f5f9; color:#475569; border:none; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; }
    .btn-reset:hover { background:#e2e8f0; }
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-header__title">Pengajuan Konseling</h1>
        <p class="page-header__sub">Kelola pengajuan konseling dari siswa binaan</p>
    </div>
</div>

{{-- FLASH --}}
@if(session('success'))
<div class="alert-success">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert-danger">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
    </svg>
    {{ session('error') }}
</div>
@endif

{{-- STATISTIK --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon stat-icon-warning">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:22px;height:22px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $totalMenunggu }}</div>
            <div class="stat-label">Menunggu Respons</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-success">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:22px;height:22px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $totalDisetujui }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-danger">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:22px;height:22px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $totalDitolak }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>
</div>

{{-- FILTER BAR --}}
<div class="card" style="margin-bottom:20px;">
    <div style="padding:16px 20px;">
        <form method="GET" action="{{ route('guru-bk.konseling-pengajuan.index') }}"
              style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">

            {{-- CARI NAMA / NIS --}}
            <div style="display:flex;flex-direction:column;flex:1;min-width:180px;">
                <label class="filter-label">Cari Nama / NIS</label>
                <div style="position:relative;">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                         style="width:14px;height:14px;position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;pointer-events:none;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama atau NIS siswa..."
                           class="filter-input">
                </div>
            </div>

            {{-- FILTER STATUS --}}
            <div style="display:flex;flex-direction:column;min-width:155px;">
                <label class="filter-label">Status</label>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu"   {{ request('status') === 'menunggu'   ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui"  {{ request('status') === 'disetujui'  ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak"    {{ request('status') === 'ditolak'    ? 'selected' : '' }}>Ditolak</option>
                    <option value="reschedule" {{ request('status') === 'reschedule' ? 'selected' : '' }}>Reschedule</option>
                    <option value="selesai"    {{ request('status') === 'selesai'    ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- FILTER KELAS --}}
            <div style="display:flex;flex-direction:column;min-width:155px;">
                <label class="filter-label">Kelas Binaan</label>
                <select name="kelas_id" class="filter-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TOMBOL AKSI --}}
            <div style="display:flex;gap:8px;align-items:flex-end;">
                <button type="submit" class="btn-cari">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    Cari
                </button>
                @if(request()->hasAny(['search','status','kelas_id']))
                <a href="{{ route('guru-bk.konseling-pengajuan.index') }}" class="btn-reset">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reset
                </a>
                @endif
            </div>

        </form>
    </div>
</div>

{{-- TABEL --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
        </svg>
        <span class="card-header-title">Daftar Pengajuan Konseling</span>
    </div>
    <div class="table-wrap">
        @if($pengajuans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Siswa</th>
                    <th>Topik</th>
                    <th>Tanggal Diajukan</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th style="width:80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuans as $i => $item)
                <tr>
                    <td>{{ $pengajuans->firstItem() + $i }}</td>
                    <td>
                        <div class="siswa-name">{{ $item->siswa->name }}</div>
                        <div class="siswa-sub">{{ $item->siswa->nis ?? $item->siswa->username ?? '-' }}</div>
                    </td>
                    <td style="max-width:200px;">
                        <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $item->topik }}
                        </span>
                    </td>
                    <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($item->tanggal_diajukan)->format('d M Y') }}</td>
                    <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($item->jam_diajukan)->format('H:i') }} WIB</td>
                    <td>
                        @php
                            $badgeClass = match($item->status) {
                                'menunggu'   => 'badge-warning',
                                'disetujui'  => 'badge-success',
                                'ditolak'    => 'badge-danger',
                                'reschedule' => 'badge-info',
                                'selesai'    => 'badge-secondary',
                                default      => 'badge-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $item->status_label }}</span>
                    </td>
                    <td>
                        <a href="{{ route('guru-bk.konseling-pengajuan.show', $item->id) }}" class="btn-icon btn-icon-view" title="Detail">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
            <p>Belum ada pengajuan konseling</p>
        </div>
        @endif
    </div>
    @if($pengajuans->hasPages())
    <div class="pagination-wrap">
        {{ $pengajuans->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection