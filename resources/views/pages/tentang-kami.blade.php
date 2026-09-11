@extends('site.layout')

@section('title', 'Tentang Kami')

@php($active = 'tentang-kami')

@section('extra-style')
    <style>
        .value-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2.5rem; }
        .value-card {
            background: var(--paper); border: 1px solid var(--paper-line); border-radius: 16px;
            padding: 1.75rem 1.5rem;
        }
        .value-icon {
            width: 44px; height: 44px; border-radius: 12px; background: var(--teal-soft);
            display: flex; align-items: center; justify-content: center; margin-bottom: 1.1rem; color: var(--teal);
        }
        .value-title { font-size: 1.02rem; font-weight: 700; color: var(--ink); margin-bottom: 0.5rem; }
        .value-desc { font-size: 0.88rem; line-height: 1.65; color: var(--ink-muted); }

        .about-split { display: grid; grid-template-columns: 1fr; gap: 2.5rem; align-items: start; }
        .about-stats { display: flex; gap: 2rem; margin-top: 2rem; flex-wrap: wrap; }
        .about-stat-num { font-family: 'IBM Plex Mono', monospace; font-size: 2rem; font-weight: 600; color: var(--teal); line-height: 1; margin-bottom: 0.4rem; }
        .about-stat-label { font-size: 0.8rem; color: var(--ink-muted); font-weight: 600; }

        .org-band {
            background: var(--paper); border: 1px solid var(--paper-line); border-left: 4px solid var(--amber);
            border-radius: 16px; padding: 2.5rem; margin-top: 1rem;
        }
        .org-band-title { font-family: 'Oswald', sans-serif; font-size: 1.3rem; font-weight: 600; color: var(--ink); text-transform: uppercase; margin-bottom: 0.75rem; }
        .org-band-desc { font-size: 0.94rem; line-height: 1.75; color: var(--ink-muted); max-width: 640px; }

        @media (min-width: 768px) {
            .about-split { grid-template-columns: 1.1fr 0.9fr; }
        }
        @media (max-width: 768px) {
            .value-grid { grid-template-columns: 1fr; }
            .org-band { padding: 1.75rem; }
        }
    </style>
@endsection

@section('content')

    <header class="page-header">
        <div class="container">
            <div class="page-eyebrow"><span class="page-eyebrow-dot"></span>Tentang Kami</div>
            <h1 class="page-title">Program Digital untuk Ojol yang Istiqomah</h1>
            <p class="page-desc">Ojol Mengaji dibangun supaya driver yang waktunya habis di jalan tetap punya ruang rutin buat menjaga hafalan Qur'an — tanpa harus datang ke majelis fisik tiap hari.</p>
        </div>
    </header>

    <section class="section">
        <div class="container about-split">
            <div>
                <span class="section-label">Kenapa Ojol Mengaji</span>
                <h2 class="section-title">Setoran yang Ngikutin Jadwal Narik, Bukan Sebaliknya</h2>
                <p class="section-desc">
                    Waktu luang driver ojek online seringkali datang di jam yang nggak menentu — pas ngetem, nunggu penumpang, atau jeda antar order. Ojol Mengaji dirancang supaya setoran hafalan bisa dikirim kapan pun ada jeda itu, lalu ditinjau guru pembimbing dari mana saja, tanpa harus ketemu langsung tiap hari.
                </p>
                <div class="about-stats">
                    <div>
                        <div class="about-stat-num">30+</div>
                        <div class="about-stat-label">Juz Terverifikasi</div>
                    </div>
                    <div>
                        <div class="about-stat-num">100%</div>
                        <div class="about-stat-label">Sesuai Syariah</div>
                    </div>
                </div>
            </div>

            <div class="value-grid" style="grid-template-columns: 1fr;">
                <div class="value-card">
                    <div class="value-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20"></path></svg>
                    </div>
                    <div class="value-title">Konsisten</div>
                    <div class="value-desc">Setoran rutin lebih penting dari jumlah — sistem bantu pantau progres tiap hari lewat dashboard, bukan cuma sekali ingat sekali kirim.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="container">
            <span class="section-label">Yang Kami Pegang</span>
            <h2 class="section-title">Tiga Prinsip di Balik Ojol Mengaji</h2>

            <div class="value-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <div class="value-title">Terbimbing</div>
                    <div class="value-desc">Setiap kelompok punya guru/musyrif langsung yang meninjau, kasih catatan, dan approve tiap setoran — bukan sekadar rekam lalu dibiarkan.</div>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div class="value-title">Fleksibel</div>
                    <div class="value-desc">Nggak ada jam wajib. Setoran suara, video, atau kuis bisa dikirim kapan pun ada jeda, dari HP mana saja.</div>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    </div>
                    <div class="value-title">Terverifikasi</div>
                    <div class="value-desc">Progres yang tercatat di dashboard adalah hasil tinjauan guru sungguhan, bukan sekadar checklist otomatis.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="container">
            <div class="org-band">
                <div class="org-band-title">LAZ Solidaritas Insan Peduli</div>
                <p class="org-band-desc">
                    Ojol Mengaji adalah salah satu program digital yang dijalankan oleh LAZ Solidaritas Insan Peduli (LAZ SIP), berbasis di Bogor, Jawa Barat. Program ini terbuka untuk driver ojek online dan guru/musyrif yang aktif terdaftar di LAZ SIP.
                </p>
            </div>
        </div>
    </section>

@endsection
