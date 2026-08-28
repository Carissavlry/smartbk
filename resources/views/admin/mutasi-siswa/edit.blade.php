@extends('layouts.admin')

@section('title', 'Edit Mutasi Siswa')
@section('page-title', 'Mutasi Siswa')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.mutasi-siswa.index') }}"
           class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Mutasi Siswa</h1>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.mutasi-siswa.update', $mutasiSiswa) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pilih Siswa --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa <span class="text-red-500">*</span></label>
                <select name="user_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-400 @enderror">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->id }}" {{ old('user_id', $mutasiSiswa->user_id) == $s->id ? 'selected' : '' }}>
                            {{ $s->name }} ({{ $s->nis ?? '-' }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jenis Mutasi --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Mutasi <span class="text-red-500">*</span></label>
                <select name="jenis_mutasi" id="jenis_mutasi" required onchange="toggleFields()"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_mutasi') border-red-400 @enderror">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="masuk" {{ old('jenis_mutasi', $mutasiSiswa->jenis_mutasi) == 'masuk' ? 'selected' : '' }}>Mutasi Masuk</option>
                    <option value="keluar" {{ old('jenis_mutasi', $mutasiSiswa->jenis_mutasi) == 'keluar' ? 'selected' : '' }}>Mutasi Keluar</option>
                    <option value="internal" {{ old('jenis_mutasi', $mutasiSiswa->jenis_mutasi) == 'internal' ? 'selected' : '' }}>Mutasi Internal</option>
                </select>
                @error('jenis_mutasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Field: Mutasi Masuk --}}
            <div id="field_masuk" class="hidden">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sekolah Asal</label>
                    <input type="text" name="sekolah_asal"
                        value="{{ old('sekolah_asal', $mutasiSiswa->sekolah_asal) }}"
                        placeholder="Nama sekolah asal siswa"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Tujuan</label>
                    <select name="kelas_tujuan_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_tujuan_id', $mutasiSiswa->kelas_tujuan_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Field: Mutasi Keluar --}}
            <div id="field_keluar" class="hidden">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Asal</label>
                    <select name="kelas_asal_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_asal_id', $mutasiSiswa->kelas_asal_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sekolah Tujuan</label>
                    <input type="text" name="sekolah_tujuan"
                        value="{{ old('sekolah_tujuan', $mutasiSiswa->sekolah_tujuan) }}"
                        placeholder="Nama sekolah tujuan siswa"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Field: Mutasi Internal --}}
            <div id="field_internal" class="hidden">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Asal</label>
                    <select name="kelas_asal_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_asal_id', $mutasiSiswa->kelas_asal_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Tujuan</label>
                    <select name="kelas_tujuan_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_tujuan_id', $mutasiSiswa->kelas_tujuan_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tanggal Mutasi --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mutasi <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_mutasi"
                    value="{{ old('tanggal_mutasi', $mutasiSiswa->tanggal_mutasi->format('Y-m-d')) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_mutasi') border-red-400 @enderror">
                @error('tanggal_mutasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Alasan --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan / Keterangan</label>
                <textarea name="alasan" rows="3" placeholder="Tuliskan alasan mutasi (opsional)"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alasan', $mutasiSiswa->alasan) }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-lg transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.mutasi-siswa.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleFields() {
    const jenis = document.getElementById('jenis_mutasi').value;
    document.getElementById('field_masuk').classList.add('hidden');
    document.getElementById('field_keluar').classList.add('hidden');
    document.getElementById('field_internal').classList.add('hidden');

    if (jenis === 'masuk') document.getElementById('field_masuk').classList.remove('hidden');
    if (jenis === 'keluar') document.getElementById('field_keluar').classList.remove('hidden');
    if (jenis === 'internal') document.getElementById('field_internal').classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endpush
@endsection