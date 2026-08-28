@extends('layouts.guru')
@section('title', 'Pelanggaran & Poin')
@section('page-title', 'Pelanggaran & Poin')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .page-header__title { font-size:1.1rem; font-weight:700; color:var(--navy-darkest); }
    .page-header__sub { font-size:0.78rem; color:#64748b; margin-top:2px; }
    .btn-add { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; background:var(--maroon-mid); color:white; border-radius:10px; font-size:0.83rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-add:hover { background:var(--maroon-dark); color:white; }
    .card { background:white; border-radius:14px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; }
    .filter-bar { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; justify-content:flex-start; }
    .filter-group { display:flex; flex-direction:column; gap:4px; flex:1; min-width:160px; }
    .filter-group label { font-size:0.72rem; font-weight:600; color:#64748b; }
    .filter-group input, .filter-group select { padding:7px 10px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.82rem; color:#1e293b; background:white; width:100%; }
    .filter-group input:focus, .filter-group select:focus { border-color:var(--navy-mid); outline:none; }
    .btn-filter { padding:8px 24px; background:var(--navy-dark); color:white; border:none; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer; align-self:flex-end; white-space:nowrap; }
    .btn-reset { padding:8px 20px; background:white; color:#64748b; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer; text-decoration:none; align-self:flex-end; white-space:nowrap; }
    .table-wrap { overflow-x:auto; border-radius:14px; }
    table { width:100%; border-collapse:collapse; }
    th { font-size:0.72rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; padding:12px 16px; text-align:left; border-bottom:2px solid #f1f5f9; background:#fafbfc; white-space:nowrap; }
    th:first-child { border-top-left-radius:14px; }
    th:last-child { border-top-right-radius:14px; }
    td { font-size:0.83rem; color:#1e293b; padding:12px 16px; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#fafbff; }
    .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
    .badge-poin { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; font-weight:700; }
    .action-btns { display:flex; gap:6px; }
    .btn-icon { width:30px; height:30px; border-radius:7px; border:none; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; transition:all 0.2s; text-decoration:none; }
    .btn-icon svg { width:14px; height:14px; }
    .btn-view { background:#eff6ff; color:#1d4ed8; }
    .btn-view:hover { background:#dbeafe; }
    .btn-edit { background:#f0fdf4; color:#15803d; }
    .btn-edit:hover { background:#dcfce7; }
    .btn-del { background:#fef2f2; color:#dc2626; }
    .btn-del:hover { background:#fee2e2; }
    .empty-state { text-align:center; padding:48px 20px; color:#94a3b8; }
    .empty-state svg { width:48px; height:48px; margin:0 auto 12px; opacity:0.35; display:block; }
    .siswa-info { display:flex; flex-direction:column; }
    .siswa-name { font-weight:600; font-size:0.83rem; }
    .siswa-nis { font-size:0.72rem; color:#64748b; }
    .pagination-wrap { padding:16px 20px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; }
    .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
    .card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
</style>

<div class="page-header">
    <div>
        <div class="page-header__title">Pelanggaran & Poin</div>
        <div class="page-header__sub">Catatan pelanggaran siswa</div>
    </div>
    <a href="{{ route('guru-bk.pelanggaran.create') }}" class="btn-add">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Pelanggaran
    </a>
</div>

{{-- FILTER CARD --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
        <span class="card-header-title">Filter & Pencarian</span>
    </div>
    <div class="filter-bar" style="border-bottom:none;">
        <form method="GET" action="{{ route('guru-bk.pelanggaran.index') }}" style="width:100%;">
            <div style="display:grid; grid-template-columns:1fr 1fr auto; gap:14px; align-items:flex-end;">
                <div class="filter-group">
                    <label>Cari Siswa</label>
                    <input type="text" name="siswa" value="{{ request('siswa') }}" placeholder="Nama atau NIS...">
                </div>
                <div class="filter-group">
                    <label>Jenis Pelanggaran</label>
                    <select name="jenis">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisList as $j)
                            <option value="{{ $j->id }}" {{ request('jenis') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn-filter">Cari</button>
                    <a href="{{ route('guru-bk.pelanggaran.index') }}" class="btn-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- DATA CARD --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
        <span class="card-header-title">Data Pelanggaran & Poin</span>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Siswa</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Tanggal</th>
                    <th>Poin & Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggarans as $i => $p)
                <tr>
                    <td style="color:#94a3b8;font-size:0.78rem;">{{ $pelanggarans->firstItem() + $i }}</td>
                    <td>
                        <div class="siswa-info">
                            <span class="siswa-name">{{ $p->siswa->name }}</span>
                            <span class="siswa-nis">{{ $p->siswa->nis }}</span>
                        </div>
                    </td>
                    <td style="font-size:0.82rem;">{{ $p->jenisPelanggaran->nama ?? '-' }}</td>
                    <td style="color:#475569;white-space:nowrap;">{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $totalPoin = $p->siswa->pelanggarans->sum('poin');
                            $level = \App\Helpers\ThresholdHelper::getLevel($totalPoin);
                            $styles = [
                                'aman'   => 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;',
                                'kuning' => 'background:#fefce8;color:#a16207;border:1px solid #fde047;',
                                'merah'  => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                                'hitam'  => 'background:#1e1e2e;color:#f8fafc;border:1px solid #374151;',
                            ];
                            $icons = [
                                'aman'   => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                'kuning' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>',
                                'merah'  => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374L10.051 3.378c.866-1.5 3.032-1.5 3.898 0l7.354 12.748z"/></svg>',
                                'hitam'  => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                            ];
                            $labels = ['aman'=>'Aman','kuning'=>'Peringatan','merah'=>'Tindakan','hitam'=>'Kritis'];
                        @endphp
                        <div style="display:flex;flex-direction:column;gap:4px;">
                            <span class="badge badge-poin">{{ $p->poin }} poin</span>
                            <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:0.68rem;font-weight:700;{{ $styles[$level] }}">
                                {!! $icons[$level] !!} Total: {{ $totalPoin }} poin — {{ $labels[$level] }}
                            </span>
                        </div>
                    </td>
                    <td style="font-size:0.8rem;color:#64748b;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ $p->keterangan ?? '-' }}
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('guru-bk.pelanggaran.show', $p) }}" class="btn-icon btn-view" title="Detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </a>
                            <a href="{{ route('guru-bk.pelanggaran.edit', $p) }}" class="btn-icon btn-edit" title="Edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('guru-bk.pelanggaran.destroy', $p) }}" onsubmit="return confirm('Hapus data pelanggaran ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-del" title="Hapus">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                            Belum ada data pelanggaran
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pelanggarans->hasPages())
    <div class="pagination-wrap">{{ $pelanggarans->links() }}</div>
    @endif
</div>
@endsection