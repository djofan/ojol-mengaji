@extends('site.layout')

@section('title', 'FAQ')

@php($active = 'faq')

@section('extra-style')
    <style>
        .faq-list { max-width: 760px; display: flex; flex-direction: column; gap: 0.75rem; }
        .faq-item {
            background: var(--paper); border: 1px solid var(--paper-line); border-radius: 14px;
            overflow: hidden;
        }
        .faq-item summary {
            list-style: none; cursor: pointer;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            padding: 1.15rem 1.4rem; font-size: 0.98rem; font-weight: 700; color: var(--ink);
        }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-icon {
            flex-shrink: 0; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;
            color: var(--teal); transition: transform 0.2s ease;
        }
        .faq-item[open] .faq-icon { transform: rotate(45deg); }
        .faq-answer { padding: 0 1.4rem 1.3rem; font-size: 0.9rem; line-height: 1.7; color: var(--ink-muted); }
    </style>
@endsection

@section('content')

    <header class="page-header">
        <div class="container">
            <div class="page-eyebrow"><span class="page-eyebrow-dot"></span>FAQ</div>
            <h1 class="page-title">Pertanyaan yang Sering Ditanyakan</h1>
            <p class="page-desc">Belum ketemu jawabannya di sini? Langsung tanya lewat WhatsApp admin di bagian kontak.</p>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <div class="faq-list">
                <details class="faq-item" open>
                    <summary>
                        Bagaimana cara masuk ke platform Ojol Mengaji?
                        <span class="faq-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                    </summary>
                    <div class="faq-answer">Login menggunakan <strong>Kode Akun</strong>, bukan email — kode ini didaftarkan oleh admin. Masuk lewat halaman <a href="{{ url('/login') }}" style="color: var(--teal); font-weight: 700;">/login</a>.</div>
                </details>

                <details class="faq-item">
                    <summary>
                        Saya belum punya kode akun, bagaimana caranya?
                        <span class="faq-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                    </summary>
                    <div class="faq-answer">Hubungi admin lewat WhatsApp untuk didaftarkan. Lihat langkah lengkapnya di halaman <a href="{{ url('/cara-bergabung') }}" style="color: var(--teal); font-weight: 700;">Cara Bergabung</a>.</div>
                </details>

                <details class="faq-item">
                    <summary>
                        Apa saja yang bisa dikirim sebagai setoran?
                        <span class="faq-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                    </summary>
                    <div class="faq-answer">Rekaman suara atau video hafalan yang direkam atau diunggah langsung dari HP, serta kuis pilihan ganda yang bisa dikerjakan langsung di web.</div>
                </details>

                <details class="faq-item">
                    <summary>
                        Berapa lama setoran ditinjau guru?
                        <span class="faq-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                    </summary>
                    <div class="faq-answer">Estimasi kurang dari 24 jam sejak setoran dikirim, tergantung antrean guru pembimbing di kelompokmu.</div>
                </details>

                <details class="faq-item">
                    <summary>
                        Apakah program ini sesuai syariah?
                        <span class="faq-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                    </summary>
                    <div class="faq-answer">Ya, seluruh proses setoran dan penilaian di program Ojol Mengaji berjalan 100% sesuai syariah.</div>
                </details>

                <details class="faq-item">
                    <summary>
                        Siapa saja yang bisa ikut program ini?
                        <span class="faq-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                    </summary>
                    <div class="faq-answer">Driver ojek online dan guru/musyrif yang aktif terdaftar di LAZ Solidaritas Insan Peduli (LAZ SIP) untuk program Ojol Mengaji.</div>
                </details>
            </div>
        </div>
    </section>

@endsection
