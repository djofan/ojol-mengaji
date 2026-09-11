@extends('site.layout') @section('title', 'Kontak' ) @php($active='kontak' ) @section('extra-style')
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

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 0.5rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 0.8rem 1rem;
        font-size: 0.9rem;
        font-family: inherit;
        background: var(--paper);
        border: 1px solid var(--paper-line);
        border-radius: 10px;
        color: var(--ink);
        outline: none;
        transition: border-color 0.2s ease;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: var(--teal);
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 0.9rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 700;
        color: #fff;
        background: var(--teal);
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: opacity 0.2s ease;
    }

    .btn-submit:hover {
        opacity: 0.9;
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
                        <p>Bekasi, Jawa Barat, Indonesia (LAZ Solidaritas Insan Peduli)</p>
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
                        <p>support@ojolmengaji.com</p>
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

            <!-- Form Kirim Pesan -->
            <div class="contact-card">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--ink); margin-bottom: 1.5rem;">Kirim
                    Pesan</h2>

                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" required placeholder="Masukkan nama Anda">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kode Akun / No HP</label>
                        <input type="text" name="identifier" class="form-input" required placeholder="Cth: OJOL-XXXX">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Topik Kendala</label>
                        <select name="topic" class="form-select">
                            <option>Kendala Masuk / Kode Akun</option>
                            <option>Setoran Hafalan</option>
                            <option>Pendaftaran / Cara Bergabung</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pesan</label>
                        <textarea name="message" class="form-textarea" required
                            placeholder="Tuliskan kendala atau pertanyaan Anda..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Kirim Pesan</button>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection