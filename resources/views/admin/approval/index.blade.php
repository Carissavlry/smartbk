@extends('layouts.admin')

@section('title', 'Approval Akun')
@section('page-title', 'Approval Akun')

@section('content')
<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
    .page-header__title { font-size: 1.1rem; font-weight: 700; color: var(--navy-darkest); }
    .page-header__sub { font-size: 0.78rem; color: #64748b; margin-top: 2px; }

    .filter-bar { background: white; border-radius: 14px; border: 1px solid #e8edf5; padding: 16px 20px; margin-bottom: 20px; display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 0.75rem; font-weight: 600; color: #64748b; }
    .filter-group select { padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.83rem; color: var(--navy-darkest); background: #fafbff; outline: none; min-width: 180px; }
    .btn-filter { padding: 8px 18px; background: var(--navy-dark); color: white; border: none; border-radius: 8px; font-size: 0.83rem; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-filter:hover { background: var(--navy-darkest); color: white; }
    .btn-reset { padding: 8px 14px; background: #f1f5f9; color: #64748b; border: none; border-radius: 8px; font-size: 0.83rem; font-weight: 600; text-decoration: none; }

    .card { background: white; border-radius: 16px; border: 1px solid #e8edf5; box-shadow: 0 1px 4px rgba(0,0,0,0.05); overflow: hidden; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th { background: #f8faff; padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e8edf5; white-space: nowrap; }
    tbody td { padding: 13px 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.84rem; color: var(--navy-darkest); vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #f8faff; }

    .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 0.73rem; font-weight: 600; }
    .badge-siswa { background: #dbeafe; color: #1d4ed8; }
    .badge-guru { background: #fce7f3; color: #be185d; }
    .badge-pending { background: #fef9c3; color: #a16207; }

    .action-group { display: flex; gap: 6px; }
    .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 6px 14px; border-radius: 8px; border: none; cursor: pointer; font-size: 0.8rem; font-weight: 600; text-decoration: none; }
    .btn-approve { background: #f0fdf4; color: #16a34a; }
    .btn-approve:hover { background: #dcfce7; }
    .btn-reject { background: #fff1f2; color: #e11d48; }
    .btn-reject:hover { background: #ffe4e6; }

    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state svg { width: 48px; height: 48px; margin: 0 auto 12px; opacity: 0.4; }

    .alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 500; }

    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #f1f5f9; }
</style>

@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<div class="page-header">
    <div>
        <div class="page-header__title">Approval Akun Murid/Guru</div>
        <div class="page-header__sub">Setujui atau tolak pendaftaran akun baru</div>
    </div>
</div>

<form method="GET" action="{{ route('admin.approval.index') }}">
<div class="filter-bar">
    <div class="filter-group">
        <label>Filter Role</label>
        <select name="role" onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Murid</option>
            <option value="guru_bk" {{ request('role') == 'guru_bk' ? 'selected' : '' }}>Guru</option>
        </select>
    </div>
    @if(request('role'))
        <a href="{{ route('admin.approval.index') }}" class="btn-reset">Reset</a>
    @endif
</div>
</form>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px">No</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>NIS / NIP</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingUsers as $index => $user)
                <tr>
                    <td>{{ $pendingUsers->firstItem() + $index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        @if($user->hasRole('siswa'))
                            <span class="badge badge-siswa">Murid</span>
                        @else
                            <span class="badge badge-guru">Guru</span>
                        @endif
                    </td>
                    <td>{{ $user->nis ?? $user->nip ?? '-' }}</td>
                    <td>{{ $user->kelas->nama ?? '-' }}</td>
                    <td><span class="badge badge-pending">Menunggu</span></td>
                    <td>
                        <div class="action-group">
                            <form action="{{ route('admin.approval.approve', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-action btn-approve">Setujui</button>
                            </form>
                            <form action="{{ route('admin.approval.reject', $user) }}" method="POST"
                                  onsubmit="return confirm('Tolak pendaftaran {{ $user->name }}?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-action btn-reject">Tolak</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>Tidak ada pendaftaran yang menunggu approval.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">
        {{ $pendingUsers->links() }}
    </div>
</div>
@endsection