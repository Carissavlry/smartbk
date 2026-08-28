@extends('layouts.guru')

@section('title', 'Tambah Kunjungan')
@section('page-title', 'Home Visit')

@section('content')
<style>
    .btn-back { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:var(--navy-dark); border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .btn-back:hover { background:#f8fafc; }
    .card { background:white; border-radius:16px; border:1px solid #e8edf5; box-shadow:0 1px 4px rgba(0,0,0,0.05); margin-bottom:20px; overflow:hidden; }
    .card-header { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
    .card-header-title { font-size:0.82rem; font-weight:700; color:var(--navy-darkest); letter-spacing:0.05em; text-transform:uppercase; }
    .card-body { padding:24px; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { font-size:0.78rem; font-weight:600; color:#374151; }
    .form-group label span.req { color:#ef4444; margin-left:2px; }
    .form-control { padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; color:#1e293b; background:white; width:100%; box-sizing:border-box; transition:border-color .2s; font-family:inherit; }
    .form-control:focus { outline:none; border-color:var(--navy-dark); }
    .form-control:disabled { background:#f8fafc; color:#64748b; }
    textarea.form-control { resize:vertical; min-height:90px; }
    .alert-error { background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:12px 18px; margin-bottom:20px; font-size:0.83rem; color:#dc2626; }
    .footer-actions { display:flex; justify-content:flex-end; gap:12px; padding:20px 24px; border-top:1px solid #f1f5f9; }
    .btn-cancel { padding:9px 20px; background:white; color:#374151; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.85rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; }
    .btn-submit { padding:9px 24px; background:var(--navy-dark); color:white; border:none; border-radius:9px; font-size:0.85rem; font-weight:600; cursor:pointer; font-family:inherit; }
    .btn-submit:hover { background:var(--navy-darkest); }
    .nomor-surat-badge { display:inline-flex; align-items:center; gap:8px; padding:8px 14px; background:#eff6ff; border:1.5px solid #bfdbfe; border-radius:9px; font-size:0.83rem; font-weight:700; color:#1d4ed8; }
    .foto-preview { display:flex; flex-wrap:wrap; gap:10px; margin-top:10px; }
    .foto-preview img { width:80px; height:80px; object-fit:cover; border-radius:8px; border:1.5px solid #e2e8f0; }
    .foto-hint { font-size:0.72rem; color:#94a3b8; margin-top:4px; }
    .section-divider { grid-column:1/-1; border:none; border-top:1.5px dashed #e2e8f0; margin:4px 0; }
</style>

<div style="margin-bottom:20px;">
    <a href="{{ route('guru-bk.home-visit.index') }}" class="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

@if($errors->any())
<div class="alert-error">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('guru-bk.home-visit.store') }}" enctype="multipart/form-data">
    @csrf

    {{-- INFORMASI UMUM --}}
    <div class="card">
        <div class="card-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="card-header-title">Informasi Umum</span>
        </div>
        <div class="card-body">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Nomor Surat</label>
                    <div class="nomor-surat-badge">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                        {{ $nomorSurat }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Siswa <span class="req">*</span></label>
                    <select name="siswa_id" id="siswa_id" class="form-control" required onchange="autoFillSiswa(this)">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}"
                                data-alamat="{{ $siswa->alamat }}"
                                data-ortu="{{ $siswa->nama_ortu }}"
                                data-hp="{{ $siswa->no_hp_ortu }}"
                                {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->name }} — {{ $siswa->kelas->nama ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Kunjungan <span class="req">*</span></label>
                    <input type="date" name="tanggal" class="form-control"
                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label>Jam Mulai <span class="req">*</span></label>
                    <input type="time" name="jam_mulai" class="form-control"
                           value="{{ old('jam_mulai') }}" required>
                </div>

                <div class="form-group">
                    <label>Jam Selesai <span class="req">*</span></label>
                    <input type="time" name="jam_selesai" class="form-control"
                           value="{{ old('jam_selesai') }}" required>
                </div>

                <div class="form-group">
                    <label>Yang Menemani Guru BK</label>
                    <input type="text" name="yang_menemani" class="form-control"
                           value="{{ old('yang_menemani') }}"
                           placeholder="Nama pendamping atau kosongkan jika sendiri">
                </div>

                <div class="form-group">
                    <label>Status Kehadiran Orang Tua <span class="req">*</span></label>
                    <select name="status_kehadiran_ortu" class="form-control" required>
                        <option value="Ada" {{ old('status_kehadiran_ortu') == 'Ada' ? 'selected' : '' }}>Ada</option>
                        <option value="Tidak Ada" {{ old('status_kehadiran_ortu') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                    </select>
                </div>

            </div>
        </div>
    </div>

    {{-- DATA ORANG TUA --}}
    <div class="card">
        <div class="card-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="card-header-title">Data Orang Tua / Wali</span>
        </div>
        <div class="card-body">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Alamat Rumah</label>
                    <input type="text" id="alamat" class="form-control" disabled
                        value="{{ old('alamat') }}"
                        placeholder="Otomatis terisi saat pilih siswa"
                        style="background:#f8fafc;">
                    <input type="hidden" name="alamat" id="alamat_hidden">
                </div>

                <div class="form-group">
                    <label>Nama Orang Tua / Wali</label>
                    <input type="text" id="nama_ortu" class="form-control" disabled
                        value="{{ old('nama_ortu') }}"
                        placeholder="Otomatis terisi saat pilih siswa"
                        style="background:#f8fafc;">
                    <input type="hidden" name="nama_ortu" id="nama_ortu_hidden">
                </div>

                <div class="form-group">
                    <label>No HP Orang Tua</label>
                    <input type="text" id="no_hp_ortu" class="form-control" disabled
                        value="{{ old('no_hp_ortu') }}"
                        placeholder="Otomatis terisi saat pilih siswa"
                        style="background:#f8fafc;">
                    <input type="hidden" name="no_hp_ortu" id="no_hp_ortu_hidden">
                </div>

            </div>
        </div>
    </div>

    {{-- CATATAN KUNJUNGAN --}}
    <div class="card">
        <div class="card-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <span class="card-header-title">Catatan Kunjungan</span>
        </div>
        <div class="card-body">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Tujuan Kunjungan <span class="req">*</span></label>
                    <textarea name="tujuan" class="form-control" required
                              placeholder="Contoh: Menindaklanjuti ketidakhadiran siswa 3 hari berturut-turut (alasan utama kunjungan dilakukan)">{{ old('tujuan') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Kondisi Lingkungan Rumah</label>
                    <textarea name="kondisi_lingkungan" class="form-control"
                              placeholder="Contoh: Rumah layak huni, orang tua bekerja sebagai buruh, siswa diasuh nenek (gambaran situasi keluarga saat kunjungan)">{{ old('kondisi_lingkungan') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Hasil Kunjungan</label>
                    <textarea name="hasil" class="form-control"
                              placeholder="Contoh: Orang tua belum mengetahui absensi siswa, siswa mengaku malas karena masalah pertemanan (temuan faktual saat kunjungan)">{{ old('hasil') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Kesimpulan</label>
                    <textarea name="kesimpulan" class="form-control"
                              placeholder="Contoh: Siswa membutuhkan pendampingan khusus akibat kurangnya perhatian orang tua di rumah (ringkasan keseluruhan kunjungan)">{{ old('kesimpulan') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Rekomendasi</label>
                    <textarea name="rekomendasi" class="form-control"
                              placeholder="Contoh: Koordinasi dengan wali kelas dan orang tua untuk membuat jadwal belajar di rumah (saran/solusi yang diusulkan saat kunjungan)">{{ old('rekomendasi') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" class="form-control"
                              placeholder="Contoh: Jadwalkan sesi konseling Senin depan, hubungi orang tua via telepon H+3 untuk konfirmasi (aksi nyata yang akan dilakukan setelah kunjungan)">{{ old('tindak_lanjut') }}</textarea>
                </div>

            </div>
        </div>
    </div>

    {{-- FOTO DOKUMENTASI --}}
    <div class="card">
        <div class="card-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--navy-dark)"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="card-header-title">Foto Dokumentasi</span>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Upload Foto <span class="req">*</span></label>
                <input type="file" name="fotos[]" id="fotos" class="form-control"
                    accept="image/jpg,image/jpeg,image/png"
                    multiple required onchange="previewFotos(this)">
                <div class="foto-hint">Min 1 foto, Maks 10 foto. Format: JPG, JPEG, PNG. Maks 2MB per foto.</div>
                <div id="fotoInfo" style="display:none; margin-top:8px; padding:8px 14px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; font-size:0.78rem; color:#1d4ed8; font-weight:600;">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="fotoInfoText"></span>
                </div>
                <div class="foto-preview" id="fotoPreview" style="display:flex; flex-wrap:wrap; gap:12px; margin-top:10px;"></div>
            </div>
        </div>
        <div class="footer-actions">
            <a href="{{ route('guru-bk.home-visit.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">Simpan Kunjungan</button>
        </div>
    </div>

</form>

@push('scripts')
<script>
// Auto-fill data siswa
function autoFillSiswa(select) {
    const opt  = select.options[select.selectedIndex];
    const alamat = opt.dataset.alamat || '';
    const ortu   = opt.dataset.ortu   || '';
    const hp     = opt.dataset.hp     || '';

    document.getElementById('alamat').value     = alamat || 'Belum diisi — hubungi Admin';
    document.getElementById('nama_ortu').value  = ortu   || 'Belum diisi — hubungi Admin';
    document.getElementById('no_hp_ortu').value = hp     || 'Belum diisi — hubungi Admin';

    document.getElementById('alamat_hidden').value     = alamat;
    document.getElementById('nama_ortu_hidden').value  = ortu;
    document.getElementById('no_hp_ortu_hidden').value = hp;
}

// === FOTO AKUMULATIF (sama seperti Edit) ===
let selectedFiles = [];
const maxSlot = 10;

function previewFotos(input) {
    const newFiles = Array.from(input.files);
    newFiles.forEach(file => {
        if (selectedFiles.length >= maxSlot) return;
        selectedFiles.push(file);
    });
    input.value = '';
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    document.getElementById('fotos').files = dt.files;
    renderPreview();
}

function hapusFoto(index) {
    selectedFiles.splice(index, 1);
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    document.getElementById('fotos').files = dt.files;
    renderPreview();
}

function renderPreview() {
    const preview  = document.getElementById('fotoPreview');
    const infoBox  = document.getElementById('fotoInfo');
    const infoText = document.getElementById('fotoInfoText');

    preview.innerHTML = '';

    if (selectedFiles.length === 0) {
        infoBox.style.display = 'none';
        return;
    }

    const sisa = maxSlot - selectedFiles.length;
    infoBox.style.display = 'block';

    if (sisa === 0) {
        infoText.innerHTML = `✅ ${selectedFiles.length} foto dipilih — batas maksimal tercapai.`;
    } else {
        infoText.innerHTML = `${selectedFiles.length} foto dipilih. Anda dapat menambahkan <strong>${sisa} foto lagi</strong>.`;
    }

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = e => {
            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'display:flex; flex-direction:column; align-items:center; gap:5px; position:relative; flex-shrink:0;';

            const btnHapus = document.createElement('button');
            btnHapus.type = 'button';
            btnHapus.innerHTML = '✕';
            btnHapus.onclick = () => hapusFoto(index);
            btnHapus.style.cssText = 'position:absolute; top:-6px; right:-6px; width:20px; height:20px; background:#ef4444; color:white; border:none; border-radius:50%; font-size:0.65rem; cursor:pointer; display:flex; align-items:center; justify-content:center; font-weight:700; line-height:1; padding:0;';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:90px; height:90px; object-fit:cover; border-radius:10px; border:1.5px solid #e2e8f0; display:block;';

            const label = document.createElement('span');
            label.textContent = `Foto ke-${index + 1}`;
            label.style.cssText = 'font-size:0.7rem; color:#64748b; font-weight:600; white-space:nowrap;';

            wrapper.appendChild(btnHapus);
            wrapper.appendChild(img);
            wrapper.appendChild(label);
            preview.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
@endsection