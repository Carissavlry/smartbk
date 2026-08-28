<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru – SmartBK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }
        body {
            min-height: 100dvh;
            font-family: Poppins, "Segoe UI", sans-serif;
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
            background: white;
            border-radius: 20px;
            box-shadow: 0 32px 72px rgba(13,17,70,0.34);
            padding: 40px 36px;
            width: 100%;
            max-width: 420px;
        }
        .card__title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #1f3b8a;
            text-align: center;
            margin: 0 0 6px;
        }
        .card__sub {
            font-size: 0.8rem;
            color: #64748b;
            text-align: center;
            margin: 0 0 28px;
        }
        .auth-feedback--error {
            color: #b42318;
            border: 1px solid rgba(180,35,24,0.14);
            background: rgba(254,242,242,0.92);
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 0.78rem;
            margin-bottom: 16px;
        }
        .auth-feedback--error ul { margin: 0; padding-left: 16px; }
        .field { position: relative; margin-bottom: 20px; }
        .field__icon {
            position: absolute; left: 0; top: 50%;
            transform: translateY(-50%);
            width: 18px; height: 18px;
            color: #d8223d; pointer-events: none;
        }
        .field__icon svg { width: 100%; height: 100%; display: block; }
        .field__input {
            width: 100%; border: 0;
            border-bottom: 1.5px solid rgba(84,99,165,0.28);
            height: 42px; padding: 0 32px 8px 28px;
            background: transparent; color: #1f3b8a;
            font-size: 0.84rem; font-weight: 500;
            font-family: inherit;
            transition: border-color 160ms;
        }
        .field__input--masked { -webkit-text-security: disc; }
        .field__input::placeholder { color: #5967a5; opacity: 1; }
        .field__input:focus { outline: none; border-bottom-color: #224ac7; }
        .field__toggle {
            position: absolute; top: 50%; right: 0;
            transform: translateY(-50%);
            width: 24px; height: 24px;
            display: flex; align-items: center; justify-content: center;
            border: 0; background: transparent;
            color: #495998; cursor: pointer;
        }
        .field__toggle svg { width: 16px; height: 16px; }
        .field__hint { margin-top: 4px; padding-left: 28px; font-size: 0.68rem; font-weight: 700; color: #c0353a; }
        .btn-submit {
            width: 100%; margin-top: 8px; min-height: 44px;
            border: 0; border-radius: 13px;
            background: linear-gradient(90deg, #d71939 0%, #1f46bf 100%);
            color: white; font-size: 0.85rem; font-weight: 800;
            letter-spacing: 0.12em; text-transform: uppercase;
            cursor: pointer; font-family: inherit;
            box-shadow: 0 12px 26px rgba(48,54,127,0.22);
            transition: transform 160ms, box-shadow 160ms;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 16px 30px rgba(48,54,127,0.26); }
        .user-info { text-align: center; font-size: 0.72rem; color: #94a3b8; margin-top: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h1 class="card__title">Buat Password Baru</h1>
        <p class="card__sub">Login pertama kamu. Buat password baru yang hanya kamu ketahui.</p>

        @if ($errors->any())
            <div class="auth-feedback--error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('first-login.update') }}">
            @csrf
            <div class="field">
                <span class="field__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                        <path d="M8 11V8a4 4 0 1 1 8 0v3"></path>
                        <path d="M12 15v2"></path>
                    </svg>
                </span>
                <input type="text" id="pw1" name="password" required
                    placeholder="Password baru (min. 8 karakter)"
                    class="field__input field__input--masked" spellcheck="false">
                <button type="button" class="field__toggle" onclick="togglePw('pw1','eye1')">
                    <svg id="eye1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6-10-6-10-6Z"></path>
                        <circle cx="12" cy="12" r="2.8"></circle>
                    </svg>
                </button>
                @error('password')<p class="field__hint">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <span class="field__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                        <path d="M8 11V8a4 4 0 1 1 8 0v3"></path>
                        <path d="M12 15v2"></path>
                    </svg>
                </span>
                <input type="text" id="pw2" name="password_confirmation" required
                    placeholder="Ulangi password baru"
                    class="field__input field__input--masked" spellcheck="false">
                <button type="button" class="field__toggle" onclick="togglePw('pw2','eye2')">
                    <svg id="eye2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6-10-6-10-6Z"></path>
                        <circle cx="12" cy="12" r="2.8"></circle>
                    </svg>
                </button>
            </div>

            <button type="submit" class="btn-submit">Simpan & Masuk</button>
        </form>

        <p class="user-info">Login sebagai: {{ Auth::user()->name }}</p>
    </div>

    <script>
        function togglePw(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            const isHidden = input.classList.contains('field__input--masked');
            input.classList.toggle('field__input--masked', !isHidden);
            eye.innerHTML = isHidden
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>'
                : '<path d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="2.8"></circle>';
        }
    </script>
</body>
</html>