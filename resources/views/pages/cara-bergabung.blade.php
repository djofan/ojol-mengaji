@extends('layouts.site')

@section('title', 'Cara Bergabung')

@php($active = 'cara-bergabung')

@section('extra-style')
    <style>
        .onboard-list { position: relative; max-width: 720px; padding-left: 3rem; }
        .onboard-list::before {
            content: '';
            position: absolute; left: 21px; top: 8px; bottom: 8px; width: 2px;
            background-image: linear-gradient(var(--paper-line) 60%, transparent 0%);
            background-size: 2px 12px; background-repeat: repeat-y;
        }
        .onboard-step { position: relative; padding-bottom: 2.75rem; }
        .onboard-step:last-child { padding-bottom: 0; }
        .onboard-marker {
            position: absolute; left: -3rem; top: 0;
            width: 44px; height: 44px; border-radius: 50%;
            background: var(--bg); border: 2px solid var(--teal);
            display: flex; align-items: center; justify-content: center;
            font-family: 'IBM Plex Mono', monospace; font-weight: 600; color: var(--teal); font-size: 0.95rem;
        }
        .onboard-title { font-size: 1.08rem; font-weight: 700; color: var(--ink); margin-bottom: 0.5rem; }
        .onboard-desc { font-size: 0.92rem; line-height: 1.7; color: var(--ink-muted); }

        .onboard-cta { margin-top: 3rem; display: flex; gap: 1rem; flex-wrap: wrap; }

        @media (max-width: 640px) {
            .onboard-list { padding-left: 2.5rem; }
            .onboard-marker { left: -2.5rem; width: 38px; height: 38px; font-size: 0.85rem; }
        }
    </style>
@endsection

@section('content')

    <header class="page-header">
        <div class="container">
            <div class="page-eyebrow"><span class="page-eyebrow-dot"></span>Cara Bergabung</div>
            <h1 class="page-title">Empat Langkah Menuju Kode Akun Pertamamu</h1>
            <p class="page-desc">Nggak ada pendaftaran online mandiri — semua akun didaftarkan lewat admin biar setiap peserta langsung tersambung ke kelompok dan guru pembimbingnya.</p>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <div class="onboard-list">
                <div class="onboard-step">
                    <div class="onboard-marker">01</div>
                    <div class="onboard-title">Hubungi admin lewat WhatsApp</div>
                    <p class="onboard-desc">Kirim pesan singkat berisi nama lengkap dan niat bergabung sebagai peserta atau guru di program Ojol Mengaji.</p>
                </div>
                <div class="onboard-step">
                    <div class="onboard-marker">02</div>
                    <div class="onboard-title">Admin daftarkan akun & kelompok</div>
                    <p class="onboard-desc">Admin membuatkan akunmu dan menempatkanmu di kelompok dengan guru penanggung jawab langsung — kamu akan menerima kode akun unik.</p>
                </div>
                <div class="onboard-step">
                    <div class="onboard-marker">03</div>
                    <div class="onboard-title">Login pertama & lengkapi profil</div>
                    <p class="onboard-desc">Masuk ke halaman login pakai kode akun (bukan email), lalu lengkapi data diri di profil.</p>
                </div>
                <div class="onboard-step">
                    <div class="onboard-marker">04</div>
                    <div class="onboard-title">Mulai kirim setoran</div>
                    <p class="onboard-desc">Rekam hafalan suara atau video kapan pun ada waktu luang, kirim, lalu tunggu tinjauan dari guru — biasanya kurang dari 24 jam.</p>
                </div>
            </div>

            <div class="onboard-cta">
                <a href="https://wa.me/628111186626" target="_blank" class="btn-primary">Hubungi Admin Sekarang</a>
                <a href="{{ url('/login') }}" class="btn-outline-dark">Sudah Punya Kode? Masuk</a>
            </div>
        </div>
    </section>

@endsection
