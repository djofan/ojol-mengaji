@extends('site.layout')

@section('title', 'Beranda')

@section('extra-style')
    <style>
        /* HERO */
        .hero { padding: 9.5rem 0 4.5rem; background: var(--paper); position: relative; overflow: hidden; }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 12% 8%, rgba(242, 166, 61, 0.16), transparent 45%),
                radial-gradient(circle at 88% 92%, rgba(31, 143, 116, 0.12), transparent 45%);
            pointer-events: none;
        }
        .hero-inner { display: grid; grid-template-columns: 1fr; gap: 3rem; position: relative; }

        .hero-title {
            font-family: 'Oswald', sans-serif;
            font-size: clamp(2.3rem, 5.2vw, 3.75rem);
            font-weight: 600; line-height: 1.08; letter-spacing: 0.005em;
            text-transform: uppercase; color: var(--ink); max-width: 720px;
            opacity: 0; animation: fadeUp 0.6s ease 0.08s forwards;
        }
        .hero-title .hl { color: var(--amber-600); }

        .hero-desc {
            font-size: 1.04rem; line-height: 1.75; color: var(--ink-muted);
            max-width: 540px; margin-top: 1.5rem;
            opacity: 0; animation: fadeUp 0.6s ease 0.16s forwards;
        }

        .hero-actions {
            display: flex; align-items: center; gap: 1rem; margin-top: 2.25rem; flex-wrap: wrap;
            opacity: 0; animation: fadeUp 0.6s ease 0.24s forwards;
        }

        .hero-stats {
            display: flex; gap: 2.5rem; margin-top: 3.25rem;
            padding-top: 2rem; border-top: 1px solid var(--paper-line);
            flex-wrap: wrap;
            opacity: 0; animation: fadeUp 0.6s ease 0.32s forwards;
        }
        .stat-num { font-family: 'IBM Plex Mono', monospace; font-size: 1.7rem; font-weight: 600; color: var(--amber-600); line-height: 1; margin-bottom: 0.35rem; }
        .stat-label { font-size: 0.76rem; color: var(--ink-muted); font-weight: 600; letter-spacing: 0.01em; }

        .eyebrow {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.7rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase;
            color: var(--amber-600);
            border: 1px solid rgba(242, 166, 61, 0.4);
            background: var(--amber-soft);
            border-radius: 50px; padding: 0.45rem 1rem 0.45rem 0.75rem;
            margin-bottom: 1.75rem;
            opacity: 0; animation: fadeUp 0.6s ease forwards;
        }
        .eyebrow-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--amber-600); }

        /* TRIP CARD - signature element */
        .hero-visual { opacity: 0; animation: fadeUp 0.7s ease 0.2s forwards; }
        .trip-card {
            background: var(--bg); border: 1px solid var(--surface-line); border-radius: 20px;
            padding: 1.6rem 1.5rem 1.4rem; box-shadow: 0 20px 45px rgba(20, 23, 28, 0.08);
        }
        .trip-card-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.6rem; }
        .trip-card-label {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.68rem; font-weight: 600;
            letter-spacing: 0.07em; text-transform: uppercase; color: var(--ink-muted);
        }
        .trip-live { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.68rem; font-weight: 600; color: var(--teal); }
        .trip-live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--teal); animation: pulseDot 1.8s ease infinite; }

        .trip-route { position: relative; padding-left: 2.5rem; }
        .trip-route::before {
            content: '';
            position: absolute; left: 9px; top: 6px; bottom: 6px; width: 2px;
            background-image: linear-gradient(var(--surface-line) 60%, transparent 0%);
            background-size: 2px 10px; background-repeat: repeat-y;
        }
        .trip-stop { position: relative; padding-bottom: 1.6rem; }
        .trip-stop:last-child { padding-bottom: 0; }
        .trip-stop::before {
            content: '';
            position: absolute; left: -2.5rem; top: 2px;
            width: 20px; height: 20px; border-radius: 50%;
            border: 2px solid var(--surface-line); background: var(--bg);
        }
        .trip-stop.is-done::before { border-color: var(--amber-600); background: var(--amber); }
        .trip-stop.is-active::before { border-color: var(--teal); box-shadow: 0 0 0 4px var(--teal-soft); }
        .trip-stop-top { display: flex; align-items: baseline; justify-content: space-between; gap: 0.75rem; }
        .trip-stop-title { font-size: 0.94rem; font-weight: 700; color: var(--ink); }
        .trip-stop-time { font-family: 'IBM Plex Mono', monospace; font-size: 0.72rem; color: var(--ink-muted); white-space: nowrap; }
        .trip-stop.is-done .trip-stop-time { color: var(--amber-600); }
        .trip-stop.is-active .trip-stop-time { color: var(--teal); }
        .trip-stop-desc { font-size: 0.84rem; line-height: 1.55; color: var(--ink-muted); margin-top: 0.25rem; }

        .trip-card-foot {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 1.5rem; padding-top: 1.2rem; border-top: 1px solid var(--paper-line);
        }
        .trip-card-foot-label { font-size: 0.78rem; color: var(--ink-muted); }
        .trip-card-foot-val { font-family: 'IBM Plex Mono', monospace; font-size: 0.85rem; font-weight: 600; color: var(--amber-600); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulseDot { 0%, 100% { opacity: 1; } 50% { opacity: 0.35; } }

        /* Route strip (cara kerja) */
        .route-strip { position: relative; display: flex; gap: 2rem; }
        .route-strip::before {
            content: '';
            position: absolute; top: 22px; left: 6%; right: 6%; height: 2px;
            background-image: linear-gradient(to right, var(--paper-line) 60%, transparent 0%);
            background-size: 12px 2px; background-repeat: repeat-x;
        }
        .route-stop { flex: 1; position: relative; text-align: left; }
        .route-marker {
            position: relative; z-index: 2;
            width: 46px; height: 46px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: var(--bg); border: 2px solid var(--teal);
            font-family: 'IBM Plex Mono', monospace; font-weight: 600; font-size: 0.9rem; color: var(--teal);
            margin-bottom: 1.15rem;
        }
        .route-stop-title { font-size: 1.02rem; font-weight: 700; color: var(--ink); margin-bottom: 0.4rem; }
        .route-stop-desc { font-size: 0.88rem; line-height: 1.65; color: var(--ink-muted); }

        .section-head { max-width: 620px; margin: 0 auto 3.5rem; text-align: center; }

        @media (min-width: 900px) {
            .hero-inner { grid-template-columns: 1.1fr 0.9fr; align-items: center; }
        }
        @media (max-width: 899px) {
            .hero-visual { max-width: 460px; }
        }
        @media (max-width: 768px) {
            .hero { padding: 8rem 0 3.5rem; }
            .route-strip { flex-direction: column; gap: 1.75rem; }
            .route-strip::before { display: none; }
        }
    </style>
@endsection

@section('content')

    <!-- HERO -->
    <header class="hero">
        <div class="container hero-inner">
            <div>
                <div class="eyebrow">
                    <span class="eyebrow-dot"></span>
                    Program Digital LAZ SIP &middot; Bogor
                </div>

                <h1 class="hero-title">
                    Istirahat narik,<br>lanjut <span class="hl">setoran</span>.
                </h1>

                <p class="hero-desc">
                    Ojol Mengaji bikin proses setor hafalan, kuis, dan pantau progres jadi secepat checklist order berikutnya — login pakai kode akun, rekam, kirim, selesai.
                </p>

                <div class="hero-actions">
                    <a href="{{ url('/login') }}" class="btn-primary">
                        Masuk dengan Kode Akun
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                    <a href="{{ url('/cara-bergabung') }}" class="btn-outline">Belum Punya Kode?</a>
                </div>

                <div class="hero-stats">
                    <div>
                        <div class="stat-num">30+</div>
                        <div class="stat-label">Juz Terverifikasi</div>
                    </div>
                    <div>
                        <div class="stat-num">100%</div>
                        <div class="stat-label">Sesuai Syariah</div>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="trip-card">
                    <div class="trip-card-head">
                        <span class="trip-card-label">Rute Hafalan Hari Ini</span>
                        <span class="trip-live"><span class="trip-live-dot"></span>Live</span>
                    </div>

                    <div class="trip-route">
                        <div class="trip-stop is-done">
                            <div class="trip-stop-top">
                                <span class="trip-stop-title">Setoran Terkirim</span>
                                <span class="trip-stop-time">07.42</span>
                            </div>
                            <p class="trip-stop-desc">Rekam suara atau video langsung dari HP, tinggal kirim.</p>
                        </div>
                        <div class="trip-stop is-active">
                            <div class="trip-stop-top">
                                <span class="trip-stop-title">Ditinjau Guru</span>
                                <span class="trip-stop-time">Diproses</span>
                            </div>
                            <p class="trip-stop-desc">Guru dengar dan tonton, lalu kasih catatan atau approve.</p>
                        </div>
                        <div class="trip-stop">
                            <div class="trip-stop-top">
                                <span class="trip-stop-title">Progres Tercatat</span>
                                <span class="trip-stop-time">Menunggu</span>
                            </div>
                            <p class="trip-stop-desc">Dashboard kamu otomatis update begitu direview.</p>
                        </div>
                    </div>

                    <div class="trip-card-foot">
                        <span class="trip-card-foot-label">Estimasi ulasan guru</span>
                        <span class="trip-card-foot-val">&lt; 24 jam</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- CARA KERJA -->
    <section class="section">
        <div class="container">
            <div class="section-head">
                <span class="section-label">Cara Kerja</span>
                <h2 class="section-title">Tiga Perhentian, Satu Rute</h2>
                <p class="section-desc">Dari kirim setoran sampai progres tercatat, semua langkah dirancang biar peserta dan guru nggak perlu bolak-balik nanya.</p>
            </div>

            <div class="route-strip">
                <div class="route-stop">
                    <div class="route-marker">01</div>
                    <h3 class="route-stop-title">Kirim setoran atau kuis</h3>
                    <p class="route-stop-desc">Peserta merekam hafalan langsung dari browser atau mengunggah file, dan mengerjakan kuis pilihan ganda langsung di web.</p>
                </div>
                <div class="route-stop">
                    <div class="route-marker">02</div>
                    <h3 class="route-stop-title">Guru meninjau langsung</h3>
                    <p class="route-stop-desc">Setiap setoran masuk ke antrean koreksi. Guru mendengarkan, menonton, lalu memberi catatan atau menyetujui — kuis dinilai otomatis.</p>
                </div>
                <div class="route-stop">
                    <div class="route-marker">03</div>
                    <h3 class="route-stop-title">Progres tercatat otomatis</h3>
                    <p class="route-stop-desc">Setiap hasil koreksi langsung memperbarui dashboard, jadi perkembangan selalu terlihat tanpa rekap manual.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
