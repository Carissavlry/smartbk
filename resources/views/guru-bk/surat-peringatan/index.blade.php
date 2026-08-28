@extends('layouts.guru')

@section('title', 'Surat Peringatan')
@section('page-title', 'Surat Peringatan')

@section('content')
<style>
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.page-header__title { font-size:1.25rem; font-weight:700; color:var(--navy-darkest); margin:0; }
.page-header__sub { font-size:0.78rem; color:#64748b; margin:2px 0 0; }
.btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all .18s; }
.btn-primary { background:var(--navy-dark); color:#fff; }
.btn-primary:hover { background:var(--navy-darkest); color:#fff; }
.btn-sm { padding:5px 12px; font-size:0.78rem; }
.btn-outline { background:#fff; border:1.5px solid #e2e8f0; color:#374151; }
.btn-outline:hover { border-color:var(--navy-dark); color:var(--navy-dark); }
.card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); margin-bottom:20px; overflow:hidden; }
.card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
.card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
.filter-bar { display:flex; flex-wrap:wrap; gap:10px; padding:16px 20px; }
.filter-bar input, .filter-bar select { padding:9px 14px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.82rem; color:#374151; background:#fff; outline:none; }
.filter-bar input:focus, .filter-bar select:focus { border-color:var(--navy-dark); }
.filter-bar input { min-width:260px; }
.table-wrap { overflow-x:auto; }
table { width:100%; border-collapse:collapse; font-size:0.82rem; }
thead th { background:#f8fafc; padding:11px 16px; text-align:left; font-weight:700; color:#64748b; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid #e2e8f0; }
tbody td { padding:13px 16px; border-bottom:1px solid #f1f5f9; color:#1e293b; vertical-align:middle; }
tbody tr:last-child td { border-bottom:none; }
tbody tr:hover { background:#f8fafc; }
.badge { display:inline-flex; align-items:center; gap:4px; padding:4px 12px; border-radius:20px; font-size:0.72rem; font-weight:700; }
.badge-kuning { background:#fef9c3; color:#854d0e; }
.badge-merah { background:#fee2e2; color:#991b1b; }
.badge-hitam { background:#1e293b; color:#fff; }
.badge-diakui { background:#dcfce7; color:#166534; }
.badge-terkirim { background:#f1f5f9; color:#64748b; }
.siswa-info { display:flex; flex-direction:column; }
.siswa-info__name { font-weight:600; color:#1e293b; }
.siswa-info__nis { font-size:0.72rem; color:#94a3b8; }
.action-btns { display:flex; gap:6px; align-items:center; }
.btn-icon { width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; font-size:0.82rem; transition:all .15s; text-decoration:none; }
.btn-icon-view { background:#eff6ff; color:#2563eb; }
.btn-icon-view:hover { background:#dbeafe; }
.btn-icon-pdf { background:#fef2f2; color:#dc2626; }
.btn-icon-pdf:hover { background:#fee2e2; }
.empty-state { text-align:center; padding:48px 20px; color:#94a3b8; }
.empty-state svg { width:48px; height:48px; margin:0 auto 12px; display:block; opacity:.4; }
.empty-state p { font-size:0.85rem; }
.alert { padding:12px 18px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; font-weight:600; }
.alert-success { background:#dcfce7; color:#166534; }
.alert-info { background:#dbeafe; color:#1e40af; }
</style>

<div class="page-header">
    <div>
        <h1 class="page-header__title">Surat Peringatan</h1>
        <p class="page-header__sub">Daftar surat peringatan siswa berdasarkan threshold pelanggaran</p>
    </div>
    <button onclick="document.getElementById('modalGenerate').style.display='flex'" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Generate Manual
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success" style="display:flex;align-items:center;gap:10px;">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif
@if(session('info'))
    <div class="alert alert-info" style="display:flex;align-items:center;gap:10px;">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
        </svg>
        {{ session('info') }}
    </div>
@endif

{{-- FILTER --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="width:16px;height:16px;color:#64748b">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
        </svg>
        <span class="card-header-title">Filter & Pencarian</span>
    </div>
    <form method="GET" style="display:flex;flex-wrap:wrap;gap:10px;padding:16px 20px;align-items:center;">
        <div style="flex:1;min-width:200px;position:relative;">
            <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#94a3b8;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text" name="search" placeholder="Cari nama siswa..." value="{{ request('search') }}"
                style="width:100%;padding:9px 14px 9px 36px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:0.82rem;color:#374151;outline:none;">
        </div>
        <div style="min-width:160px;">
            <select name="level" style="width:100%;padding:9px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:0.82rem;color:#374151;background:#fff;outline:none;">
                <option value="">Semua Level</option>
                <option value="kuning" @selected(request('level')=='kuning')>Kuning</option>
                <option value="merah" @selected(request('level')=='merah')>Merah</option>
                <option value="hitam" @selected(request('level')=='hitam')>Hitam</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            Cari
        </button>
        <a href="{{ route('guru-bk.surat-peringatan.index') }}" class="btn btn-outline">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
            </svg>
            Reset
        </a>
    </form>
</div>

{{-- TABLE --}}
<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="width:16px;height:16px;color:#64748b">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.981l7.5-4.039a2.25 2.25 0 012.134 0l7.5 4.039a2.25 2.25 0 011.183 1.98V19.5z"/>
        </svg>
        <span class="card-header-title">Data Surat Peringatan</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Level</th>
                    <th>Total Poin</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surats as $i => $surat)
                <tr>
                    <td>{{ $surats->firstItem() + $i }}</td>
                    <td style="font-weight:600;font-size:0.78rem;color:var(--navy-dark);">
                        {{ $surat->nomor_surat ?: '-' }}
                    </td>
                    <td>
                        <div class="siswa-info">
                            <span class="siswa-info__name">{{ $surat->siswa->name ?? '-' }}</span>
                            <span class="siswa-info__nis">{{ $surat->siswa->nis ?? '' }}</span>
                        </div>
                    </td>
                    <td>{{ $surat->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>
                        @if($surat->level === 'kuning')
                            <span class="badge badge-kuning">Kuning</span>
                        @elseif($surat->level === 'merah')
                            <span class="badge badge-merah">Merah</span>
                        @elseif($surat->level === 'hitam')
                            <span class="badge badge-hitam">Hitam</span>
                        @else
                            <span class="badge badge-terkirim">{{ ucfirst($surat->level) }}</span>
                        @endif
                    </td>
                    <td style="font-weight:700;color:#dc2626;">{{ $surat->total_poin }}</td>
                    <td>
                        @if($surat->status === 'diakui')
                            <span class="badge badge-diakui">✅ Diakui</span>
                        @else
                            <span class="badge badge-terkirim">Terkirim</span>
                        @endif
                    </td>
                    <td>{{ $surat->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('guru-bk.surat-peringatan.show', $surat) }}"
                            class="btn-icon btn-icon-view" title="Detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </a>
                            <a href="{{ route('guru-bk.surat-peringatan.pdf', $surat) }}"
                            class="btn-icon btn-icon-pdf" title="Download PDF" target="_blank">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('guru-bk.surat-peringatan.destroy', $surat) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Hapus"
                                    style="background:#fef2f2;color:#dc2626;"
                                    onclick="return confirm('Hapus surat peringatan ini?')">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.981l7.5-4.039a2.25 2.25 0 012.134 0l7.5 4.039a2.25 2.25 0 011.183 1.98V19.5z"/>
                            </svg>
                            <p>Belum ada surat peringatan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($surats->hasPages())
    <div style="padding:14px 20px;">
        {{ $surats->links() }}
    </div>
    @endif
</div>

{{-- MODAL GENERATE --}}
<div id="modalGenerate" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:28px;width:100%;max-width:440px;box-shadow:0 8px 32px rgba(0,0,0,.15);">
        <h3 style="font-size:1rem;font-weight:700;margin:0 0 6px;color:var(--navy-darkest);">Generate Surat Peringatan Manual</h3>
        <p style="font-size:0.78rem;color:#64748b;margin:0 0 20px;">Surat akan digenerate jika siswa sudah mencapai threshold poin.</p>
        <form method="POST" action="{{ route('guru-bk.surat-peringatan.generate') }}">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="font-size:0.82rem;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Pilih Siswa</label>
                <select name="siswa_id" required style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:0.84rem;outline:none;">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach(\App\Models\User::role('siswa')->orderBy('name')->get() as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->name }} — {{ $siswa->kelas->nama_kelas ?? '-' }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;">
                <button type="button" onclick="document.getElementById('modalGenerate').style.display='none'" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">Generate</button>
            </div>
        </form>
    </div>
</div>
@endsection