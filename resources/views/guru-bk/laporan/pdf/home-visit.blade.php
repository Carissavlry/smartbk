<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Home Visit</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 11pt; color: #000; background: #fff;
        margin: 1cm 1.5cm 1cm 1.5cm;
    }
    .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
    .kop-table td { border: none; padding: 0; vertical-align: middle; }
    .kop-logo { width: 70px; text-align: center; }
    .kop-logo img { width: 65px; height: 65px; }
    .kop-center { text-align: center; padding: 0 6px; }
    .kop-instansi { font-size: 10pt; margin-bottom: 1px; }
    .kop-nama { font-size: 15pt; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; }
    .kop-alamat { font-size: 8.5pt; }
    .kop-garis { border: none; border-top: 4px double #000; margin-bottom: 10px; }
    .judul { text-align: center; margin: 10px 0 2px; }
    .judul h2 { font-size: 13pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; text-decoration: underline; }
    .sub-judul { text-align: center; font-size: 10pt; margin-bottom: 12px; }
    .info-table { border-collapse: collapse; margin: 0 0 14px 10px; }
    .info-table td { border: none; padding: 1px 0; font-size: 10.5pt; line-height: 1.7; vertical-align: top; }
    .info-table td:first-child { width: 140px; }
    .info-table td:nth-child(2) { width: 14px; }
    table.data { width: 100%; border-collapse: collapse; margin-bottom: 6px; font-size: 9.5pt; }
    table.data thead tr { background: #1e293b; color: #fff; }
    table.data thead th { padding: 6px; text-align: left; border: 1px solid #1e293b; font-weight: bold; }
    table.data tbody td { padding: 4px 6px; border: 1px solid #cbd5e1; vertical-align: top; }
    table.data tbody tr:nth-child(even) { background: #f8fafc; }
    .badge { font-size: 8.5pt; font-weight: bold; padding: 1px 7px; border-radius: 3px; }
    .badge-hijau  { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
    .badge-kuning { background: #fef9c3; color: #713f12; border: 1px solid #fde047; }
    .badge-merah  { background: #fee2e2; color: #7f1d1d; border: 1px solid #fca5a5; }
    .kosong { text-align: center; color: #64748b; font-style: italic; padding: 10px; font-size: 10pt; border: 1px solid #cbd5e1; }
    .ttd-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
    .ttd-table td { border: none; padding: 0; vertical-align: top; width: 50%; }
    .ttd-kanan { text-align: center; }
    .ttd-space { height: 55px; }
    .ttd-nama { font-weight: bold; text-decoration: underline; }
    .footer-cetak { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 8pt; color: #64748b; border-top: 1px solid #cbd5e1; padding: 4px 0; }
</style>
</head>
<body>

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
                <div class="kop-nama">{{ $setting['nama_sekolah'] ?? $namaSekolah }}</div>
            @endif
            <div class="kop-alamat">
                {{ $setting['alamat_sekolah'] ?? '' }}
                @if(!empty($setting['telp_sekolah'])) &nbsp; Telp: {{ $setting['telp_sekolah'] }} @endif
            </div>
        </td>
        <td class="kop-logo"></td>
    </tr>
</table>
<hr class="kop-garis">

<div class="judul"><h2>Laporan Kunjungan Rumah (Home Visit)</h2></div>
<div class="sub-judul">Periode: {{ $dari->format('d F Y') }} &mdash; {{ $sampai->format('d F Y') }}</div>

<table class="info-table">
    <tr><td>Guru BK</td><td>:</td><td><strong>{{ $gurubk->name }}</strong></td></tr>
    <tr><td>Kelas</td><td>:</td><td>{{ $kelas ? $kelas->nama : 'Semua Kelas' }}</td></tr>
    <tr><td>Total Kunjungan</td><td>:</td><td><strong>{{ $homeVisits->count() }} kunjungan</strong></td></tr>
    <tr><td>Tanggal Cetak</td><td>:</td><td>{{ now()->translatedFormat('d F Y, H:i') }} WIB</td></tr>
</table>

@if($homeVisits->isEmpty())
    <p class="kosong">Tidak ada data home visit pada periode ini.</p>
@else
<table class="data">
    <thead><tr>
        <th style="width:30px;">No</th>
        <th style="width:82px;">Tanggal</th>
        <th>Nama Siswa</th>
        <th style="width:70px;">Kelas</th>
        <th>Alamat</th>
        <th>Nama Ortu</th>
        <th style="width:85px;">No. HP Ortu</th>
        <th>Tujuan</th>
        <th style="width:70px;">Status</th>
    </tr></thead>
    <tbody>
    @foreach($homeVisits as $i => $hv)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ \Carbon\Carbon::parse($hv->tanggal)->format('d/m/Y') }}</td>
        <td>{{ $hv->siswa->name ?? '-' }}</td>
        <td>{{ $hv->siswa->kelas->nama ?? '-' }}</td>
        <td>{{ \Illuminate\Support\Str::limit($hv->alamat ?? '-', 35) }}</td>
        <td>{{ $hv->nama_ortu ?? '-' }}</td>
        <td>{{ $hv->no_hp_ortu ?? '-' }}</td>
        <td>{{ \Illuminate\Support\Str::limit($hv->tujuan ?? '-', 40) }}</td>
        <td>
            @if($hv->status === 'selesai') <span class="badge badge-hijau">Selesai</span>
            @elseif($hv->status === 'terjadwal') <span class="badge badge-kuning">Terjadwal</span>
            @else <span class="badge badge-merah">{{ ucfirst($hv->status ?? '-') }}</span>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endif

<table class="ttd-table">
    <tr>
        <td></td>
        <td class="ttd-kanan">
            <p>{{ $setting['nama_kota'] ?? 'Sidoarjo' }}, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Guru Bimbingan &amp; Konseling,</p>
            <div class="ttd-space"></div>
            <p class="ttd-nama">{{ $gurubk->name }}</p>
            <p style="font-size:10pt;">NIP. {{ $gurubk->nip ?? '-' }}</p>
        </td>
    </tr>
</table>

<div class="footer-cetak">Dicetak otomatis oleh sistem SmartBK &mdash; {{ $setting['nama_sekolah'] ?? $namaSekolah }} &mdash; {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>