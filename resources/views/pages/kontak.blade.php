@extends('site.layout')

@section('title', 'Kontak')

@php($active = 'kontak')

@section('extra-style')
<style>
    .contact-grid {
        max-width: 900px;
        display: grid;
        grid-template-columns: 1fr 1.3fr;
        gap: 2rem;
        align-items: start;
    }

    .contact-card {
        background: var(--paper);
        border: 1px solid var(--paper-line);
        border-radius: 14px;
        padding: 2rem;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(0, 150, 136, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--teal);
    }

    .contact-item h3 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 0.2rem;
    }

    .contact-item p {
        font-size: 0.9rem;
        color: var(--ink-muted);
        line-height: 1.5;
    }

    .whatsapp-cta {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        height: 100%;
        gap: 1.25rem;
    }

    .whatsapp-cta p {
        font-size: 0.94rem;
        color: var(--ink-muted);
        line-height: 1.65;
    }

    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<header class="page-header">
    <div class="container">
        <div class="page-eyebrow"><span class="page-eyebrow-dot"></span>Kontak</div>
        <h1 class="page-title">Hubungi Tim Ojol Mengaji</h1>
        <p class="page-desc">Punya pertanyaan seputar kendala akun, setoran hafalan, atau program LAZ SIP? Silakan
            hubungi kami.</p>
    </div>
</header>

<section class="section">
    <div class="container">
        <div class="contact-grid">

            <!-- Informasi Kontak -->
            <div class="contact-card">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--ink); margin-bottom: 1.5rem;">
                    Informasi & Sekretariat</h2>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3>Lokasi</h3>
                        <p>Bogor, Jawa Barat, Indonesia (LAZ Solidaritas Insan Peduli)</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3>Email Resmi</h3>
                        <p>csojolmengaji@lazsip.or.id</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3>Layanan WhatsApp</h3>
                        <p>Admin aktif melayani pada pukul 08.00 - 20.00 WIB.</p>
                    </div>
                </div>
            </div>

            <!-- CTA WhatsApp -->
            <div class="contact-card whatsapp-cta">
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--ink); margin-bottom: 0.6rem;">Chat
                        Langsung Lewat WhatsApp</h2>
                    <p>Cara tercepat untuk pendaftaran akun baru, reset kode akun, kendala setoran, atau pertanyaan
                        lainnya seputar program Ojol Mengaji.</p>
                </div>
                <a href="https://wa.me/628111186626" target="_blank" class="btn-primary">
                    Chat via WhatsApp
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        <path
                            d="M20.52 3.449C12.831-3.984.106 1.407.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652a11.85 11.85 0 0 0 5.723 1.472h.005c9.607 0 15.782-10.446 11.077-18.786a11.9 11.9 0 0 0-2.62-3.585zM12.063 21.785h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.005-8.4 9.132-13.65 16.442-9.454a10.947 10.947 0 0 1 3.643 3.669c4.198 7.313-1.02 16.679-9.201 16.677z" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
</section>

@endsection