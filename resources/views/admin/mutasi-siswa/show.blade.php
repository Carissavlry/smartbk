@extends('layouts.admin')

@section('title', 'Detail Mutasi Siswa')
@section('page-title', 'Mutasi Siswa')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Detail Mutasi Siswa</h2>
            <p class="text-sm text-gray-500 mt-0.5">Informasi lengkap catatan mutasi</p>
        </div>
        <a href="{{ route('admin.mutasi-siswa.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Badge Jenis Mutasi --}}
    <div class="mb-4">
        @if($mutasiSiswa->jenis_mutasi === 'masuk')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg>
                Mutasi Masuk
            </span>
        @elseif($mutasiSiswa->jenis_mutasi === 'keluar')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                Mutasi Keluar
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Mutasi Internal
            </span>
        @endif
    </div>

    {{-- Card Info --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm divide-y divide-gray-100">

        {{-- Data Siswa --}}
        <div class="px-6 py-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Data Siswa</p>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Nama Siswa</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $mutasiSiswa->siswa->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">NIS</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $mutasiSiswa->siswa->nis ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Detail Mutasi --}}
        <div class="px-6 py-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Detail Mutasi</p>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Tanggal Mutasi</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">
                        {{ $mutasiSiswa->tanggal_mutasi->format('d F Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Jenis Mutasi</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5 capitalize">{{ $mutasiSiswa->jenis_mutasi }}</p>
                </div>

                @if($mutasiSiswa->jenis_mutasi === 'masuk')
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Sekolah Asal</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $mutasiSiswa->sekolah_asal ?? '-' }}</p>
                </div>
                @endif

                @if($mutasiSiswa->jenis_mutasi === 'keluar')
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Sekolah Tujuan</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $mutasiSiswa->sekolah_tujuan ?? '-' }}</p>
                </div>
                @endif

                @if($mutasiSiswa->jenis_mutasi === 'internal')
                <div>
                    <p class="text-xs text-gray-500">Kelas Asal</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $mutasiSiswa->kelasAsal->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Kelas Tujuan</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $mutasiSiswa->kelasTujuan->nama ?? '-' }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Alasan --}}
        <div class="px-6 py-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Alasan / Keterangan</p>
            <p class="text-sm text-gray-700">{{ $mutasiSiswa->alasan ?? '-' }}</p>
        </div>

        {{-- Meta --}}
        <div class="px-6 py-4 bg-gray-50 rounded-b-2xl">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Dicatat Oleh</p>
                    <p class="text-sm font-medium text-gray-700 mt-0.5">{{ $mutasiSiswa->dicatatOleh->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Tanggal Dicatat</p>
                    <p class="text-sm font-medium text-gray-700 mt-0.5">{{ $mutasiSiswa->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Hapus --}}
    <div class="mt-4 flex justify-end">
        <form action="{{ route('admin.mutasi-siswa.destroy', $mutasiSiswa) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus data mutasi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 rounded-lg text-sm font-medium text-red-600 hover:bg-red-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Data Mutasi
            </button>
        </form>
    </div>

</div>
@endsection