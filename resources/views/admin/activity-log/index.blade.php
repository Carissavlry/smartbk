@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
<div style="padding: 24px;">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:1.4rem;font-weight:700;color:#1e293b;margin:0;">Log Aktivitas</h1>
            <p style="font-size:0.83rem;color:#64748b;margin:4px 0 0;">Rekam jejak semua aktivitas pengguna di sistem</p>
        </div>
        {{-- Tombol Hapus Log Lama --}}
        <form method="POST" action="{{ route('admin.activity-log.clear') }}"
              onsubmit="return confirm('Hapus log aktivitas lebih dari 90 hari? Aksi ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <input type="hidden" name="days" value="90">
            <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:#fff1f2;color:#be123c;border:1.5px solid #fda4af;border-radius:10px;font-size:0.83rem;font-weight:600;cursor:pointer;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus Log > 90 Hari
            </button>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:0.85rem;">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Filter --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;margin-bottom:20px;">
        <form method="GET" action="{{ route('admin.activity-log.index') }}">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;align-items:end;">
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / IP / Deskripsi..."
                        style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.83rem;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Aksi</label>
                    <select name="action" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.83rem;box-sizing:border-box;">
                        <option value="">Semua Aksi</option>
                        @foreach($actions as $act)
                        <option value="{{ $act }}" {{ request('action')==$act?'selected':'' }}>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Modul</label>
                    <select name="module" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.83rem;box-sizing:border-box;">
                        <option value="">Semua Modul</option>
                        @foreach($modules as $mod)
                        <option value="{{ $mod }}" {{ request('module')==$mod?'selected':'' }}>{{ $mod }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Role</label>
                    <select name="role" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.83rem;box-sizing:border-box;">
                        <option value="">Semua Role</option>
                        <option value="admin_sekolah" {{ request('role')=='admin_sekolah'?'selected':'' }}>Admin Sekolah</option>
                        <option value="guru_bk" {{ request('role')=='guru_bk'?'selected':'' }}>Guru BK</option>
                        <option value="siswa" {{ request('role')=='siswa'?'selected':'' }}>Siswa</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.83rem;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#475569;display:block;margin-bottom:4px;">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.83rem;box-sizing:border-box;">
                </div>
                <div style="display:flex;gap:8px;">
                    <button type="submit" style="flex:1;padding:9px 12px;background:#2E75B6;color:#fff;border:none;border-radius:8px;font-size:0.83rem;font-weight:600;cursor:pointer;">
                        🔍 Filter
                    </button>
                    <a href="{{ route('admin.activity-log.index') }}" style="flex:1;padding:9px 12px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:8px;font-size:0.83rem;font-weight:600;text-align:center;text-decoration:none;">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:0.83rem;color:#64748b;">Total: <strong>{{ $logs->total() }}</strong> log</span>
            <span style="font-size:0.78rem;color:#94a3b8;">Menampilkan 50 per halaman</span>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:0.82rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:12px 16px;text-align:left;font-weight:600;color:#475569;white-space:nowrap;">Waktu</th>
                        <th style="padding:12px 16px;text-align:left;font-weight:600;color:#475569;">Pengguna</th>
                        <th style="padding:12px 16px;text-align:left;font-weight:600;color:#475569;">Role</th>
                        <th style="padding:12px 16px;text-align:left;font-weight:600;color:#475569;">Aksi</th>
                        <th style="padding:12px 16px;text-align:left;font-weight:600;color:#475569;">Modul</th>
                        <th style="padding:12px 16px;text-align:left;font-weight:600;color:#475569;">Deskripsi</th>
                        <th style="padding:12px 16px;text-align:left;font-weight:600;color:#475569;">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr style="border-top:1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                        <td style="padding:12px 16px;white-space:nowrap;color:#64748b;">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td style="padding:12px 16px;font-weight:500;color:#1e293b;">
                            {{ $log->user_name ?? '-' }}
                        </td>
                        <td style="padding:12px 16px;">
                            @php
                                $roleColor = match($log->role) {
                                    'admin_sekolah' => 'background:#eff6ff;color:#1d4ed8;',
                                    'guru_bk'       => 'background:#f0fdf4;color:#15803d;',
                                    'siswa'         => 'background:#fdf4ff;color:#7e22ce;',
                                    default         => 'background:#f1f5f9;color:#475569;',
                                };
                                $roleLabel = match($log->role) {
                                    'admin_sekolah' => 'Admin',
                                    'guru_bk'       => 'Guru BK',
                                    'siswa'         => 'Siswa',
                                    default         => $log->role ?? '-',
                                };
                            @endphp
                            <span style="padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;{{ $roleColor }}">
                                {{ $roleLabel }}
                            </span>
                        </td>
                        <td style="padding:12px 16px;">
                            @php
                                $actionColor = match($log->action) {
                                    'LOGIN'   => 'background:#f0fdf4;color:#15803d;',
                                    'LOGOUT'  => 'background:#f8fafc;color:#475569;',
                                    'CREATE'  => 'background:#eff6ff;color:#1d4ed8;',
                                    'UPDATE'  => 'background:#fffbeb;color:#b45309;',
                                    'DELETE'  => 'background:#fff1f2;color:#be123c;',
                                    'IMPORT'  => 'background:#f0fdf4;color:#15803d;',
                                    default   => 'background:#f1f5f9;color:#475569;',
                                };
                            @endphp
                            <span style="padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;{{ $actionColor }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td style="padding:12px 16px;color:#475569;">{{ $log->module }}</td>
                        <td style="padding:12px 16px;color:#64748b;max-width:300px;">{{ $log->description ?? '-' }}</td>
                        <td style="padding:12px 16px;color:#94a3b8;font-family:monospace;font-size:0.78rem;">{{ $log->ip_address ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:48px;text-align:center;color:#94a3b8;">
                            <div style="font-size:2rem;margin-bottom:8px;">📋</div>
                            <div style="font-weight:500;">Belum ada log aktivitas</div>
                            <div style="font-size:0.78rem;margin-top:4px;">Log akan muncul setelah ada aktivitas di sistem</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
        <div style="padding:16px 20px;border-top:1px solid #f1f5f9;">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection