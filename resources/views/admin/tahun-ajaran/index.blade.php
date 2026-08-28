@extends('layouts.admin')

@section('title', 'Tahun Ajaran')
@section('page-title', 'Tahun Ajaran')

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header__title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--navy-darkest);
    }

    .page-header__sub {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 2px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-darkest));
        color: white;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(5,38,89,0.2);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(5,38,89,0.28);
    }

    .btn-primary svg { width: 16px; height: 16px; }

    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 500;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert--success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .alert svg { width: 18px; height: 18px; flex-shrink: 0; }

    .card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8edf5;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .table-wrap { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
    }

    thead {
        background: #f8fafc;
        border-bottom: 1px solid #e8edf5;
    }

    th {
        padding: 13px 18px;
        text-align: left;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #64748b;
        white-space: nowrap;
    }

    td {
        padding: 14px 18px;
        color: var(--navy-darkest);
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafbff; }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .badge--aktif {
        background: #dcfce7;
        color: #166534;
    }

    .badge--nonaktif {
        background: #f1f5f9;
        color: #64748b;
    }

    .badge--ganjil {
        background: rgba(5,38,89,0.08);
        color: var(--navy-dark);
    }

    .badge--genap {
        background: rgba(117,22,46,0.08);
        color: var(--maroon-mid);
    }

    .action-btns {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.74rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-sm svg { width: 13px; height: 13px; }

    .btn-edit {
        background: rgba(5,38,89,0.08);
        color: var(--navy-dark);
    }

    .btn-edit:hover { background: rgba(5,38,89,0.15); }

    .btn-aktif {
        background: rgba(22,163,74,0.1);
        color: #166534;
    }

    .btn-aktif:hover { background: rgba(22,163,74,0.18); }

    .btn-danger {
        background: rgba(220,38,38,0.08);
        color: #dc2626;
    }

    .btn-danger:hover { background: rgba(220,38,38,0.15); }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state svg {
        width: 48px;
        height: 48px;
        margin: 0 auto 12px;
        opacity: 0.4;
    }

    .empty-state__title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .empty-state__sub { font-size: 0.78rem; }
</style>

<!-- Header -->
<div class="page-header">
    <div>
        <div class="page-header__title">Manajemen Tahun Ajaran</div>
        <div class="page-header__sub">Kelola tahun ajaran dan semester aktif sekolah</div>
    </div>
    <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Tahun Ajaran
    </a>
</div>

<!-- Alert -->
@if (session('success'))
    <div class="alert alert--success">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

<!-- Tabel -->
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tahunAjarans as $index => $ta)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $ta->nama }}</strong></td>
                    <td>
                        <span class="badge {{ $ta->semester === 'Ganjil' ? 'badge--ganjil' : 'badge--genap' }}">
                            {{ $ta->semester }}
                        </span>
                    </td>
                    <td>{{ $ta->tanggal_mulai->format('d M Y') }}</td>
                    <td>{{ $ta->tanggal_selesai->format('d M Y') }}</td>
                    <td>
                        @if ($ta->is_aktif)
                            <span class="badge badge--aktif">
                                <svg fill="currentColor" viewBox="0 0 20 20" style="width:10px;height:10px">
                                    <circle cx="10" cy="10" r="10"/>
                                </svg>
                                Aktif
                            </span>
                        @else
                            <span class="badge badge--nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            @if (!$ta->is_aktif)
                            <form method="POST" action="{{ route('admin.tahun-ajaran.set-aktif', $ta) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-sm btn-aktif">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Aktifkan
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('admin.tahun-ajaran.edit', $ta) }}" class="btn-sm btn-edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.tahun-ajaran.destroy', $ta) }}"
                                  onsubmit="return confirm('Hapus tahun ajaran ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
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
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div class="empty-state__title">Belum ada tahun ajaran</div>
                            <div class="empty-state__sub">Klik tombol "Tambah Tahun Ajaran" untuk memulai</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection