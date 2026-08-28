@extends('layouts.siswa')

@section('title', 'Riwayat Pelanggaran')
@section('page-title', 'Riwayat Pelanggaran')

@section('content')
<div style="padding:28px 32px;min-height:100vh;background:#f1f5f9;">

    {{-- HEADER --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:1.35rem;font-weight:800;color:#0f172a;margin:0;">Riwayat Pelanggaran</h1>
        <p style="font-size:0.82rem;color:#64748b;margin:4px 0 0;">Catatan pelanggaran dan poin yang tercatat oleh Guru BK</p>
    </div>

    {{-- SUMMARY CARDS --}}
    @php
        $totalKasus   = $pelanggarans->total();
        $kategoriRingan = $pelanggarans->getCollection()->filter(fn($p) => optional($p->jenisPelanggaran)->kategori === 'ringan')->count();
        $kategoriSedang = $pelanggarans->getCollection()->filter(fn($p) => optional($p->jenisPelanggaran)->kategori === 'sedang')->count();
        $kategoriBerat  = $pelanggarans->getCollection()->filter(fn($p) => optional($p->jenisPelanggaran)->kategori === 'berat')->count();
    @endphp

    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:16px;">

        {{-- Total Poin --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#1e3a5f,#6b1d1d);display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Total Poin</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $totalPoin }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Akumulasi poin pelanggaran</div>
        </div>

        {{-- Total Kasus --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Total Kasus</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $totalKasus }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Jumlah pelanggaran tercatat</div>
        </div>

        </div>
        {{-- BARIS 2: Ringan + Sedang + Berat --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">

        {{-- Ringan --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#fef9c3;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#ca8a04" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Ringan</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $kategoriRingan }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Pelanggaran kategori ringan</div>
        </div>

        {{-- Sedang --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#d97706" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Sedang</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $kategoriSedang }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Pelanggaran kategori sedang</div>
        </div>

        {{-- Berat --}}
        <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);padding:18px 20px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <span style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Berat</span>
            </div>
            <div style="font-size:1.8rem;font-weight:900;color:#0f172a;">{{ $kategoriBerat }}</div>
            <div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Perlu perhatian serius</div>
        </div>
    </div>

    {{-- TABEL RIWAYAT --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
            <div style="width:28px;height:28px;border-radius:8px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                <svg style="width:15px;height:15px;" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <span style="font-size:0.88rem;font-weight:700;color:#0f172a;">Riwayat Lengkap</span>
            <span style="margin-left:auto;background:#f1f5f9;color:#64748b;font-size:0.75rem;font-weight:600;padding:3px 10px;border-radius:20px;">
                {{ $pelanggarans->total() }} catatan
            </span>
        </div>

        @forelse($pelanggarans as $p)
        @php
            $kat = optional($p->jenisPelanggaran)->kategori ?? 'ringan';
            $katStyle = match($kat) {
                'berat'  => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'Berat'],
                'sedang' => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Sedang'],
                default  => ['bg'=>'#fef9c3','color'=>'#713f12','label'=>'Ringan'],
            };
        @endphp
        <div style="padding:16px 20px;border-bottom:1px solid #f8fafc;">
            <div style="display:flex;align-items:flex-start;gap:14px;">

                {{-- Icon Kategori --}}
                <div style="width:40px;height:40px;border-radius:12px;background:{{ $katStyle['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:20px;height:20px;" fill="none" stroke="{{ $katStyle['color'] }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>

                {{-- Detail --}}
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px;">
                        <span style="font-size:0.88rem;font-weight:700;color:#0f172a;">
                            {{ optional($p->jenisPelanggaran)->nama ?? 'Pelanggaran' }}
                        </span>
                        <span style="font-size:0.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $katStyle['bg'] }};color:{{ $katStyle['color'] }};">
                            {{ $katStyle['label'] }}
                        </span>
                    </div>
                    @if($p->keterangan)
                    <div style="font-size:0.8rem;color:#475569;margin-bottom:6px;line-height:1.5;">{{ $p->keterangan }}</div>
                    @endif
                    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                        <span style="font-size:0.75rem;color:#94a3b8;">
                            <svg style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $p->tanggal->translatedFormat('d F Y') }}
                        </span>
                        @if($p->pencatat)
                        <span style="font-size:0.75rem;color:#94a3b8;">
                            <svg style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:3px;" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ $p->pencatat->name }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Poin --}}
                <div style="text-align:center;flex-shrink:0;min-width:52px;">
                    <div style="font-size:1.5rem;font-weight:900;color:{{ $katStyle['color'] }};">{{ $p->poin }}</div>
                    <div style="font-size:0.68rem;color:#94a3b8;font-weight:600;letter-spacing:0.05em;">POIN</div>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:48px 20px;">
            <div style="width:64px;height:64px;border-radius:20px;background:#dcfce7;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg style="width:32px;height:32px;" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:4px;">Tidak Ada Pelanggaran</div>
            <div style="font-size:0.82rem;color:#64748b;">Kamu belum memiliki catatan pelanggaran. Pertahankan! 🎉</div>
        </div>
        @endforelse

        {{-- PAGINATION --}}
        @if($pelanggarans->hasPages())
        <div style="padding:12px 20px;border-top:1px solid #f1f5f9;">
            {{ $pelanggarans->links() }}
        </div>
        @endif
    </div>

</div>
@endsection