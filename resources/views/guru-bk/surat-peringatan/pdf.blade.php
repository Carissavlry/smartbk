<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Peringatan {{ $suratPeringatan->nomor_surat }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            margin: 1cm 1.5cm 1cm 1.5cm;
        }

        /* KOP SURAT */
        .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        .kop-table td { border: none; padding: 0; vertical-align: middle; }
        .kop-logo { width: 70px; text-align: center; }
        .kop-logo img { width: 65px; height: 65px; }
        .kop-center { text-align: center; padding: 0 6px; }
        .kop-instansi { font-size: 10pt; margin-bottom: 1px; }
        .kop-nama { font-size: 15pt; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; }
        .kop-alamat { font-size: 8.5pt; }
        .kop-garis { border: none; border-top: 4px double #000; margin-bottom: 14px; }

        /* JUDUL */
        .judul { text-align: center; margin: 14px 0 2px; }
        .judul h2 { font-size: 13pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; text-decoration: underline; }
        .nomor { text-align: center; font-size: 11pt; margin-bottom: 16px; }

        /* PEMBUKA */
        .pembuka { margin-bottom: 10px; line-height: 1.8; }

        /* DATA SISWA */
        .data-siswa { margin: 0 0 12px 20px; }
        .data-siswa table { border-collapse: collapse; }
        .data-siswa table td { border: none; padding: 1px 0; line-height: 1.7; vertical-align: top; }
        .data-siswa table td:first-child { width: 160px; }
        .data-siswa table td:nth-child(2) { width: 14px; }

        /* ISI & PENUTUP */
        .isi { line-height: 1.8; margin-bottom: 10px; text-align: justify; }
        .penutup { line-height: 1.8; margin-bottom: 16px; text-align: justify; }

        /* TTD */
        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        .ttd-table td { border: none; padding: 0; vertical-align: top; width: 50%; }
        .ttd-kanan { text-align: center; }
        .ttd-space { height: 60px; }
        .ttd-nama { font-weight: bold; text-decoration: underline; }
        .ttd-jabatan { font-size: 10pt; }

        /* BADGE */
        .level-badge { padding: 2px 10px; font-weight: bold; font-size: 10.5pt; }
        .level-kuning { background: #fef08a; color: #713f12; border: 1px solid #ca8a04; }
        .level-merah  { background: #fecaca; color: #7f1d1d; border: 1px solid #dc2626; }
        .level-hitam  { background: #1e293b; color: #fff;    border: 1px solid #000; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if(!empty($setting['logo_sekolah']))
                    <img src="{{ public_path('storage/' . $setting['logo_sekolah']) }}" alt="Logo">
                @endif
            </td>
            <td class="kop-center">
                @if(!empty($setting['kop_surat']))
                    @foreach(explode("\n", $setting['kop_surat']) as $baris)
                        @if(trim($baris))
                            <div class="{{ $loop->index === 1 ? 'kop-nama' : 'kop-instansi' }}">{{ trim($baris) }}</div>
                        @endif
                    @endforeach
                @else
                    <div class="kop-nama">{{ $setting['nama_sekolah'] ?? '' }}</div>
                @endif
                <div class="kop-alamat">
                    {{ $setting['alamat_sekolah'] ?? '' }}
                    @if(!empty($setting['telp_sekolah'])) &nbsp; Telp: {{ $setting['telp_sekolah'] }} @endif
                </div>
            </td>
            <td class="kop-logo">
                {{-- Kosong atau logo kedua jika ada --}}
            </td>
        </tr>
    </table>
    <hr class="kop-garis">

    {{-- JUDUL --}}
    <div class="judul"><h2>Surat Peringatan</h2></div>
    <div class="nomor">Nomor: {{ $suratPeringatan->nomor_surat }}</div>

    {{-- PEMBUKA --}}
    <div class="pembuka">
        Yang bertanda tangan di bawah ini, Guru Bimbingan dan Konseling (BK)
        <strong>{{ $setting['nama_sekolah'] ?? '' }}</strong>, dengan ini menyatakan bahwa siswa:
    </div>

    {{-- DATA SISWA --}}
    <div class="data-siswa">
        <table>
            <tr>
                <td>Nama Lengkap</td><td>:</td>
                <td><strong>{{ $suratPeringatan->siswa->name ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>NIS / NISN</td><td>:</td>
                <td>{{ $suratPeringatan->siswa->nis ?? '-' }} / {{ $suratPeringatan->siswa->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelas</td><td>:</td>
                <td>{{ $suratPeringatan->siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td><td>:</td>
                <td>{{ $suratPeringatan->siswa->tahunAjaran->nama ?? date('Y').'/'.( date('Y')+1) }}</td>
            </tr>
            <tr>
                <td>Level Peringatan</td><td>:</td>
                <td>
                    <span class="level-badge level-{{ $suratPeringatan->level }}">
                        Surat Peringatan {{ ucfirst($suratPeringatan->level) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Total Poin Pelanggaran</td><td>:</td>
                <td><strong>{{ $suratPeringatan->total_poin }} Poin</strong></td>
            </tr>
        </table>
    </div>

    {{-- ISI SURAT --}}
    <div class="isi">{{ $suratPeringatan->isi_surat }}</div>

    {{-- PENUTUP --}}
    <div class="penutup">
        Demikian surat peringatan ini dibuat untuk diketahui dan diindahkan oleh siswa yang bersangkutan
        beserta orang tua/wali. Apabila siswa tetap melakukan pelanggaran, maka akan dikenakan sanksi
        yang lebih berat sesuai dengan tata tertib sekolah yang berlaku.
    </div>

    {{-- TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            <td>
                <p>Mengetahui,</p>
                <p>Orang Tua / Wali Siswa</p>
                <div class="ttd-space"></div>
                <p class="ttd-nama">( _________________________ )</p>
            </td>
            <td class="ttd-kanan">
                <p>Sidoarjo, {{ $suratPeringatan->created_at->translatedFormat('d F Y') }}</p>
                <p>Guru Bimbingan Konseling,</p>
                <div class="ttd-space"></div>
                <p class="ttd-nama">{{ $suratPeringatan->guruBk->name ?? '-' }}</p>
                <p class="ttd-jabatan">Guru BK</p>
            </td>
        </tr>
    </table>

</body>
</html>