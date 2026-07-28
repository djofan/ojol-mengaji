<?php

namespace App\Providers\Filament;

use App\Filament\Auth\CodeLogin;
use App\Filament\Peserta\Pages\Dashboard;
use App\Filament\Peserta\Pages\TugasPage;
use App\Filament\Peserta\Pages\KerjakanTugasPage;
use App\Filament\Peserta\Pages\DetailTugasPage;
use App\Filament\Peserta\Pages\KerjakanKuisPage;
use App\Filament\Peserta\Widgets\InfoKelompokWidget;
use App\Filament\Peserta\Widgets\PesertaShortcutTable;
use App\Filament\Peserta\Widgets\PesertaStatsOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PesertaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Sesi sekarang di-SHARE lintas panel biar login satu pintu bisa jalan.

        return $panel
            ->id('peserta')
            ->path('peserta')
            ->login(CodeLogin::class)
            ->colors(['primary' => Color::Amber])
            ->favicon(asset('favicon.ico'))
            ->brandName('Ojol Mengaji')
            ->discoverResources(in: app_path('Filament/Peserta/Resources'), for: 'App\\Filament\\Peserta\\Resources')
            ->discoverPages(in: app_path('Filament/Peserta/Pages'), for: 'App\\Filament\\Peserta\\Pages')
            ->discoverWidgets(in: app_path('Filament/Peserta/Widgets'), for: 'App\\Filament\\Peserta\\Widgets')
            ->pages([
                Dashboard::class,
                TugasPage::class,
                KerjakanTugasPage::class,
                DetailTugasPage::class,
                KerjakanKuisPage::class,
            ])
            ->widgets([
                InfoKelompokWidget::class,
                PesertaStatsOverview::class,
                PesertaShortcutTable::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([Authenticate::class]);
    }
}
