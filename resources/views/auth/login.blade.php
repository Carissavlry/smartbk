<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smartbk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --smartbk-blue: #1f3b8a;
            --smartbk-blue-soft: #5364a8;
            --smartbk-blue-line: rgba(84, 99, 165, 0.28);
            --smartbk-red: #d8223d;
            --smartbk-white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body.login-page {
            min-height: 100dvh;
            margin: 0;
            font-family: Poppins, "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--smartbk-blue);
            background:
                linear-gradient(135deg, rgba(7, 18, 76, 0.8), rgba(120, 16, 78, 0.38)),
                url('{{ asset('images/bg_login.png') }}') center center / cover no-repeat;
            background-attachment: fixed;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .login-shell {
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(16px, 3vh, 40px) clamp(16px, 4vw, 60px);
        }

        .login-stage {
            position: relative;
            width: min(960px, 92vw);
            aspect-ratio: 1536 / 1024;
            background: url('{{ asset('images/login.png') }}') center center / 100% 100% no-repeat;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 32px 72px rgba(13, 17, 70, 0.34);
            isolation: isolate;
        }

        .login-panel {
            position: absolute;
            top: 36.8%;
            right: 15.4%;
            width: min(346px, 31.8%);
            display: block;
            padding: 0;
        }

        .login-panel__inner {
            width: 100%;
            max-height: none;
            display: block;
            overflow: visible;
            padding-right: 0;
        }

        .login-mobile-brand {
            display: none;
        }

        .login-mobile-card {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .login-mobile-card__heading,
        .login-mobile-card__copy {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .auth-feedback {
            margin-bottom: 8px;
            border-radius: 12px;
            padding: 8px 12px;
            font-size: 0.75rem;
            line-height: 1.45;
            backdrop-filter: blur(12px);
        }

        .auth-feedback--success {
            color: #166534;
            border: 1px solid rgba(22, 101, 52, 0.16);
            background: rgba(240, 253, 244, 0.88);
        }

        .auth-feedback--error {
            color: #b42318;
            border: 1px solid rgba(180, 35, 24, 0.14);
            background: rgba(254, 242, 242, 0.92);
        }

        .auth-feedback ul {
            margin: 0;
            padding-left: 18px;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .auth-field {
            position: relative;
            margin-bottom: 20px;
        }

        .auth-field__icon {
            position: absolute;
            left: 2px;
            top: 50%;
            width: 18px;
            height: 18px;
            transform: translateY(-50%);
            color: var(--smartbk-red);
            pointer-events: none;
        }

        .auth-field__icon svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .auth-input {
            width: 100%;
            border: 0;
            border-bottom: 1.5px solid var(--smartbk-blue-line);
            height: 40px;
            padding: 0 28px 8px 28px;
            background: transparent;
            color: var(--smartbk-blue);
            font-size: 0.79rem;
            font-weight: 500;
            line-height: 1.5;
            transition: border-color 160ms ease, box-shadow 160ms ease, color 160ms ease;
        }

        .auth-input--masked {
            -webkit-text-security: disc;
        }

        .auth-input::placeholder {
            color: #5967a5;
            opacity: 1;
            font-weight: 500;
        }

        .auth-input:-webkit-autofill,
        .auth-input:-webkit-autofill:hover,
        .auth-input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--smartbk-blue);
            caret-color: var(--smartbk-blue);
            -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0) inset;
            box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0) inset;
            transition: background-color 9999s ease-out 0s;
        }

        .auth-input:focus {
            outline: none;
            border-bottom-color: #224ac7;
            box-shadow: 0 10px 20px -20px rgba(34, 74, 199, 0.95);
        }

        .auth-toggle {
            position: absolute;
            top: 50%;
            right: 2px;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 0;
            background: transparent;
            color: #495998;
            cursor: pointer;
            transition: color 160ms ease, transform 160ms ease;
        }

        .auth-toggle svg {
            width: 16px;
            height: 16px;
        }

        .auth-toggle:hover,
        .auth-toggle:focus-visible {
            color: #203a8f;
            outline: none;
        }

        .auth-field__hint {
            margin-top: 4px;
            padding-left: 28px;
            font-size: 0.66rem;
            font-weight: 700;
            color: #c0353a;
        }


        .auth-submit {
            width: 100%;
            margin-top: 12px;
            min-height: 42px;
            border: 0;
            border-radius: 13px;
            background: linear-gradient(90deg, #d71939 0%, #1f46bf 100%);
            color: var(--smartbk-white);
            font-size: 0.84rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 12px 26px rgba(48, 54, 127, 0.22);
            transition: transform 160ms ease, box-shadow 160ms ease, filter 160ms ease;
        }

        .auth-submit:hover,
        .auth-submit:focus-visible {
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(48, 54, 127, 0.26);
            filter: saturate(1.08);
            outline: none;
        }

        .auth-divider {
            margin: 16px 0 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--smartbk-blue);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(78, 94, 160, 0.18);
        }

        .auth-google {
            width: 100%;
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 12px;
            border: 1px solid rgba(62, 77, 138, 0.12);
            background: rgba(255, 255, 255, 0.94);
            color: var(--smartbk-blue);
            font-size: 0.74rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 18px rgba(40, 54, 108, 0.1);
            transition: transform 160ms ease, box-shadow 160ms ease, background-color 160ms ease;
        }

        .auth-google:hover,
        .auth-google:focus-visible {
            transform: translateY(-1px);
            background: #ffffff;
            box-shadow: 0 12px 22px rgba(40, 54, 108, 0.14);
            outline: none;
        }

        .auth-google svg {
            width: 17px;
            height: 17px;
            flex: 0 0 auto;
        }

        .auth-switch {
            margin-top: 16px;
            text-align: center;
            font-size: 0.74rem;
            color: var(--smartbk-blue-soft);
        }

        .auth-switch a {
            color: var(--smartbk-red);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1180px) {
            .login-stage {
                width: min(900px, 92vw);
            }

            .login-panel {
                top: 36.3%;
                right: 14%;
                width: min(332px, 32.8%);
            }

            .auth-input {
                font-size: 0.8rem;
            }
        }

        @media (min-width: 1200px) {
            .login-stage {
                zoom: 0.8;
            }
        }

        @media (max-width: 960px) {
            .login-shell {
                padding: 18px 14px;
            }

            .login-stage {
                width: min(820px, 96vw);
            }

            .login-panel {
                top: 36.1%;
                right: 12.2%;
                width: min(304px, 35.8%);
            }

            .auth-submit {
                min-height: 44px;
            }
        }

        @media (max-width: 620px) {
            body.login-page {
                background-position: center top;
                background-attachment: scroll;
                overflow: auto;
            }

            .login-shell {
                padding: 14px;
            }

            .login-stage {
                width: 96vw;
                aspect-ratio: auto;
                min-height: 620px;
                background:
                    linear-gradient(180deg, rgba(11, 25, 88, 0.78) 0%, rgba(22, 39, 117, 0.6) 25%, rgba(255, 255, 255, 0.96) 25%, rgba(255, 255, 255, 0.98) 100%),
                    url('{{ asset('images/bg_login.png') }}') center top / cover no-repeat;
                border: 1px solid rgba(255, 255, 255, 0.16);
                box-shadow: 0 24px 60px rgba(8, 16, 66, 0.32);
            }

            .login-panel {
                position: absolute;
                top: 50%;
                left: 50%;
                right: auto;
                width: calc(100% - 28px);
                max-width: 380px;
                transform: translate(-50%, -50%);
                padding: 0;
            }

            .login-mobile-brand {
                display: block;
                margin-bottom: 12px;
                text-align: center;
                color: #ffffff;
            }

            .login-mobile-brand__title {
                margin: 0;
                font-size: clamp(2rem, 5vw, 2.5rem);
                font-weight: 800;
                letter-spacing: 0.03em;
            }

            .login-mobile-brand__subtitle {
                margin: 8px 0 0;
                font-size: 1rem;
                color: rgba(241, 245, 255, 0.9);
            }

            .login-mobile-card {
                border-radius: 18px;
                padding: 20px 16px;
                background: rgba(255, 255, 255, 0.93);
                box-shadow: 0 16px 38px rgba(20, 33, 92, 0.12);
                backdrop-filter: blur(10px);
            }

            .login-mobile-card__heading {
                position: static;
                width: auto;
                height: auto;
                margin: 0 0 8px;
                overflow: visible;
                clip: auto;
                white-space: normal;
                border: 0;
                font-size: 1.8rem;
                font-weight: 800;
                text-align: center;
                color: var(--smartbk-blue);
            }

            .login-mobile-card__copy {
                position: static;
                width: auto;
                height: auto;
                margin: 0 0 18px;
                overflow: visible;
                clip: auto;
                white-space: normal;
                font-size: 0.95rem;
                text-align: center;
                color: var(--smartbk-blue-soft);
            }

            .auth-submit,
            .auth-google {
                min-height: 45px;
            }
        }
    </style>
</head>
<body class="login-page">
    <div class="login-shell">
        <main class="login-stage">
            <h1 class="sr-only">Masuk ke SmartBK</h1>

            <section class="login-panel" aria-labelledby="login-form-title">
                <div class="login-panel__inner">
                    <div class="login-mobile-brand">
                        <p class="login-mobile-brand__title">SMART BK</p>
                        <p class="login-mobile-brand__subtitle">Bimbingan Konseling untuk siswa yang lebih baik</p>
                    </div>

                    <div class="login-mobile-card">
                        <h2 class="login-mobile-card__heading" id="login-form-title">Selamat Datang!</h2>
                        <p class="login-mobile-card__copy">Masuk untuk melanjutkan ke akun Anda</p>

                        @if (session('status'))
                            <div class="auth-feedback auth-feedback--success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="auth-feedback auth-feedback--error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="auth-form">
                            @csrf

                            <div class="auth-field">
                                <span class="auth-field__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21a8 8 0 0 0-16 0"></path>
                                        <circle cx="12" cy="8" r="4"></circle>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    value="{{ old('username') }}"
                                    required
                                    autofocus
                                    placeholder="Username / NIS / NIP"
                                    class="auth-input"
                                >
                                @error('username')
                                    <p class="auth-field__hint">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="auth-field">
                                <span class="auth-field__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                        <path d="M8 11V8a4 4 0 1 1 8 0v3"></path>
                                        <path d="M12 15v2"></path>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="Password"
                                    class="auth-input auth-input--masked"
                                    autocomplete="current-password"
                                    spellcheck="false"
                                >
                                <button
                                    type="button"
                                    class="auth-toggle"
                                    id="password-toggle"
                                    aria-controls="password"
                                    aria-label="Tampilkan password"
                                >
                                    <svg id="password-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6-10-6-10-6Z"></path>
                                        <circle cx="12" cy="12" r="2.8"></circle>
                                    </svg>
                                </button>
                                @error('password')
                                    <p class="auth-field__hint">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="auth-submit">
                                Masuk
                            </button>
                        </form>

                        <div class="auth-divider" aria-hidden="true">atau</div>

                        <a href="{{ route('auth.google') }}" class="auth-google">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09Z" />
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23Z" />
                                <path fill="#FBBC05" d="M5.84 14.09A6.96 6.96 0 0 1 5.49 12c0-.73.13-1.43.35-2.09V7.07H2.18A11.94 11.94 0 0 0 1 12c0 1.78.43 3.45 1.18 4.93l3.66-2.84Z" />
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53Z" />
                            </svg>
                            <span>Login dengan Google</span>
                        </a>
                        <p class="auth-switch">
                            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('password-toggle');
        const passwordEye = document.getElementById('password-eye');

        if (passwordInput && passwordToggle && passwordEye) {
            passwordToggle.addEventListener('click', function () {
                const isHidden = passwordInput.classList.contains('auth-input--masked');

                passwordInput.classList.toggle('auth-input--masked', !isHidden);
                passwordToggle.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
                passwordEye.innerHTML = isHidden
                    ? '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-6.4 0-10-6-10-6a21.78 21.78 0 0 1 5.06-5.94"></path><path d="M9.88 9.88A3 3 0 1 0 14.12 14.12"></path><path d="M22 12s-1.42 2.36-4.24 4.24"></path><path d="M14.12 14.12 9.88 9.88"></path><path d="M3 3 21 21"></path><path d="M12 5c6.4 0 10 6 10 6a21.73 21.73 0 0 1-2.53 3.34"></path>'
                    : '<path d="M2 12s3.6-6 10-6 10 6 10 6-3.6 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="2.8"></circle>';
            });
        }
    </script>
</body>
</html>
