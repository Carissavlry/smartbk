<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun – SmartBK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --smartbk-blue: #1f3b8a;
            --smartbk-blue-soft: #5364a8;
            --smartbk-blue-line: rgba(84, 99, 165, 0.28);
            --smartbk-red: #d8223d;
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }
        body {
            min-height: 100dvh;
            font-family: Poppins, "Segoe UI", sans-serif;
            color: var(--smartbk-blue);
            background:
                linear-gradient(135deg, rgba(7,18,76,0.8), rgba(120,16,78,0.38)),
                url('{{ asset('images/bg_login.png') }}') center center / cover no-repeat;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            background: rgba(255,255,255,0.97);
            border-radius: 22px;
            box-shadow: 0 32px 72px rgba(13,17,70,0.34);
            padding: 36px 40px;
            width: 100%;
            max-width: 560px;
        }
        .card__title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--smartbk-blue);
            text-align: center;
            margin: 0 0 6px;
        }
        .card__sub {
            font-size: 0.78rem;
            color: var(--smartbk-blue-soft);
            text-align: center;
            margin: 0 0 24px;
        }
        .auth-feedback--error {
            color: #b42318;
            border: 1px solid rgba(180,35,24,0.14);
            background: rgba(254,242,242,0.92);
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 0.76rem;
            margin-bottom: 16px;
        }
        .auth-feedback--error ul { margin: 0; padding-left: 16px; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 20px;
        }
        .field { margin-bottom: 16px; }
        .field--full { grid-column: 1 / -1; }
        .field__label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--smartbk-blue);
            margin-bottom: 5px;
            letter-spacing: 0.02em;
        }
        .field__input, .field__select {
            width: 100%; border: 0;
            border-bottom: 1.5px solid var(--smartbk-blue-line);
            height: 38px; padding: 0 2px 6px;
            background: transparent; color: var(--smartbk-blue);
            font-size: 0.8rem; font-weight: 500;
            font-family: inherit;
            transition: border-color 160ms;
        }
        .field__input::placeholder { color: #5967a5; opacity: 1; }
        .field__input:focus, .field__select:focus { outline: none; border-bottom-color: #224ac7; }
        .field__hint { margin-top: 4px; font-size: 0.65rem; font-weight: 700; color: #c0353a; }

        .btn-submit {
            width: 100%; margin-top: 8px; min-height: 44px;
            border: 0; border-radius: 13px;
            background: linear-gradient(90deg, #d71939 0%, #1f46bf 100%);
            color: white; font-size: 0.84rem; font-weight: 800;
            letter-spacing: 0.12em; text-transform: uppercase;
            cursor: pointer; font-family: inherit;
            box-shadow: 0 12px 26px rgba(48,54,127,0.22);
            transition: transform 160ms, box-shadow 160ms;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 16px 30px rgba(48,54,127,0.26); }
        .link-login {
            display: block; text-align: center; font-size: 0.76rem;
            color: var(--smartbk-blue-soft); margin-top: 18px;
        }
        .link-login a { color: var(--smartbk-red); font-weight: 700; text-decoration: none; }
        .link-login a:hover { text-decoration: underline; }
        .hidden { display: none; }

        @media (max-width: 560px) {
            .card { padding: 28px 22px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="card">
        <h1 class="card__title">Daftar Akun</h1>
        <p class="card__sub">Pendaftaran Murid/Guru — akun akan aktif setelah disetujui Admin</p>

        @if ($errors->any())
            <div class="auth-feedback--error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-grid">
                <div class="field">
                    <label class="field__label">Daftar sebagai</label>
                    <select name="role" id="role" required class="field__select" onchange="toggleFields()">
                        <option value="">-- Pilih --</option>
                        <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Murid</option>
                        <option value="guru_bk" {{ old('role') == 'guru_bk' ? 'selected' : '' }}>Guru</option>
                    </select>
                    @error('role')<p class="field__hint">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label class="field__label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="field__input" placeholder="Nama lengkap">
                    @error('name')<p class="field__hint">{{ $message }}</p>@enderror
                </div>

                <div class="field" id="field-nis">
                    <label class="field__label">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" class="field__input" placeholder="Nomor Induk Siswa">
                    @error('nis')<p class="field__hint">{{ $message }}</p>@enderror
                </div>

                <div class="field" id="field-kelas">
                    <label class="field__label">Kelas</label>
                    <select name="kelas_id" class="field__select">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')<p class="field__hint">{{ $message }}</p>@enderror
                </div>

                <div class="field field--full" id="field-nip">
                    <label class="field__label">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip') }}" class="field__input" placeholder="Nomor Induk Pegawai">
                    @error('nip')<p class="field__hint">{{ $message }}</p>@enderror
                </div>

                <div class="field field--full">
                    <label class="field__label">Email (opsional)</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="field__input" placeholder="email@contoh.com">
                    @error('email')<p class="field__hint">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label class="field__label">Password</label>
                    <input type="password" name="password" required class="field__input" placeholder="Min. 6 karakter">
                    @error('password')<p class="field__hint">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label class="field__label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="field__input" placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit" class="btn-submit">Daftar</button>
        </form>

        <p class="link-login">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
    </div>

    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            document.getElementById('field-nis').classList.toggle('hidden', role !== 'siswa');
            document.getElementById('field-kelas').classList.toggle('hidden', role !== 'siswa');
            document.getElementById('field-nip').classList.toggle('hidden', role !== 'guru_bk');
        }
        toggleFields();
    </script>
</body>
</html>