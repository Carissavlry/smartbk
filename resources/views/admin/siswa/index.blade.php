@extends('layouts.admin')

@section('title', 'Manajemen Siswa')
@section('page-title', 'Siswa')

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

    /* Filter Bar */
    .filter-bar { background: white; border-radius: 14px; border: 1px solid #e8edf5; padding: 16px 20px; margin-bottom: 20px; display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 0.75rem; font-weight: 600; color: #64748b; }
    .filter-group input, .filter-group select {
        padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: 0.83rem; color: var(--navy-darkest); background: #fafbff;
        outline: none; transition: border-color 0.2s; min-width: 160px;
    }
    .filter-group input:focus, .filter-group select:focus { border-color: var(--navy-dark); }
    .btn-filter {
        padding: 8px 18px; background: var(--navy-dark); color: white;
        border: none; border-radius: 8px; font-size: 0.83rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-filter:hover { background: var(--navy-darkest); color: white; }
    .btn-reset { padding: 8px 14px; background: #f1f5f9; color: #64748b; border: none; border-radius: 8px; font-size: 0.83rem; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .btn-reset:hover { background: #e2e8f0; color: #374151; }

    /* Table */
    .card { background: white; border-radius: 16px; border: 1px solid #e8edf5; box-shadow: 0 1px 4px rgba(0,0,0,0.05); overflow: hidden; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th { background: #f8faff; padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e8edf5; white-space: nowrap; }
    tbody td { padding: 13px 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.84rem; color: var(--navy-darkest); vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #f8faff; }

    /* Avatar */
    .avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #e8edf5; }
    .avatar-placeholder { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--navy-dark), var(--navy-darkest)); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.8rem; font-weight: 700; }

    /* Badge */
    .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 0.73rem; font-weight: 600; }
    .badge-l { background: #dbeafe; color: #1d4ed8; }
    .badge-p { background: #fce7f3; color: #be185d; }

    /* Action Buttons */
    .action-group { display: flex; gap: 6px; }
    .btn-action { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .btn-action svg { width: 15px; height: 15px; }
    .btn-view { background: #eff6ff; color: #3b82f6; }
    .btn-view:hover { background: #dbeafe; }
    .btn-edit { background: #f0fdf4; color: #16a34a; }
    .btn-edit:hover { background: #dcfce7; }
    .btn-reset-pw { background: #fffbeb; color: #d97706; }
    .btn-reset-pw:hover { background: #fef3c7; }
    .btn-delete { background: #fff1f2; color: #e11d48; }
    .btn-delete:hover { background: #ffe4e6; }

    /* Empty State */
    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state svg { width: 48px; height: 48px; margin: 0 auto 12px; opacity: 0.4; }
    .empty-state p { font-size: 0.9rem; }

    /* Pagination */
    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: between; }

    /* Alert */
    .alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 8px; }

    /* Summary */
    .summary-bar { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
    .summary-chip { background: white; border: 1px solid #e8edf5; border-radius: 20px; padding: 5px 14px; font-size: 0.78rem; font-weight: 600; color: #64748b; }
    .summary-chip span { color: var(--navy-darkest); }
    /* Bulk Delete */
    .btn-select-mode { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:#f1f5f9; color:#475569; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.83rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-select-mode:hover { background:#e2e8f0; }
    .btn-select-mode.active { background:#fef2f2; color:#dc2626; border-color:#fecaca; }
    .btn-bulk-delete { display:none; align-items:center; gap:6px; padding:8px 16px; background:#dc2626; color:white; border:none; border-radius:10px; font-size:0.83rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-bulk-delete:hover { background:#b91c1c; }
    .btn-bulk-delete.show { display:inline-flex; }
    .col-check { width:40px; text-align:center; display:none; }
    .col-check.show { display:table-cell; }
    .bulk-checkbox { width:16px; height:16px; cursor:pointer; accent-color:#dc2626; }
    .alert-error { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; font-weight:500; display:flex; align-items:center; gap:8px; }
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

@if(session('error'))
<div class="alert-error">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
    </svg>
    {{ session('error') }}
</div>
@endif

{{-- Header --}}
<div class="page-header">
    <div>
        <div class="page-header__title">Manajemen Siswa</div>
        <div class="page-header__sub">Kelola data seluruh siswa terdaftar</div>
    </div>
    <div style="display:flex; gap:8px; align-items:center;">
        <button type="button" class="btn-select-mode" id="btnSelectMode" onclick="toggleSelectMode()">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span id="btnSelectText">Pilih</span>
        </button>
        <form id="formBulkDelete" method="POST" action="{{ route('admin.siswa.bulk-delete') }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <div id="checkboxContainer"></div>
            <button type="button" class="btn-bulk-delete" id="btnBulkDelete" onclick="confirmBulkDelete()">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span id="btnBulkText">Hapus yang Dipilih</span>
            </button>
        </form>
        <a href="{{ route('admin.siswa.import.form') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:#f0fdf4;color:#15803d;border:1.5px solid #86efac;border-radius:10px;font-size:0.83rem;font-weight:600;text-decoration:none;transition:all 0.2s;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            Import Excel
        </a>
        <a href="{{ route('admin.siswa.create') }}" class="btn-add">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Siswa
        </a>
    </div>
</div>

{{-- Summary --}}
<div class="summary-bar">
    <div class="summary-chip">Total: <span>{{ $siswas->total() }} siswa</span></div>
    @if(request('kelas_id'))
        <div class="summary-chip">Filter Kelas: <span>{{ $kelasList->find(request('kelas_id'))?->nama_kelas ?? '-' }}</span></div>
    @endif
    @if(request('jenis_kelamin'))
        <div class="summary-chip">Filter JK: <span>{{ request('jenis_kelamin') }}</span></div>
    @endif
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.siswa.index') }}">
<div class="filter-bar">
    <div class="filter-group" style="flex:1; min-width:200px;">
        <label>Cari Nama / NIS</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau NIS...">
    </div>
    <div class="filter-group">
        <label>Kelas</label>
        <select name="kelas_id">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                    {{ $kelas->nama }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="filter-group">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin">
            <option value="">Semua</option>
            <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
    <div style="display:flex; gap:8px; align-items:flex-end;">
        <button type="submit" class="btn-filter">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
            </svg>
            Cari
        </button>
        <a href="{{ route('admin.siswa.index') }}" class="btn-reset">Reset</a>
    </div>
</div>
</form>

{{-- Table --}}
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th class="col-check" id="thCheck">
                        <input type="checkbox" class="bulk-checkbox" id="checkAll" onclick="toggleCheckAll(this)">
                    </th>
                    <th style="width:48px">No</th>
                    <th style="width:48px">Foto</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>JK</th>
                    <th>No. HP</th>
                    <th>Orang Tua</th>
                    <th style="width:130px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $i => $siswa)
                <tr>
                    <td class="col-check">
                        <input type="checkbox" class="bulk-checkbox row-check" value="{{ $siswa->id }}">
                    </td>
                    <td style="color:#94a3b8; font-size:0.78rem;">{{ $siswas->firstItem() + $i }}</td>
                    <td>
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" class="avatar" alt="foto">
                        @else
                            <div class="avatar-placeholder">{{ strtoupper(substr($siswa->name, 0, 1)) }}</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $siswa->name }}</div>
                        @if($siswa->email)
                            <div style="font-size:0.75rem; color:#94a3b8;">{{ $siswa->email }}</div>
                        @endif
                    </td>
                    <td style="font-family: monospace; font-size:0.83rem;">{{ $siswa->nis }}</td>
                    <td>
                        @if($siswa->kelas)
                            <span style="background:#eff6ff; color:#1d4ed8; padding:3px 10px; border-radius:6px; font-size:0.78rem; font-weight:600;">
                                {{ $siswa->kelas->nama }}
                            </span>
                        @else
                            <span style="color:#cbd5e1; font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'badge-l' : 'badge-p' }}">
                            {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}
                        </span>
                    </td>
                    <td style="font-size:0.82rem;">{{ $siswa->no_hp ?? '—' }}</td>
                    <td>
                        <div style="font-size:0.82rem; font-weight:500;">{{ $siswa->nama_ortu ?? '—' }}</div>
                        @if($siswa->no_hp_ortu)
                            <div style="font-size:0.75rem; color:#94a3b8;">{{ $siswa->no_hp_ortu }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="action-group" style="justify-content:center;">
                            <a href="{{ route('admin.siswa.show', $siswa) }}" class="btn-action btn-view" title="Detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn-action btn-edit" title="Edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.siswa.reset-password', $siswa) }}" style="display:inline;" onsubmit="return confirm('Reset password ke NIS siswa ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-action btn-reset-pw" title="Reset Password">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.siswa.destroy', $siswa) }}" style="display:inline;" onsubmit="return confirm('Hapus siswa {{ $siswa->name }}? Data tidak dapat dikembalikan.')">
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
                    <td colspan="10">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p>Belum ada data siswa.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($siswas->hasPages())
    <div class="pagination-wrap">
        {{ $siswas->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
let selectMode = false;

function toggleSelectMode() {
    selectMode = !selectMode;
    const btn = document.getElementById('btnSelectMode');
    const btnText = document.getElementById('btnSelectText');
    const colChecks = document.querySelectorAll('.col-check');
    const btnBulk = document.getElementById('btnBulkDelete');

    if (selectMode) {
        btn.classList.add('active');
        btnText.textContent = 'Batal';
        colChecks.forEach(el => el.classList.add('show'));
    } else {
        btn.classList.remove('active');
        btnText.textContent = 'Pilih';
        colChecks.forEach(el => el.classList.remove('show'));
        btnBulk.classList.remove('show');
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = false);
        document.getElementById('checkAll').checked = false;
        updateBulkBtn();
    }
}

function toggleCheckAll(source) {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = source.checked);
    updateBulkBtn();
}

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('row-check')) {
        updateBulkBtn();
        const all = document.querySelectorAll('.row-check');
        const checked = document.querySelectorAll('.row-check:checked');
        document.getElementById('checkAll').checked = all.length === checked.length;
    }
});

function updateBulkBtn() {
    const checked = document.querySelectorAll('.row-check:checked');
    const btnBulk = document.getElementById('btnBulkDelete');
    const btnText = document.getElementById('btnBulkText');
    if (checked.length > 0) {
        btnBulk.classList.add('show');
        btnText.textContent = 'Hapus ' + checked.length + ' Siswa';
    } else {
        btnBulk.classList.remove('show');
        btnText.textContent = 'Hapus yang Dipilih';
    }
}

function confirmBulkDelete() {
    const checked = document.querySelectorAll('.row-check:checked');
    if (checked.length === 0) return;

    if (!confirm('Yakin hapus ' + checked.length + ' siswa? Data tidak dapat dikembalikan.')) return;

    const container = document.getElementById('checkboxContainer');
    container.innerHTML = '';
    checked.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.value;
        container.appendChild(input);
    });

    document.getElementById('formBulkDelete').submit();
}
</script>
@endpush

@endsection