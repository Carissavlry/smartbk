<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #eef1f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .wrapper {
            max-width: 480px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(13, 17, 70, 0.12);
        }

        .banner {
            background: linear-gradient(135deg, #0f1642, #6e1a35);
            padding: 34px 24px 28px;
            text-align: center;
        }

        .banner h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0 0 6px;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        .banner p {
            color: #dbe0f5;
            font-size: 12px;
            margin: 0;
        }

        .content {
            padding: 28px 26px;
            color: #1f3b8a;
        }

        .content h2 {
            font-size: 17px;
            margin: 0 0 12px;
        }

        .content p {
            font-size: 13px;
            line-height: 1.6;
            color: #4a5687;
            margin: 0 0 20px;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #d71939 0%, #1f46bf 100%);
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 12px 28px;
            border-radius: 10px;
        }

        .footer {
            text-align: center;
            padding: 18px;
            font-size: 11px;
            color: #9aa3c9;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="banner">
            <h1>SMART BK</h1>
            <p>Solusi konseling cerdas untuk siswa yang lebih baik</p>
        </div>

        <div class="content">
            <h2>Halo, {{ $name }}!</h2>
            <p>
                Kami menerima permintaan untuk reset password akun SmartBK kamu.
                Klik tombol di bawah untuk membuat password baru. Link ini akan
                kedaluwarsa dalam 60 menit.
            </p>

            <div style="text-align: center;">
                <a href="{{ $url }}" target="_blank" class="btn">Reset Password</a>
            </div>

            <p style="margin-top: 20px; font-size: 11px; color: #8b93bb;">
                Kalau kamu tidak merasa meminta reset password, abaikan saja email ini.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} SmartBK — Bimbingan Konseling
        </div>
    </div>
</body>

</html>