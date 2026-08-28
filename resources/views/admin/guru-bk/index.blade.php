@extends('layouts.admin')

@section('title', 'Manajemen Guru BK')
@section('page-title', 'Guru BK')

@section('content')
<style>
    .page-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;flex-wrap:wrap;gap:12px}
    .page-header h1{font-size:1.35rem;font-weight:700;color:#0f172a;margin:0}
    .page-header p{font-size:0.82rem;color:#64748b;margin:4px 0 0}
    .btn-add{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:linear-gradient(135deg,#1e3a5f,#0f2440);color:white;border-radius:10px;font-size:0.85rem;font-weight:600;text-decoration:none;transition:all .2s}
    .btn-add:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(15,36,64,.3)}

    .filter-card{background:white;border:1px solid #e8edf5;border-radius:14px;padding:20px 24px;margin-bottom:20px;box-shadow:0 1px 4px rgba(0,0,0,.04)}
    .filter-grid{display:grid;grid-template-columns:1fr 200px auto auto;gap:12px;align-items:end}
    @media(max-width:768px){.filter-grid{grid-template-columns:1fr 1fr;}}
    .filter-label{font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px;display:block}
    .filter-input{width:100%;padding:9px 13px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:0.84rem;color:#0f172a;font-family:inherit;background:white;transition:border .2s;box-sizing:border-box}
    .filter-input:focus{outline:none;border-color:#1e3a5f}
    .btn-cari{padding:9px 20px;background:linear-gradient(135deg,#1e3a5f,#0f2440);color:white;border:none;border-radius:9px;font-size:0.84rem;font-weight:600;cursor:pointer;white-space:nowrap;transition:all .2s}
    .btn-cari:hover{transform:translateY(-1px)}
    .btn-reset{padding:9px 16px;background:#f1f5f9;color:#64748b;border:none;border-radius:9px;font-size:0.84rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;white-space:nowrap}
    .btn-reset:hover{background:#e2e8f0}

    .stats-row{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px}
    .stat-chip{padding:6px 14px;border-radius:20px;font-size:0.78rem;font-weight:600}
    .stat-chip--all{background:#eef2ff;color:#3730a3}
    .stat-chip--assigned{background:#dcfce7;color:#166534}
    .stat-chip--unassigned{background:#fef3c7;color:#92400e}

    .card{background:white;border:1px solid #e8edf5;border-radius:14px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.04)}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse}
    thead tr{background:#f8faff}
    th{padding:12px 16px;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;text-align:left;border-bottom:1px solid #e8edf5}
    td{padding:13px 16px;font-size:0.84rem;color:#1e293b;border-bottom:1px solid #f1f5f9;vertical-align:middle}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#fafbff}

    .guru-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#1e3a5f,#2d5a9e);color:white;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;flex-shrink:0}
    .guru-info{display:flex;align-items:center;gap:10px}
    .guru-name{font-weight:600;color:#0f172a}
    .guru-nip{font-size:0.75rem;color:#94a3b8;margin-top:1px}

    .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600}
    .badge--assigned{background:#dcfce7;color:#166534}
    .badge--unassigned{background:#fef3c7;color:#92400e}
    .badge--laki{background:#dbeafe;color:#1e40af}
    .badge--perempuan{background:#fce7f3;color:#9d174d}

    .kelas-chips{display:flex;flex-wrap:wrap;gap:4px}
    .kelas-chip{padding:2px 8px;background:#eef2ff;color:#3730a3;border-radius:6px;font-size:0.73rem;font-weight:600}

    .action-btns{display:flex;gap:6px;flex-wrap:wrap}
    .btn-sm{display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:7px;font-size:0.78rem;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:all .2s}
    .btn-edit{background:#eef2ff;color:#3730a3}
    .btn-edit:hover{background:#e0e7ff}
    .btn-reset-pw{background:#fef3c7;color:#92400e}
    .btn-reset-pw:hover{background:#fde68a}
    .btn-danger{background:#fde8e8;color:#dc2626}
    .btn-danger:hover{background:#fecaca}

    .hasil-info{padding:10px 16px;background:#f0f9ff;border-bottom:1px solid #e0f2fe;font-size:0.82rem;color:#0369a1}
    .empty-state{text-align:center;padding:48px 24px;color:#94a3b8}
    .empty-state svg{width:48px;height:48px;margin:0 auto 12px;display:block;opacity:.4}
    .empty-state__title{font-size:0.95rem;font-weight:600;color:#64748b;margin-bottom:4px}
    .empty-state__sub{font-size:0.82rem}
</style>

{{-- Header --}}
<div class="page-header">
    <div>
        <h1>Manajemen Guru BK</h1>
        <p>Kelola data dan penugasan Guru Bimbingan Konseling</p>
    </div>
    <a href="{{ route('admin.guru-bk.create') }}" class="btn-add">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Guru BK
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
<div style="background:#dcfce7;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:0.84rem;display:flex;align-items:center;gap:8px">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- Filter --}}
<div class="filter-card">
    <form method="GET" action="{{ route('admin.guru-bk.index') }}">
        <div class="filter-grid">
            <div>
                <label class="filter-label">CARI GURU BK</label>
                <input type="text" name="search" class="filter-input" placeholder="Nama, NIP, atau email..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="filter-label">STATUS PENUGASAN</label>
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="assigned"   {{ request('status') === 'assigned'   ? 'selected' : '' }}>Sudah Ditugaskan</option>
                    <option value="unassigned" {{ request('status') === 'unassigned' ? 'selected' : '' }}>Belum Ditugaskan</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn-cari">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;display:inline;margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
                    Cari
                </button>
            </div>
            <div>
                <a href="{{ route('admin.guru-bk.index') }}" class="btn-reset">Reset</a>
            </div>
        </div>
    </form>
</div>

{{-- Stats --}}
@php
    $assigned   = $gurubks->filter(fn($g) => $g->kelasBindaan->count() > 0)->count();
    $unassigned = $gurubks->filter(fn($g) => $g->kelasBindaan->count() === 0)->count();
@endphp
<div class="stats-row">
    <span class="stat-chip stat-chip--all"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;display:inline;margin-right:4px;vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Total: {{ $gurubks->count() }} Guru BK</span>
    <span class="stat-chip stat-chip--assigned"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;display:inline;margin-right:4px;vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Ditugaskan: {{ $assigned }}</span>
    <span class="stat-chip stat-chip--unassigned"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;display:inline;margin-right:4px;vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Belum Ditugaskan: {{ $unassigned }}</span>
</div>

{{-- Tabel --}}
<div class="card">
    @if(request()->anyFilled(['search','status']))
    <div class="hasil-info">
        Menampilkan <strong>{{ $gurubks->count() }}</strong> hasil pencarian
        @if(request('search')) untuk "<strong>{{ request('search') }}</strong>"@endif
    </div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Guru BK</th>
                    <th>Jenis Kelamin</th>
                    <th>No HP</th>
                    <th>Kelas Binaan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurubks as $index => $guru)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="guru-info">
                            <div class="guru-avatar">{{ strtoupper(substr($guru->name, 0, 2)) }}</div>
                            <div>
                                <div class="guru-name">{{ $guru->name }}</div>
                                <div class="guru-nip">NIP: {{ $guru->nip ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge--{{ $guru->jenis_kelamin === 'Laki-laki' ? 'laki' : 'perempuan' }}">
                            {{ $guru->jenis_kelamin ?? '-' }}
                        </span>
                    </td>
                    <td>{{ $guru->no_hp ?? '-' }}</td>
                    <td>
                        @if($guru->kelasBindaan->count() > 0)
                            <div class="kelas-chips">
                                @foreach($guru->kelasBindaan as $k)
                                    <span class="kelas-chip">{{ $k->nama }}</span>
                                @endforeach
                            </div>
                        @else
                            <span style="color:#94a3b8;font-size:0.8rem">Belum ada</span>
                        @endif
                    </td>
                    <td>
                        @if($guru->kelasBindaan->count() > 0)
                            <span class="badge badge--assigned"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px;display:inline;margin-right:3px;vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Ditugaskan</span>
                        @else
                            <span class="badge badge--unassigned"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px;display:inline;margin-right:3px;vertical-align:middle"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>Belum</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.guru-bk.edit', $guru) }}" class="btn-sm btn-edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.guru-bk.reset-password', $guru) }}" style="display:inline" onsubmit="return confirm('Reset password {{ $guru->name }} ke default?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-sm btn-reset-pw">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                    Reset PW
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.guru-bk.destroy', $guru) }}" style="display:inline" onsubmit="return confirm('Hapus Guru BK {{ $guru->name }}? Kelas binaan akan dilepas.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div class="empty-state__title">
                                @if(request()->anyFilled(['search','status']))
                                    Tidak ada Guru BK yang cocok
                                @else
                                    Belum ada Guru BK
                                @endif
                            </div>
                            <div class="empty-state__sub">
                                @if(request()->anyFilled(['search','status']))
                                    Coba ubah kata kunci atau filter
                                @else
                                    Klik tombol "Tambah Guru BK" untuk memulai
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
