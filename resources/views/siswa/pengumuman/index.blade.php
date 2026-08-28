@extends('layouts.siswa')

@section('title', 'Pengumuman BK')
@section('page-title', 'Pengumuman BK')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- HEADER --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:1.35rem;font-weight:800;color:#0f172a;margin:0;">Pengumuman BK</h1>
        <p style="font-size:0.82rem;color:#64748b;margin:4px 0 0;">Informasi dan pengumuman dari Guru BK</p>
    </div>

    {{-- SUMMARY CARDS --}}
    @php
        $total    = $pengumuman->total();
        $pinned   = $pengumuman->getCollection()->where('is_pinned', true)->count();
        $terbaru  = $pengumuman->getCollection()->filter(fn($p) => $p->published_at >= now()->subDays(7))->count();
    @endphp

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Total</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $total }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Semua pengumuman</div>
        </div>

        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#fef9c3;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Disematkan</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $pinned }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Pengumuman penting</div>
        </div>

        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Terbaru</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $terbaru }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">7 hari terakhir</div>
        </div>
    </div>

    {{-- DAFTAR PENGUMUMAN --}}
    <div style="display:flex;flex-direction:column;gap:14px;">
        @forelse($pengumuman as $p)
        @php
            $badgeColor = $p->kategoriBadgeColor();
            $badgeBg    = $badgeColor . '20';
        @endphp

        <a href="{{ route('siswa.pengumuman.show', $p) }}"
           style="text-decoration:none;display:block;background:white;border-radius:16px;border:1.5px solid {{ $p->is_pinned ? '#fbbf24' : '#e2e8f0' }};box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:20px 24px;transition:box-shadow 0.2s;"
           onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.10)'"
           onmouseout="this.style.boxShadow='0 1px 4px rgba(0,0,0,0.06)'">

            <div style="display:flex;align-items:flex-start;gap:14px;">
                {{-- Icon Kategori --}}
                <div style="width:44px;height:44px;border-radius:12px;background:{{ $badgeBg }};display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                    <svg style="width:22px;height:22px;" fill="none" stroke="{{ $badgeColor }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>

                <div style="flex:1;min-width:0;">
                    {{-- Badges --}}
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:6px;">
                        @if($p->is_pinned)
                        <span style="font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#fef9c3;color:#713f12;display:flex;align-items:center;gap:3px;">
                            <svg style="width:11px;height:11px;display:inline;vertical-align:middle;margin-right:2px;" fill="none" stroke="#713f12" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>Disematkan
                        </span>
                        @endif
                        <span style="font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $badgeBg }};color:{{ $badgeColor }};">
                            {{ $p->kategoriLabel() }}
                        </span>
                        @php
                            $isNew = $p->published_at >= now()->subDays(3);
                        @endphp
                        @if($isNew)
                        <span style="font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#dcfce7;color:#166534;">
                            <svg style="width:11px;height:11px;display:inline;vertical-align:middle;margin-right:2px;" fill="none" stroke="#166534" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>Baru
                        </span>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <div style="font-size:0.95rem;font-weight:800;color:#0f172a;margin-bottom:6px;line-height:1.4;">
                        {{ $p->judul }}
                    </div>

                    {{-- Preview isi --}}
                    <div style="font-size:0.82rem;color:#475569;line-height:1.6;margin-bottom:10px;">
                        {{ Str::limit(strip_tags($p->isi), 120) }}
                    </div>

                    {{-- Meta --}}
                    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                        <span style="font-size:0.73rem;color:#94a3b8;display:flex;align-items:center;gap:4px;">
                            <svg style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ $p->published_at->translatedFormat('d F Y, H:i') }}
                        </span>
                        @if($p->guruBk)
                        <span style="font-size:0.73rem;color:#94a3b8;display:flex;align-items:center;gap:4px;">
                            <svg style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>{{ $p->guruBk->name }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Arrow --}}
                <div style="flex-shrink:0;color:#cbd5e1;margin-top:10px;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </a>
        @empty
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;padding:48px 20px;text-align:center;">
            <div style="width:64px;height:64px;border-radius:20px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg style="width:32px;height:32px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:4px;">Belum Ada Pengumuman</div>
            <div style="font-size:0.82rem;color:#64748b;">Pengumuman dari Guru BK akan muncul di sini.</div>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($pengumuman->hasPages())
    <div style="margin-top:20px;">
        {{ $pengumuman->links() }}
    </div>
    @endif

</div>
@endsection