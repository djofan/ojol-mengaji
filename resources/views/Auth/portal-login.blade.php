<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Ojol Mengaji</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .card {
            width: 100%;
            max-width: 380px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 36px 32px;
        }
        .brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .brand h1 {
            color: #f1f5f9;
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 4px;
        }
        .brand p {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }
        label {
            display: block;
            color: #94a3b8;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 6px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            border: 1.5px solid rgba(148,163,184,0.2);
            background: rgba(255,255,255,0.02);
            color: #f1f5f9;
            font-size: 14px;
            margin-bottom: 16px;
        }
        input:focus {
            outline: none;
            border-color: #22c55e;
        }
        button {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: #22c55e;
            color: #0f172a;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }
        button:hover { background: #16a34a; }
        .error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            margin-bottom: 16px;
        }
        .footer-note {
            text-align: center;
            color: #475569;
            font-size: 11.5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <h1>Ojol Mengaji</h1>
            <p>Masuk dengan kode akun kamu</p>
        </div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="code">Kode Akun</label>
            <input type="text" id="code" name="code" value="{{ old('code') }}" placeholder="Contoh: GTQ001" autofocus autocapitalize="characters">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••">

            <button type="submit">Masuk</button>
        </form>

        <p class="footer-note">Lupa kode akun? Hubungi admin.</p>
    </div>
</body>
</html>
