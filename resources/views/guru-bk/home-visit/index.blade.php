@extends('layouts.guru')

@section('title', 'Home Visit')

@section('page-title', 'Home Visit')

@section('content')

<style>
    .btn-primary { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; background:var(--navy-dark); color:white; border:none; border-radius:10px; font-size:0.83rem; font-weight:600; text-decoration:none; cursor:pointer; }
    .btn-primary:hover { background:var(--navy-darkest); }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; overflow:hidden; }
    .card-header { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
    .card-header-title { font-size:0.82rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; display:flex; align-items:center; gap:8px; }
    .card-body { padding:20px; }
    .search-row { display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
    .search-group { display:flex; flex-direction:column; gap:5px; }
    .search-group label { font-size:0.75rem; font-weight:600; color:#374151; }
    .form-control { padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.83rem; color:#1e293b; background:white; }
    .form-control:focus { outline:none; border-color:var(--navy-dark); }
    .btn-search { padding:8px 16px; background:var(--navy-dark); color:white; border:none; border-radius:9px; font-size:0.83rem; font-weight:600; cursor:pointer; }
    .btn-reset { padding:8px 14px; background:white; color:#374151; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.83rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; }
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.83rem; }
    thead tr { background:#f8fafc; }
    th { padding:11px 14px; text-align:left; font-size:0.75rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid #e8edf5; white-space:nowrap; }
    td { padding:12px 14px; border-bottom:1px solid #f1f5f9; color:#1e293b; vertical-align:middle; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#fafbff; }
    .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-selesai { background:#dcfce7; color:#16a34a; }
    .badge-proses { background:#fef9c3; color:#ca8a04; }
    .badge-draft { background:#f1f5f9; color:#64748b; }
    .nomor-surat { font-size:0.75rem; color:#64748b; font-family:monospace; background:#f8fafc; padding:2px 7px; border-radius:5px; }
    .foto-count { display:inline-flex; align-items:center; gap:4px; font-size:0.78rem; color:#64748b; }
    .btn-show { display:inline-flex; align-items:center; gap:4px; padding:5px 12px; background:#eff6ff; color:#1d4ed8; border-radius:7px; font-size:0.78rem; font-weight:600; text-decoration:none; }
    .btn-show:hover { background:#dbeafe; }
    .btn-edit { display:inline-flex; align-items:center; gap:4px; padding:5px 12px; background:#f0fdf4; color:#16a34a; border-radius:7px; font-size:0.78rem; font-weight:600; text-decoration:none; }
    .btn-edit:hover { background:#dcfce7; }
    .btn-del { display:inline-flex; align-items:center; gap:4px; padding:5px 12px; background:#fff1f2; color:#e11d48; border-radius:7px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; }
    .btn-del:hover { background:#ffe4e6; }
    .empty-state { text-align:center; padding:48px 20px; color:#94a3b8; }
    .empty-state svg { width:48px; height:48px; margin:0 auto 12px; display:block; opacity:0.4; }
    .empty-state p { font-size:0.88rem; }
    .pagination-wrap { padding:16px 20px; border-top:1px solid #f1f5f9; }
</style>

{{-- HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <div>
        <h2 style="font-size:1.1rem; font-weight:700; color:var(--navy-darkest); margin:0;">Kunjungan Rumah (Home Visit)</h2>
        <p style="font-size:0.82rem; color:#64748b; margin:4px 0 0;">Total {{ $homeVisits->total() }} data kunjungan</p>
    </div>
    <a href="{{ route('guru-bk.home-visit.create') }}" class="btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Kunjungan
    </a>
</div>

{{-- FLASH MESSAGE --}}
@if(session('success'))
<div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px 18px; margin-bottom:16px; font-size:0.83rem; color:#16a34a; display:flex; align-items:center; gap:8px;">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- SEARCH CARD --}}
<div class="card">
    <div class="card-header">
        <span class="card-header-title">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
            Filter & Pencarian
        </span>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('guru-bk.home-visit.index') }}">
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:14px; align-items:flex-end;">

                <div style="display:flex; flex-direction:column; gap:5px;">
                    <label style="font-size:0.75rem; font-weight:600; color:#374151;">Cari Siswa</label>
                    <input type="text" name="search" class="form-control"
                        placeholder="Nama siswa..."
                        value="{{ request('search') }}">
                </div>

                <div style="display:flex; flex-direction:column; gap:5px;">
                    <label style="font-size:0.75rem; font-weight:600; color:#374151;">Kelas</label>
                    <select name="kelas_id" class="form-control">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex; flex-direction:column; gap:5px;">
                    <label style="font-size:0.75rem; font-weight:600; color:#374151;">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ request('tanggal') }}">
                </div>

                <div style="display:flex; gap:8px; padding-bottom:1px;">
                    <button type="submit" class="btn-primary" style="padding:8px 18px;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
                        Cari
                    </button>
                    <a href="{{ route('guru-bk.home-visit.index') }}" class="btn-reset">Reset</a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="card">
    <div class="card-header">
        <span class="card-header-title">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Daftar Kunjungan Rumah
        </span>
    </div>
    <div class="table-wrap">
        @if($homeVisits->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Nomor Surat</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Tujuan</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($homeVisits as $i => $hv)
                <tr>
                    <td>{{ $homeVisits->firstItem() + $i }}</td>
                    <td>
                        @if($hv->nomor_surat)
                            <span class="nomor-surat">{{ $hv->nomor_surat }}</span>
                        @else
                            <span style="color:#cbd5e1;">—</span>
                        @endif
                    </td>
                    <td style="font-weight:600; color:var(--navy-darkest);">{{ $hv->siswa->name ?? '-' }}</td>
                    <td style="color:#64748b;">{{ $hv->siswa->kelas->nama ?? '-' }}</td>
                    <td style="white-space:nowrap;">{{ $hv->tanggal->format('d M Y') }}</td>
                    <td style="white-space:nowrap; color:#64748b;">
                        @if($hv->jam_mulai)
                            {{ \Carbon\Carbon::parse($hv->jam_mulai)->format('H:i') }}
                            @if($hv->jam_selesai)
                                – {{ \Carbon\Carbon::parse($hv->jam_selesai)->format('H:i') }}
                            @endif
                        @else
                            <span style="color:#cbd5e1;">—</span>
                        @endif
                    </td>
                    <td style="max-width:200px;">
                        <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $hv->tujuan }}
                        </span>
                    </td>
                    <td>
                        <span class="foto-count">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $hv->fotos->count() }}
                        </span>
                    </td>
                    <td>
                        @php
                            $status = $hv->status ?? 'draft';
                            $badgeClass = match($status) {
                                'selesai' => 'badge-selesai',
                                'proses'  => 'badge-proses',
                                default   => 'badge-draft',
                            };
                            $statusLabel = match($status) {
                                'selesai' => 'Selesai',
                                'proses'  => 'Proses',
                                default   => 'Draft',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            <a href="{{ route('guru-bk.home-visit.show', $hv) }}" class="btn-show">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                            <a href="{{ route('guru-bk.home-visit.edit', $hv) }}" class="btn-edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('guru-bk.home-visit.destroy', $hv) }}"
                                  onsubmit="return confirm('Hapus data kunjungan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
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
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <p>Belum ada data kunjungan rumah.</p>
            <a href="{{ route('guru-bk.home-visit.create') }}" class="btn-primary" style="margin-top:12px;">Tambah Kunjungan Pertama</a>
        </div>
        @endif
    </div>
    @if($homeVisits->count() > 0)
    <div class="pagination-wrap">
        {{ $homeVisits->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection