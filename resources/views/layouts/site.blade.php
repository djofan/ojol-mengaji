<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>@yield('title', 'Ojol Mengaji') &middot; {{ config('app.name', 'Ojol Mengaji') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            color-scheme: light;
            --bg: #ffffff;
            --paper: #f6f1e6;
            --paper-line: rgba(20, 23, 28, 0.09);
            --surface-line: rgba(20, 23, 28, 0.11);
            --ink: #14171c;
            --ink-muted: #6b6a63;
            --amber: #f2a63d;
            --amber-600: #d98f1f;
            --amber-soft: #fdf1dc;
            --teal: #1f8f74;
            --teal-soft: #e6f4f0;
        }

        html { scroll-behavior: smooth; }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after { animation-duration: 0.001ms !important; animation-iteration-count: 1 !important; transition-duration: 0.001ms !important; }
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; }
        :focus-visible { outline: 2px solid var(--amber-600); outline-offset: 3px; border-radius: 4px; }

        .container { max-width: 1180px; margin: 0 auto; padding: 0 1.5rem; }
        .mono { font-family: 'IBM Plex Mono', monospace; }
        .display { font-family: 'Oswald', sans-serif; }

        /* NAVBAR */
        .nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--paper-line);
        }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; height: 4.5rem; gap: 1.5rem; }
        .nav-brand { display: flex; align-items: center; gap: 0.65rem; text-decoration: none; flex-shrink: 0; }
        .nav-brand img { height: 34px; width: auto; }
        .nav-divider { width: 1px; height: 24px; background: var(--paper-line); }
        .nav-text { display: flex; flex-direction: column; line-height: 1.1; }
        .nav-name {
            font-family: 'Oswald', sans-serif; font-size: 0.98rem; font-weight: 600;
            color: var(--ink); text-transform: uppercase; letter-spacing: 0.04em;
        }
        .nav-sub { font-size: 0.66rem; font-weight: 500; color: var(--ink-muted); letter-spacing: 0.02em; }

        .nav-links { display: none; align-items: center; gap: 2rem; list-style: none; flex: 1; justify-content: center; }
        .nav-links a {
            font-size: 0.86rem; font-weight: 600; color: var(--ink-muted); text-decoration: none;
            padding: 0.4rem 0; border-bottom: 2px solid transparent; transition: color 0.2s, border-color 0.2s;
        }
        .nav-links a:hover { color: var(--ink); }
        .nav-links a.is-active { color: var(--amber-600); border-color: var(--amber-600); }

        .nav-right { display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0; }

        .btn-nav {
            font-size: 0.82rem; font-weight: 700; color: var(--ink); text-decoration: none;
            padding: 0.6rem 1.3rem; border-radius: 9px;
            background: var(--amber);
            transition: background 0.2s ease, transform 0.2s ease;
            white-space: nowrap;
        }
        .btn-nav:hover { background: var(--amber-600); transform: translateY(-1px); }

        .nav-toggle {
            display: flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: 8px; border: 1px solid var(--paper-line);
            background: transparent; color: var(--ink); cursor: pointer;
        }

        .nav-mobile {
            display: none; flex-direction: column; gap: 0.25rem;
            background: var(--bg); border-top: 1px solid var(--paper-line);
            padding: 0.75rem 1.5rem 1.25rem;
        }
        .nav-mobile.is-open { display: flex; }
        .nav-mobile a {
            font-size: 0.92rem; font-weight: 600; color: var(--ink-muted); text-decoration: none;
            padding: 0.65rem 0.25rem; border-bottom: 1px solid var(--paper-line);
        }
        .nav-mobile a.is-active { color: var(--amber-600); }
        .nav-mobile a:last-child { border-bottom: none; }

        @media (min-width: 900px) {
            .nav-links { display: flex; }
            .nav-toggle { display: none; }
        }
        @media (max-width: 899px) {
            .nav-toggle { display: flex; }
        }

        /* Shared buttons */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-size: 0.94rem; font-weight: 700; color: var(--ink); text-decoration: none;
            padding: 0.9rem 1.85rem; border-radius: 10px;
            background: var(--amber);
            box-shadow: 0 10px 26px rgba(242, 166, 61, 0.28);
            transition: all 0.25s ease;
        }
        .btn-primary:hover { background: var(--amber-600); transform: translateY(-2px); }

        .btn-outline {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-size: 0.94rem; font-weight: 700; color: var(--ink); text-decoration: none;
            padding: 0.9rem 1.7rem; border-radius: 10px;
            border: 1.5px solid var(--surface-line);
            transition: all 0.2s;
        }
        .btn-outline:hover { background: var(--paper); border-color: rgba(20,23,28,0.2); }

        .btn-outline-dark {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-size: 0.9rem; font-weight: 700; color: var(--ink); text-decoration: none;
            padding: 0.75rem 1.4rem; border-radius: 10px;
            border: 1.5px solid var(--paper-line);
            transition: all 0.2s;
        }
        .btn-outline-dark:hover { background: var(--paper); }

        /* Page header band (sub-pages) */
        .page-header { background: var(--paper); padding: 8.5rem 0 3.5rem; position: relative; overflow: hidden; }
        .page-header::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at 85% 15%, rgba(242, 166, 61, 0.14), transparent 45%);
            pointer-events: none;
        }
        .page-eyebrow {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.7rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase;
            color: var(--amber-600);
            border: 1px solid rgba(242, 166, 61, 0.4);
            background: var(--amber-soft);
            border-radius: 50px; padding: 0.45rem 1rem 0.45rem 0.75rem;
            margin-bottom: 1.25rem;
        }
        .page-eyebrow-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--amber-600); }
        .page-title {
            font-family: 'Oswald', sans-serif; font-size: clamp(1.9rem, 4.2vw, 2.9rem);
            font-weight: 600; text-transform: uppercase; letter-spacing: 0.005em;
            color: var(--ink); max-width: 640px;
        }
        .page-desc { font-size: 1rem; line-height: 1.7; color: var(--ink-muted); max-width: 560px; margin-top: 1rem; }

        /* Generic content section */
        .section { padding: 5rem 0; }
        .section-label {
            display: inline-block; font-family: 'IBM Plex Mono', monospace;
            font-size: 0.72rem; font-weight: 600; letter-spacing: 0.07em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 0.9rem;
        }
        .section-title {
            font-family: 'Oswald', sans-serif; font-size: clamp(1.5rem, 3.2vw, 2.1rem);
            font-weight: 600; text-transform: uppercase; letter-spacing: 0.005em;
            color: var(--ink); margin-bottom: 0.9rem;
        }
        .section-desc { font-size: 0.98rem; line-height: 1.7; color: var(--ink-muted); }

        /* CTA (setiap halaman) — panel bertona amber lembut biar tetap menonjol tanpa gelap */
        .cta-band { background: var(--amber-soft); padding: 4.5rem 0; border-top: 1px solid var(--paper-line); }
        .cta-inner { display: flex; align-items: center; justify-content: space-between; gap: 2rem; flex-wrap: wrap; }
        .cta-tag {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.06em; text-transform: uppercase; color: var(--amber-600); margin-bottom: 0.75rem;
        }
        .cta-title {
            font-family: 'Oswald', sans-serif; font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 600;
            text-transform: uppercase; color: var(--ink); margin-bottom: 0.6rem;
        }
        .cta-sub { font-size: 0.94rem; color: var(--ink-muted); max-width: 460px; line-height: 1.65; }
        .cta-actions { display: flex; gap: 1rem; flex-wrap: wrap; }

        /* FOOTER */
        .footer { background: var(--bg); border-top: 1px solid var(--paper-line); padding: 2rem 0; }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; }
        .footer-brand { display: flex; align-items: center; gap: 0.85rem; }
        .footer-brand img { height: 30px; width: auto; }
        .footer-name { font-family: 'Oswald', sans-serif; font-size: 0.88rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; color: var(--ink); }
        .footer-sub { font-size: 0.76rem; color: var(--ink-muted); }
        .footer-links { display: flex; gap: 1.25rem; list-style: none; flex-wrap: wrap; }
        .footer-links a { font-size: 0.78rem; color: var(--ink-muted); text-decoration: none; }
        .footer-links a:hover { color: var(--ink); }

        @yield('extra-style')

        @media (max-width: 768px) {
            .page-header { padding: 7.5rem 0 3rem; }
            .section { padding: 3.5rem 0; }
            .cta-inner { flex-direction: column; align-items: flex-start; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

    @php
        $navLinks = [
            'home'           => ['label' => 'Beranda', 'url' => url('/')],
            'tentang-kami'   => ['label' => 'Tentang Kami', 'url' => url('/tentang-kami')],
            'cara-bergabung' => ['label' => 'Cara Bergabung', 'url' => url('/cara-bergabung')],
            'faq'            => ['label' => 'FAQ', 'url' => url('/faq')],
            'kontak'         => ['label' => 'Kontak', 'url' => url('/kontak')],
        ];
        $active = $active ?? 'home';
    @endphp

    <!-- NAVBAR -->
    <nav class="nav">
        <div class="container nav-inner">
            <a href="{{ url('/') }}" class="nav-brand">
                <img src="{{ asset('images/logo.png') }}" alt="LAZ SIP">
                <div class="nav-divider"></div>
                <div class="nav-text">
                    <span class="nav-name">Ojol Mengaji</span>
                    <span class="nav-sub">LAZ Solidaritas Insan Peduli</span>
                </div>
            </a>

            <ul class="nav-links">
                @foreach ($navLinks as $key => $link)
                    <li><a href="{{ $link['url'] }}" class="{{ $active === $key ? 'is-active' : '' }}">{{ $link['label'] }}</a></li>
                @endforeach
            </ul>

            <div class="nav-right">
                <a href="{{ url('/login') }}" class="btn-nav">Masuk</a>
                <button type="button" class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>
            </div>
        </div>

        <div class="nav-mobile" id="navMobile">
            @foreach ($navLinks as $key => $link)
                <a href="{{ $link['url'] }}" class="{{ $active === $key ? 'is-active' : '' }}">{{ $link['label'] }}</a>
            @endforeach
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- CTA (di setiap halaman) -->
    <section class="cta-band">
        <div class="container cta-inner">
            <div>
                <div class="cta-tag">Bergabung Sekarang</div>
                <h2 class="cta-title">Siap Lanjutin Progres Kamu?</h2>
                <p class="cta-sub">Terbuka untuk peserta & guru aktif LAZ SIP di program Ojol Mengaji. Masuk dengan kode akun yang sudah didaftarkan admin.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ url('/login') }}" class="btn-primary">Masuk Sekarang</a>
                <a href="https://wa.me/628111186626" target="_blank" class="btn-outline">Hubungi Admin</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-inner">
            <div class="footer-brand">
                <img src="{{ asset('images/logo.png') }}" alt="LAZ SIP">
                <div>
                    <div class="footer-name">Ojol Mengaji</div>
                    <div class="footer-sub">Program Digital LAZ Solidaritas Insan Peduli &middot; Bogor, Jawa Barat</div>
                </div>
            </div>
            <ul class="footer-links">
                @foreach ($navLinks as $key => $link)
                    <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                @endforeach
            </ul>
            <div class="footer-sub">
                &copy; {{ date('Y') }} LAZ SIP &middot; v{{ app()->version() }}
            </div>
        </div>
    </footer>

    <script>
        const navToggle = document.getElementById('navToggle');
        const navMobile = document.getElementById('navMobile');
        if (navToggle && navMobile) {
            navToggle.addEventListener('click', function () {
                const isOpen = navMobile.classList.toggle('is-open');
                navToggle.setAttribute('aria-expanded', String(isOpen));
            });
        }
    </script>
</body>
</html>
