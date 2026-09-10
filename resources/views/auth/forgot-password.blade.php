<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password – SmartBK</title>
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
            max-width: 440px;
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
            line-height: 1.5;
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
        .auth-feedback--success {
            color: #15803d;
            border: 1px solid rgba(21,128,61,0.16);
            background: rgba(240,253,244,0.92);
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 0.76rem;
            margin-bottom: 16px;
        }

        .field { margin-bottom: 20px; }
        .field__label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--smartbk-blue);
            margin-bottom: 5px;
            letter-spacing: 0.02em;
        }
        .field__input {
            width: 100%; border: 0;
            border-bottom: 1.5px solid var(--smartbk-blue-line);
            height: 38px; padding: 0 2px 6px;
            background: transparent; color: var(--smartbk-blue);
            font-size: 0.8rem; font-weight: 500;
            font-family: inherit;
            transition: border-color 160ms;
        }
        .field__input::placeholder { color: #5967a5; opacity: 1; }
        .field__input:focus { outline: none; border-bottom-color: #224ac7; }
        .field__hint { margin-top: 4px; font-size: 0.65rem; font-weight: 700; color: #c0353a; }

        .btn-submit {
            width: 100%; margin-top: 8px; min-height: 44px;
            border: 0; border-radius: 13px;
            background: linear-gradient(90deg, #d71939 0%, #1f46bf 100%);
            color: white; font-size: 0.84rem; font-weight: 800;
            letter-spacing: 0.12em; text-transform: uppercase;
            cursor: pointer; font-family: inherit;
            box-shadow: 0 12px 26px rgba(48,54,127,0.22);
            transition: transform 160ms, box-shadow 160ms, opacity 160ms;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 16px 30px rgba(48,54,127,0.26); }
        .btn-submit:disabled { cursor: not-allowed; transform: none; }

        .link-login {
            display: block; text-align: center; font-size: 0.76rem;
            color: var(--smartbk-blue-soft); margin-top: 18px;
        }
        .link-login a { color: var(--smartbk-red); font-weight: 700; text-decoration: none; }
        .link-login a:hover { text-decoration: underline; }

        @media (max-width: 560px) {
            .card { padding: 28px 22px; }
        }
    </style>
</head>
<body>
    <div class="card">
        <h1 class="card__title">Lupa Password?</h1>
        <p class="card__sub">Masukkan email kamu, kami akan mengirimkan link untuk reset password</p>

        @if (session('status'))
            <div class="auth-feedback--success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="auth-feedback--error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="field">
                <label class="field__label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="field__input" placeholder="email@contoh.com">
                @error('email')<p class="field__hint">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-submit" id="submit-btn">Kirim Link Reset Password</button>
        </form>

        <p class="link-login">Ingat password kamu? <a href="{{ route('login') }}">Login di sini</a></p>
    </div>

    @if (session('reset_cooldown_until') && session('reset_cooldown_until') > now()->timestamp)
        <script>
            (function () {
                const cooldownUntil = {{ session('reset_cooldown_until') }} * 1000;
                const btn = document.getElementById('submit-btn');
                const originalText = btn.textContent;

                function updateCountdown() {
                    const remaining = Math.max(0, Math.ceil((cooldownUntil - Date.now()) / 1000));
                    if (remaining <= 0) {
                        btn.disabled = false;
                        btn.textContent = originalText;
                        btn.style.opacity = 1;
                        clearInterval(timer);
                        return;
                    }
                    const minutes = Math.floor(remaining / 60);
                    const seconds = remaining % 60;
                    btn.disabled = true;
                    btn.style.opacity = 0.6;
                    btn.textContent = `Tunggu ${minutes}:${String(seconds).padStart(2, '0')}`;
                }

                updateCountdown();
                const timer = setInterval(updateCountdown, 1000);
            })();
        </script>
    @endif
</body>
</html>