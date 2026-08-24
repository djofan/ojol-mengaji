<?php

namespace App\Providers\Filament;

use App\Filament\Auth\CodeLogin;
use App\Filament\Guru\Pages\Dashboard;
use App\Filament\Guru\Pages\HasilKuisPage;
use App\Filament\Guru\Pages\HasilTugasPage;
use App\Filament\Guru\Widgets\GuruApprovalWidget;
use App\Filament\Guru\Widgets\GuruPesertaTable;
use App\Filament\Guru\Widgets\GuruStatsOverview;
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

class GuruPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Sesi sekarang di-SHARE lintas panel biar login satu pintu bisa jalan.

        return $panel
            ->id('guru')
            ->path('guru')
            ->login(CodeLogin::class)
            ->colors(['primary' => Color::Teal])
            ->darkMode(false)
            ->favicon(asset('favicon.ico'))
            ->brandName('Ojol Mengaji')
            ->discoverResources(in: app_path('Filament/Guru/Resources'), for: 'App\\Filament\\Guru\\Resources')
            ->discoverPages(in: app_path('Filament/Guru/Pages'), for: 'App\\Filament\\Guru\\Pages')
            ->discoverWidgets(in: app_path('Filament/Guru/Widgets'), for: 'App\\Filament\\Guru\\Widgets')
            ->pages([
                Dashboard::class,
                HasilKuisPage::class,
                HasilTugasPage::class,
            ])
            ->widgets([
                GuruStatsOverview::class,
                GuruApprovalWidget::class,
                GuruPesertaTable::class,
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
