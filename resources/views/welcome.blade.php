<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Ojol Mengaji') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-700: #4d7c2e;
            --green-600: #6fa84e;
            --green-500: #7cb342;
            --green-100: #eef6e6;
            --orange-600: #e8920f;
            --orange-500: #f5a623;
            --orange-100: #fef3e0;
            --ink-900: #1f2924;
            --ink-700: #3d4a42;
            --ink-500: #6b7873;
            --paper: #fcfbf7;
            --paper-card: #ffffff;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--paper);
            color: var(--ink-900);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 1180px; margin: 0 auto; padding: 0 1.5rem; }

        /* ── NAVBAR ───────────────────────────────── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(252, 251, 247, 0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(31, 41, 36, 0.07);
        }
        .navbar-inner {
            display: flex; align-items: center; justify-content: space-between;
            height: 4.75rem;
        }
        .navbar-brand { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }
        .navbar-brand img { height: 38px; width: auto; }
        .brand-divider { width: 1px; height: 28px; background: rgba(31,41,36,0.12); }
        .brand-text-group { display: flex; flex-direction: column; line-height: 1.1; }
        .brand-text { font-size: 1rem; font-weight: 700; color: var(--ink-900); }
        .brand-sub { font-size: 0.65rem; font-weight: 500; color: var(--ink-500); letter-spacing: 0.04em; }

        .navbar-actions { display: flex; align-items: center; gap: 0.75rem; }
        .btn-nav-primary {
            font-size: 0.85rem; font-weight: 700; color: #fff; text-decoration: none;
            padding: 0.65rem 1.4rem; border-radius: 10px;
            background: var(--orange-500);
            box-shadow: 0 4px 14px rgba(245, 166, 35, 0.35);
            transition: all 0.2s ease;
        }
        .btn-nav-primary:hover { background: var(--orange-600); transform: translateY(-1px); }

        /* ── HERO ─────────────────────────────────── */
        .hero {
            padding: 10rem 0 5rem;
            position: relative;
            background: var(--paper);
            overflow: hidden;
        }
        .hero-blob {
            position: absolute; top: -120px; right: -160px;
            width: 480px; height: 480px; border-radius: 50%;
            background: radial-gradient(circle, rgba(124,179,66,0.16), transparent 70%);
            pointer-events: none;
        }
        .hero-blob-2 {
            position: absolute; bottom: -100px; left: -120px;
            width: 360px; height: 360px; border-radius: 50%;
            background: radial-gradient(circle, rgba(245,166,35,0.12), transparent 70%);
            pointer-events: none;
        }

        .eyebrow-tag {
            display: inline-flex; align-items: center; gap: 0.5rem;
            font-size: 0.78rem; font-weight: 700; color: var(--green-700);
            background: var(--green-100);
            border-radius: 50px; padding: 0.45rem 1rem 0.45rem 0.7rem;
            margin-bottom: 1.75rem;
        }
        .eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--orange-500); }

        .hero-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
            position: relative;
        }

        .hero-title {
            font-size: clamp(2.4rem, 5vw, 3.6rem);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -0.02em;
            color: var(--ink-900);
            max-width: 760px;
        }
        .hero-title .hl-green { color: var(--green-600); }
        .hero-title .hl-orange { position: relative; color: var(--ink-900); }
        .hero-title .hl-orange::after {
            content: '';
            position: absolute; left: 0; right: 0; bottom: 0.08em; height: 0.32em;
            background: var(--orange-100);
            z-index: -1;
        }

        .hero-desc {
            font-size: 1.05rem; line-height: 1.75; color: var(--ink-500);
            max-width: 560px; margin-top: 1.5rem;
        }

        .hero-actions { display: flex; align-items: center; gap: 1rem; margin-top: 2.25rem; flex-wrap: wrap; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-size: 0.95rem; font-weight: 700; color: #fff; text-decoration: none;
            padding: 0.9rem 1.9rem; border-radius: 12px;
            background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
            box-shadow: 0 8px 22px rgba(245, 166, 35, 0.32);
            transition: all 0.25s ease;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(245, 166, 35, 0.42); }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-size: 0.95rem; font-weight: 700; color: var(--green-700); text-decoration: none;
            padding: 0.9rem 1.7rem; border-radius: 12px;
            border: 1.5px solid var(--green-600);
            transition: all 0.2s;
        }
        .btn-secondary:hover { background: var(--green-100); }

        .hero-stats-row {
            display: flex; gap: 2.5rem; margin-top: 3.5rem;
            padding-top: 2rem; border-top: 1px solid rgba(31,41,36,0.08);
            flex-wrap: wrap;
        }
        .stat-num { font-size: 1.9rem; font-weight: 800; color: var(--ink-900); line-height: 1; margin-bottom: 0.3rem; }
        .stat-num span { color: var(--green-600); }
        .stat-label { font-size: 0.78rem; color: var(--ink-500); font-weight: 600; }

        .hero-visual {
            position: relative;
            display: flex; flex-direction: column; gap: 1rem;
        }
        .float-card {
            background: var(--paper-card);
            border: 1px solid rgba(31,41,36,0.07);
            border-radius: 18px;
            padding: 1.4rem 1.5rem;
            display: flex; align-items: flex-start; gap: 1rem;
            box-shadow: 0 8px 24px rgba(31,41,36,0.05);
        }
        .float-icon {
            width: 2.75rem; height: 2.75rem; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .float-icon.green { background: var(--green-100); color: var(--green-700); }
        .float-icon.orange { background: var(--orange-100); color: var(--orange-600); }
        .float-title { font-size: 0.95rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.2rem; }
        .float-desc { font-size: 0.83rem; color: var(--ink-500); line-height: 1.55; }

        /* ── PROGRAM SECTION ──────────────────────── */
        .section-program { padding: 6rem 0; background: #fff; }

        .section-header { max-width: 620px; margin-bottom: 3.5rem; }
        .section-label {
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--orange-600); display: block; margin-bottom: 0.6rem;
        }
        .section-title { font-size: 2rem; font-weight: 800; color: var(--ink-900); letter-spacing: -0.01em; margin-bottom: 0.8rem; }
        .section-desc { font-size: 1rem; color: var(--ink-500); line-height: 1.7; }

        .program-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.75rem;
        }
        .program-card {
            background: var(--paper);
            padding: 2.25rem 1.9rem;
            border-radius: 18px;
            border: 1px solid rgba(31,41,36,0.06);
            transition: all 0.3s ease;
            position: relative;
        }
        .program-card:hover { transform: translateY(-5px); box-shadow: 0 16px 32px rgba(31,41,36,0.08); }
        .program-card:nth-child(1) { border-top: 3px solid var(--green-600); }
        .program-card:nth-child(2) { border-top: 3px solid var(--orange-500); }
        .program-card:nth-child(3) { border-top: 3px solid var(--green-600); }

        .prog-icon-box {
            width: 3.25rem; height: 3.25rem; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.4rem;
        }
        .program-card:nth-child(1) .prog-icon-box,
        .program-card:nth-child(3) .prog-icon-box { background: var(--green-100); color: var(--green-700); }
        .program-card:nth-child(2) .prog-icon-box { background: var(--orange-100); color: var(--orange-600); }

        .prog-title { font-size: 1.15rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.65rem; }
        .prog-desc { font-size: 0.9rem; color: var(--ink-500); line-height: 1.65; }

        /* ── CTA BAND ──────────────────────────────── */
        .cta-band {
            background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
            color: #fff; padding: 4.5rem 0; position: relative; overflow: hidden;
        }
        .cta-band::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 280px; height: 280px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .cta-inner { display: flex; align-items: center; justify-content: space-between; gap: 2.5rem; position: relative; z-index: 1; }
        .cta-tag { font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--orange-100); margin-bottom: 0.5rem; }
        .cta-title { font-size: 1.85rem; font-weight: 800; letter-spacing: -0.01em; margin-bottom: 0.6rem; max-width: 480px; }
        .cta-sub { font-size: 0.95rem; color: rgba(255,255,255,0.85); line-height: 1.65; max-width: 480px; }
        .cta-actions { display: flex; gap: 0.9rem; align-items: center; flex-shrink: 0; flex-wrap: wrap; }

        .btn-cta-white {
            background: #fff; color: var(--green-700); font-weight: 700; text-decoration: none;
            padding: 0.9rem 1.9rem; border-radius: 12px; transition: all 0.2s;
        }
        .btn-cta-white:hover { background: var(--orange-100); transform: translateY(-1px); }
        .btn-cta-outline {
            border: 1.5px solid rgba(255,255,255,0.4); color: #fff; font-weight: 700; text-decoration: none;
            padding: 0.9rem 1.7rem; border-radius: 12px; transition: all 0.2s;
        }
        .btn-cta-outline:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

        /* ── FOOTER ────────────────────────────────── */
        .footer { background: var(--ink-900); padding: 2.75rem 0; color: rgba(255,255,255,0.6); font-size: 0.88rem; }
        .footer-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }
        .footer-brand { display: flex; align-items: center; gap: 0.75rem; }
        .footer-brand img { height: 28px; filter: brightness(0) invert(1); opacity: 0.9; }
        .footer-brand-name { font-weight: 700; color: #fff; font-size: 0.95rem; }
        .footer-sub { font-size: 0.78rem; color: rgba(255,255,255,0.5); }

        /* ── RESPONSIVE ────────────────────────────── */
        @media (min-width: 968px) {
            .hero-layout { grid-template-columns: 1.15fr 0.85fr; align-items: center; }
        }
        @media (max-width: 968px) {
            .program-grid { grid-template-columns: 1fr; }
            .cta-inner { flex-direction: column; text-align: center; align-items: center; }
            .footer-inner { flex-direction: column; text-align: center; }
        }
        @media (max-width: 576px) {
            .hero-actions { flex-direction: column; align-items: stretch; }
            .hero-stats-row { gap: 1.5rem; }
            .cta-actions { flex-direction: column; align-items: stretch; width: 100%; }
            .btn-primary, .btn-secondary, .btn-cta-white, .btn-cta-outline { text-align: center; justify-content: center; }
            .navbar-brand .brand-text-group { display: none; }
            .navbar-actions { gap: 0.5rem; }
            .btn-nav-primary { font-size: 0.78rem; padding: 0.5rem 0.85rem; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container navbar-inner">
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="LAZ SIP">
                <div class="brand-divider"></div>
                <div class="brand-text-group">
                    <span class="brand-text">Ojol Mengaji</span>
                    <span class="brand-sub">LAZ Solidaritas Insan Peduli</span>
                </div>
            </a>
            <div class="navbar-actions">
                <a href="{{ url('/login') }}" class="btn-nav-primary">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-blob"></div>
        <div class="hero-blob-2"></div>
        <div class="container">
            <div class="hero-layout">
                <div>
                    <div class="eyebrow-tag">
                        <span class="eyebrow-dot"></span>
                        Program Digital LAZ Solidaritas Insan Peduli
                    </div>

                    <h1 class="hero-title">
                        Setoran hafalan jadi <span class="hl-orange">lebih mudah</span>,
                        progres jadi <span class="hl-green">lebih jelas</span>.
                    </h1>

                    <p class="hero-desc">
                        Ojol Mengaji membantu peserta mengirim setoran, mengikuti kuis, dan memantau perkembangan — sementara guru/musyrif bisa meninjau dan memberi feedback tanpa ribet. Cukup satu akun, satu kode login.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ url('/login') }}" class="btn-primary">
                            Masuk dengan Kode Akun
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                        <a href="https://wa.me/628111186626" target="_blank" class="btn-secondary">Belum Punya Kode?</a>
                    </div>

                    <div class="hero-stats-row">
                        <div>
                            <div class="stat-num"><span>30+</span></div>
                            <div class="stat-label">Juz Terverifikasi</div>
                        </div>
                        <div>
                            <div class="stat-num"><span>100%</span></div>
                            <div class="stat-label">Berbasis Syariah</div>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="float-card">
                        <div class="float-icon green">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v1a7 7 0 0 1-14 0v-1"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                        </div>
                        <div>
                            <div class="float-title">Setoran Voice & Video</div>
                            <div class="float-desc">Rekam langsung dari browser atau upload file, tanpa aplikasi tambahan.</div>
                        </div>
                    </div>

                    <div class="float-card">
                        <div class="float-icon orange">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <div class="float-title">Kuis Langsung di Web</div>
                            <div class="float-desc">Kerjakan kuis pilihan ganda langsung di aplikasi, nilai keluar otomatis.</div>
                        </div>
                    </div>

                    <div class="float-card">
                        <div class="float-icon green">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        </div>
                        <div>
                            <div class="float-title">Progres Real-Time</div>
                            <div class="float-desc">Guru memantau perkembangan setiap kelompok dalam satu dashboard.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PROGRAM -->
    <section class="section-program" id="program">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Cara Kerja</span>
                <h2 class="section-title">Tiga langkah, satu alur yang rapi</h2>
                <p class="section-desc">Dari pengiriman setoran sampai rekap pencapaian, semua langkah dirancang supaya peserta dan guru tidak perlu bingung di tengah jalan.</p>
            </div>

            <div class="program-grid">
                <div class="program-card">
                    <div class="prog-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v1a7 7 0 0 1-14 0v-1"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                    </div>
                    <h3 class="prog-title">Kirim setoran atau kuis</h3>
                    <p class="prog-desc">Peserta merekam hafalan langsung dari browser atau mengunggah file, dan mengerjakan kuis pilihan ganda langsung di web.</p>
                </div>

                <div class="program-card">
                    <div class="prog-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h3 class="prog-title">Guru meninjau langsung</h3>
                    <p class="prog-desc">Setiap setoran masuk ke antrean koreksi. Guru mendengarkan, menonton, lalu memberi catatan atau menyetujui — kuis dinilai otomatis.</p>
                </div>

                <div class="program-card">
                    <div class="prog-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/></svg>
                    </div>
                    <h3 class="prog-title">Progres tercatat otomatis</h3>
                    <p class="prog-desc">Setiap hasil koreksi langsung memperbarui dashboard, jadi perkembangan selalu terlihat tanpa rekap manual.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-band">
        <div class="container cta-inner">
            <div>
                <div class="cta-tag">Bergabung Sekarang</div>
                <h2 class="cta-title">Siap melanjutkan progres kamu?</h2>
                <p class="cta-sub">Terbuka untuk peserta & guru aktif LAZ SIP di program Ojol Mengaji. Masuk dengan kode akun yang sudah didaftarkan admin.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ url('/login') }}" class="btn-cta-white">Masuk Sekarang</a>
                <a href="https://wa.me/628111186626" target="_blank" class="btn-cta-outline">Hubungi Admin</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-inner">
            <div class="footer-brand">
                <img src="{{ asset('images/logo.png') }}" alt="LAZ SIP">
                <div>
                    <div class="footer-brand-name">Ojol Mengaji</div>
                    <div class="footer-sub">Program Digital LAZ Solidaritas Insan Peduli · Bogor, Jawa Barat</div>
                </div>
            </div>
            <div class="footer-sub">
                &copy; {{ date('Y') }} LAZ SIP · Seluruh hak dilindungi · v{{ app()->version() }}
            </div>
        </div>
    </footer>

</body>
</html>
