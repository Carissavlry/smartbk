@extends('layouts.guru')
@section('title', 'Tambah Prestasi')
@section('page-title', 'Tambah Prestasi')

@section('content')
<style>
.back-link { display:inline-flex; align-items:center; gap:6px; font-size:0.82rem; color:#64748b; text-decoration:none; margin-bottom:20px; }
.back-link:hover { color:var(--navy-dark); }
.card { background:#fff; border-radius:14px; box-shadow:0 1px 6px rgba(30,41,59,.07); overflow:hidden; }
.card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
.card-header-title { font-size:0.72rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
.form-body { padding:24px; display:grid; grid-template-columns:1fr 1fr; gap:18px; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group.full { grid-column:1/-1; }
label { font-size:0.78rem; font-weight:600; color:#374151; }
.form-control { padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.83rem; color:#374151; outline:none; transition:border .15s; width:100%; box-sizing:border-box; }
.form-control:focus { border-color:var(--navy-dark); }
.form-control.is-invalid { border-color:#f43f5e; }
.invalid-feedback { font-size:0.75rem; color:#f43f5e; margin-top:2px; }
.form-hint { font-size:0.73rem; color:#94a3b8; }
.form-footer { padding:16px 24px; border-top:1px solid #f1f5f9; display:flex; gap:10px; justify-content:flex-end; }
.btn { display:inline-flex; align-items:center; gap:6px; padding:9px 20px; border-radius:9px; font-size:0.82rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:all .18s; }
.btn-primary { background:var(--navy-dark); color:#fff; }
.btn-primary:hover { background:var(--navy-darkest); }
.btn-secondary { background:#f1f5f9; color:#64748b; }
.btn-secondary:hover { background:#e2e8f0; }
</style>

<a href="{{ route('guru-bk.prestasi.index') }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Kembali ke Daftar Prestasi
</a>

<div class="card">
    <div class="card-header">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        <span class="card-header-title">Form Tambah Prestasi</span>
    </div>
    <form method="POST" action="{{ route('guru-bk.prestasi.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-body">
            {{-- Siswa --}}
            <div class="form-group full">
                <label>Nama Siswa <span style="color:#f43f5e">*</span></label>
                <select name="user_id" class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}">
                    <option value="">-- Pilih Siswa Binaan --</option>
                    @foreach($siswas as $s)
                    <option value="{{ $s->id }}" {{ old('user_id')==$s->id?'selected':'' }}>
                        {{ $s->name }} — {{ $s->nis ?? 'NIS belum diisi' }}
                    </option>
                    @endforeach
                </select>
                @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Nama Prestasi --}}
            <div class="form-group full">
                <label>Nama Prestasi <span style="color:#f43f5e">*</span></label>
                <input type="text" name="nama_prestasi" class="form-control {{ $errors->has('nama_prestasi') ? 'is-invalid' : '' }}"
                    value="{{ old('nama_prestasi') }}" placeholder="Contoh: Juara 1 Olimpiade Matematika Tingkat Kota">
                @error('nama_prestasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Jenis --}}
            <div class="form-group">
                <label>Jenis <span style="color:#f43f5e">*</span></label>
                <select name="jenis" class="form-control {{ $errors->has('jenis') ? 'is-invalid' : '' }}">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Akademik" {{ old('jenis')=='Akademik'?'selected':'' }}>Akademik</option>
                    <option value="Non-Akademik" {{ old('jenis')=='Non-Akademik'?'selected':'' }}>Non-Akademik</option>
                </select>
                @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Tingkat --}}
            <div class="form-group">
                <label>Tingkat <span style="color:#f43f5e">*</span></label>
                <select name="tingkat" class="form-control {{ $errors->has('tingkat') ? 'is-invalid' : '' }}">
                    <option value="">-- Pilih Tingkat --</option>
                    @foreach(['Sekolah','Kecamatan','Kota','Provinsi','Nasional','Internasional'] as $t)
                    <option value="{{ $t }}" {{ old('tingkat')==$t?'selected':'' }}>{{ $t }}</option>
                    @endforeach
                </select>
                @error('tingkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Peringkat --}}
            <div class="form-group">
                <label>Peringkat / Juara</label>
                <select name="peringkat" class="form-control">
                    <option value="">-- Pilih Peringkat --</option>
                    @foreach(['Juara 1','Juara 2','Juara 3','Harapan 1','Harapan 2','Harapan 3','Peserta'] as $r)
                    <option value="{{ $r }}" {{ old('peringkat')==$r?'selected':'' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div class="form-group">
                <label>Tanggal <span style="color:#f43f5e">*</span></label>
                <input type="date" name="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                    value="{{ old('tanggal') }}">
                @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Penyelenggara --}}
            <div class="form-group full">
                <label>Penyelenggara</label>
                <input type="text" name="penyelenggara" class="form-control"
                    value="{{ old('penyelenggara') }}" placeholder="Contoh: Dinas Pendidikan Kota Sidoarjo">
            </div>

            {{-- Keterangan --}}
            <div class="form-group full">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"
                    placeholder="Catatan tambahan (opsional)...">{{ old('keterangan') }}</textarea>
            </div>

            {{-- Bukti --}}
            <div class="form-group full">
                <label>Bukti / Sertifikat</label>
                <input type="file" name="bukti" class="form-control {{ $errors->has('bukti') ? 'is-invalid' : '' }}"
                    accept=".jpg,.jpeg,.png,.pdf">
                <span class="form-hint">Format: JPG, PNG, PDF. Maks 2MB.</span>
                @error('bukti')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('guru-bk.prestasi.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Simpan Prestasi
            </button>
        </div>
    </form>
</div>
@endsection