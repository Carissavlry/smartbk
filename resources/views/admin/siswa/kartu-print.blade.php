<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Identitas — {{ $siswa->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f1f5f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .print-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
        }
        .btn-print {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 22px;
            background: #052659; color: white;
            border: none; border-radius: 10px;
            font-size: 0.85rem; font-weight: 600;
            cursor: pointer; text-decoration: none;
        }
        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 18px;
            background: white; color: #475569;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 0.85rem; font-weight: 600;
            cursor: pointer; text-decoration: none;
        }

        /* Kartu */
        .kartu {
            width: 340px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(5,38,89,0.18);
        }
        .kartu-header {
            background: linear-gradient(135deg, #021024 0%, #052659 100%);
            padding: 18px 20px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .kartu-header__logo {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 900; color: white;
        }
        .kartu-header__school { font-size: 0.78rem; font-weight: 700; color: white; }
        .kartu-header__title { font-size: 0.68rem; color: #C1E8FF; margin-top: 1px; text-transform: uppercase; letter-spacing: 0.06em; }

        .kartu-body { padding: 20px; }
        .kartu-profile { display: flex; gap: 16px; align-items: flex-start; margin-bottom: 16px; }
        .kartu-avatar {
            width: 72px; height: 72px; border-radius: 14px;
            background: linear-gradient(135deg, #052659, #021024);
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.6rem; font-weight: 700;
            flex-shrink: 0; overflow: hidden;
            border: 3px solid #e8edf5;
        }
        .kartu-avatar img { width:100%; height:100%; object-fit:cover; }
        .kartu-name { font-size: 0.95rem; font-weight: 700; color: #021024; line-height: 1.3; }
        .kartu-nis { font-size: 0.75rem; color: #64748b; margin-top: 3px; font-family: monospace; }
        .kartu-kelas {
            display: inline-flex; margin-top: 6px; padding: 2px 10px;
            background: #eff6ff; color: #1d4ed8;
            border-radius: 20px; font-size: 0.72rem; font-weight: 600;
        }
        .kartu-divider { height: 1px; background: #f1f5f9; margin: 14px 0; }
        .kartu-details { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .kartu-detail__label { font-size: 0.65rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; }
        .kartu-detail__value { font-size: 0.78rem; color: #021024; font-weight: 500; margin-top: 1px; }

        .kartu-qr { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 14px; background: #f8faff; border-radius: 12px; }
        .kartu-qr svg { width: 110px; height: 110px; }
        .kartu-qr__label { font-size: 0.68rem; color: #94a3b8; text-align: center; }

        .kartu-footer {
            background: linear-gradient(135deg, #3A000C, #75162E);
            padding: 10px 20px;
            text-align: center;
        }
        .kartu-footer__text { font-size: 0.65rem; color: rgba(255,255,255,0.7); letter-spacing: 0.05em; text-transform: uppercase; }

        @media print {
            body { background: white; padding: 0; }
            .print-actions { display: none; }
            .kartu { box-shadow: none; border: 1px solid #e2e8f0; }
        }
    </style>
</head>
<body>

    {{-- Tombol Aksi (hilang saat print) --}}
    <div class="print-actions">
        <a href="{{ route('admin.siswa.kartu', $siswa) }}" class="btn-back">
            ← Kembali
        </a>
        <button onclick="window.print()" class="btn-print">
            🖨️ Print Sekarang
        </button>
    </div>

    {{-- Kartu --}}
    <div class="kartu">
        <div class="kartu-header">
            <div class="kartu-header__logo">S</div>
            <div>
                <div class="kartu-header__school">SmartBK</div>
                <div class="kartu-header__title">Kartu Identitas Siswa</div>
            </div>
        </div>

        <div class="kartu-body">
            <div class="kartu-profile">
                <div class="kartu-avatar">
                    @if($siswa->foto)
                        <img src="{{ Storage::url($siswa->foto) }}" alt="foto">
                    @else
                        {{ strtoupper(substr($siswa->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="kartu-name">{{ $siswa->name }}</div>
                    <div class="kartu-nis">NIS: {{ $siswa->nis }}</div>
                    <div class="kartu-kelas">{{ $siswa->kelas->nama ?? '-' }}</div>
                </div>
            </div>

            <div class="kartu-divider"></div>

            <div class="kartu-details">
                <div>
                    <div class="kartu-detail__label">Jenis Kelamin</div>
                    <div class="kartu-detail__value">{{ $siswa->jenis_kelamin ?? '-' }}</div>
                </div>
                <div>
                    <div class="kartu-detail__label">Tempat Lahir</div>
                    <div class="kartu-detail__value">{{ $siswa->tempat_lahir ?? '-' }}</div>
                </div>
                <div>
                    <div class="kartu-detail__label">Tanggal Lahir</div>
                    <div class="kartu-detail__value">
                        {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}
                    </div>
                </div>
                <div>
                    <div class="kartu-detail__label">No. HP</div>
                    <div class="kartu-detail__value">{{ $siswa->no_hp ?? '-' }}</div>
                </div>
            </div>

            <div class="kartu-qr">
                {!! $qrCode !!}
                <div class="kartu-qr__label">Scan untuk lihat profil lengkap</div>
            </div>
        </div>

        <div class="kartu-footer">
            <div class="kartu-footer__text">SmartBK — Sistem Informasi Bimbingan Konseling</div>
        </div>
    </div>

</body>
</html>