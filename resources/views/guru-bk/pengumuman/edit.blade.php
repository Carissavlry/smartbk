@extends('layouts.guru')
@section('title', 'Edit Pengumuman')
@section('page-title', 'Edit Pengumuman')

@section('content')
<div style="max-width:720px;margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
        <a href="{{ route('guru-bk.pengumuman.index') }}"
            style="width:36px;height:36px;border-radius:9px;background:white;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#64748b;text-decoration:none;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 style="font-size:1.4rem;font-weight:800;color:var(--navy-darkest);margin:0;">Edit Pengumuman</h1>
            <p style="font-size:0.82rem;color:#64748b;margin:2px 0 0;">Perbarui isi pengumuman</p>
        </div>
    </div>

    {{-- Form --}}
    <div style="background:white;border-radius:16px;border:1px solid #e2e8f0;padding:28px;">
        <form action="{{ route('guru-bk.pengumuman.update', $pengumuman->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:0.84rem;font-weight:600;color:var(--navy-darkest);margin-bottom:6px;">
                    Judul Pengumuman <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}"
                    placeholder="Contoh: Jadwal Konseling Minggu Ini"
                    style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('judul') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;font-size:0.88rem;font-family:inherit;outline:none;">
                @error('judul')
                    <p style="font-size:0.76rem;color:#ef4444;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori + Target --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">

                {{-- Kategori --}}
                <div>
                    <label style="display:block;font-size:0.84rem;font-weight:600;color:var(--navy-darkest);margin-bottom:6px;">
                        Kategori <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="kategori"
                        style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('kategori') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;font-size:0.88rem;font-family:inherit;outline:none;background:white;">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="pribadi_sosial" {{ old('kategori', $pengumuman->kategori) === 'pribadi_sosial' ? 'selected' : '' }}>Pribadi & Sosial</option>
                        <option value="belajar" {{ old('kategori', $pengumuman->kategori) === 'belajar' ? 'selected' : '' }}>Belajar & Akademik</option>
                        <option value="karir" {{ old('kategori', $pengumuman->kategori) === 'karir' ? 'selected' : '' }}>Karir & Masa Depan</option>
                        <option value="info_umum" {{ old('kategori', $pengumuman->kategori) === 'info_umum' ? 'selected' : '' }}>Info Umum</option>
                    </select>
                    @error('kategori')
                        <p style="font-size:0.76rem;color:#ef4444;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Target --}}
                <div>
                    <label style="display:block;font-size:0.84rem;font-weight:600;color:var(--navy-darkest);margin-bottom:6px;">
                        Target Penerima <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="target"
                        style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('target') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;font-size:0.88rem;font-family:inherit;outline:none;background:white;">
                        <option value="">-- Pilih Target --</option>
                        <option value="semua" {{ old('target', $pengumuman->target) === 'semua' ? 'selected' : '' }}>Semua Siswa</option>
                        <option value="kelas_binaan" {{ old('target', $pengumuman->target) === 'kelas_binaan' ? 'selected' : '' }}>Kelas Binaan Saya</option>
                    </select>
                    @error('target')
                        <p style="font-size:0.76rem;color:#ef4444;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Isi --}}
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:0.84rem;font-weight:600;color:var(--navy-darkest);margin-bottom:6px;">
                    Isi Pengumuman <span style="color:#ef4444;">*</span>
                </label>
                <textarea name="isi" rows="6"
                    placeholder="Tulis isi pengumuman di sini..."
                    style="width:100%;padding:10px 14px;border:1px solid {{ $errors->has('isi') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;font-size:0.88rem;font-family:inherit;outline:none;resize:vertical;">{{ old('isi', $pengumuman->isi) }}</textarea>
                @error('isi')
                    <p style="font-size:0.76rem;color:#ef4444;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pin --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;padding:14px;background:#fafafa;border-radius:10px;border:1px solid #f1f5f9;">
                <input type="checkbox" name="is_pinned" id="is_pinned" value="1"
                    {{ old('is_pinned', $pengumuman->is_pinned) ? 'checked' : '' }}
                    style="width:16px;height:16px;cursor:pointer;">
                <label for="is_pinned" style="font-size:0.84rem;font-weight:600;color:var(--navy-darkest);cursor:pointer;">
                    Sematkan pengumuman ini ke atas
                </label>
            </div>

            {{-- Tombol --}}
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <a href="{{ route('guru-bk.pengumuman.index') }}"
                    style="padding:10px 20px;border-radius:10px;border:1px solid #e2e8f0;background:white;color:#64748b;font-size:0.84rem;font-weight:600;text-decoration:none;">
                    Batal
                </a>
                <button type="submit"
                    style="padding:10px 24px;border-radius:10px;background:var(--navy-dark);color:white;border:none;font-size:0.84rem;font-weight:600;cursor:pointer;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection