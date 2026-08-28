@extends('layouts.guru')
@section('title', 'Papan Pengumuman')
@section('page-title', 'Papan Pengumuman')

@section('content')
<div style="max-width:900px;margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
            <h1 style="font-size:1.4rem;font-weight:800;color:var(--navy-darkest);margin:0;">Papan Pengumuman</h1>
            <p style="font-size:0.82rem;color:#64748b;margin:4px 0 0;">Kelola pengumuman untuk siswa binaan kamu</p>
        </div>
        <a href="{{ route('guru-bk.pengumuman.create') }}"
            style="display:flex;align-items:center;gap:8px;padding:10px 18px;background:var(--navy-dark);color:white;border-radius:10px;text-decoration:none;font-size:0.84rem;font-weight:600;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Pengumuman
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
            <svg fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span style="font-size:0.84rem;color:#16a34a;font-weight:500;">{{ session('success') }}</span>
        </div>
    @endif

    {{-- List --}}
    @forelse($pengumuman as $item)
        <div style="background:white;border-radius:14px;border:1px solid {{ $item->is_pinned ? '#fde68a' : '#e2e8f0' }};padding:20px;margin-bottom:14px;position:relative;{{ $item->is_pinned ? 'box-shadow:0 2px 8px rgba(245,158,11,0.15);' : '' }}">

            {{-- Pin badge --}}
            @if($item->is_pinned)
                <div style="position:absolute;top:14px;right:14px;display:flex;align-items:center;gap:4px;background:#fef3c7;color:#d97706;padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:700;">
                    <svg fill="currentColor" viewBox="0 0 24 24" style="width:12px;height:12px;">
                        <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5v6h2v-6h5v-2l-2-2z"/>
                    </svg>
                    Disematkan
                </div>
            @endif

            {{-- Kategori + Target --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;flex-wrap:wrap;">
                <span style="background:{{ $item->kategoriBadgeColor() }}20;color:{{ $item->kategoriBadgeColor() }};padding:3px 12px;border-radius:20px;font-size:0.72rem;font-weight:700;">
                    {{ $item->kategoriLabel() }}
                </span>
                <span style="background:{{ $item->target === 'semua' ? '#dbeafe' : '#f3e8ff' }};color:{{ $item->target === 'semua' ? '#2563eb' : '#7c3aed' }};padding:3px 12px;border-radius:20px;font-size:0.72rem;font-weight:700;">
                    {{ $item->target === 'semua' ? 'Semua Siswa' : 'Kelas Binaan' }}
                </span>
            </div>

            {{-- Judul --}}
            <h3 style="font-size:1rem;font-weight:700;color:var(--navy-darkest);margin:0 0 6px;">{{ $item->judul }}</h3>

            {{-- Isi --}}
            <p style="font-size:0.84rem;color:#475569;line-height:1.6;margin:0 0 14px;">{{ Str::limit($item->isi, 150) }}</p>

            {{-- Footer --}}
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                <span style="font-size:0.76rem;color:#94a3b8;">
                    {{ $item->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                </span>
                <div style="display:flex;align-items:center;gap:8px;">
                    {{-- Toggle Pin --}}
                    <form action="{{ route('guru-bk.pengumuman.toggle-pin', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit"
                            style="display:flex;align-items:center;gap:4px;padding:6px 12px;border-radius:8px;border:1px solid {{ $item->is_pinned ? '#fde68a' : '#e2e8f0' }};background:{{ $item->is_pinned ? '#fef3c7' : 'white' }};color:{{ $item->is_pinned ? '#d97706' : '#64748b' }};font-size:0.76rem;font-weight:600;cursor:pointer;">
                            <svg fill="currentColor" viewBox="0 0 24 24" style="width:13px;height:13px;">
                                <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5v6h2v-6h5v-2l-2-2z"/>
                            </svg>
                            {{ $item->is_pinned ? 'Lepas Pin' : 'Sematkan' }}
                        </button>
                    </form>

                    {{-- Edit --}}
                    <a href="{{ route('guru-bk.pengumuman.edit', $item->id) }}"
                        style="display:flex;align-items:center;gap:4px;padding:6px 12px;border-radius:8px;border:1px solid #e2e8f0;background:white;color:#2563eb;font-size:0.76rem;font-weight:600;text-decoration:none;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ route('guru-bk.pengumuman.destroy', $item->id) }}" method="POST" style="display:inline;"
                        onsubmit="return confirm('Hapus pengumuman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="display:flex;align-items:center;gap:4px;padding:6px 12px;border-radius:8px;border:1px solid #fee2e2;background:white;color:#dc2626;font-size:0.76rem;font-weight:600;cursor:pointer;">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div style="text-align:center;padding:64px 0;color:#94a3b8;">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:48px;height:48px;margin:0 auto 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
            </svg>
            <p style="font-size:1rem;font-weight:600;">Belum ada pengumuman</p>
            <p style="font-size:0.82rem;margin-top:4px;">Buat pengumuman pertama untuk siswa kamu</p>
        </div>
    @endforelse

    {{-- Pagination --}}
    <div style="margin-top:16px;">{{ $pengumuman->links() }}</div>

</div>
@endsection