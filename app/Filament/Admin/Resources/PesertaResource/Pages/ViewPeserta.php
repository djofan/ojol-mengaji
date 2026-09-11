<?php

namespace App\Filament\Admin\Resources\PesertaResource\Pages;

use App\Filament\Admin\Resources\PesertaResource;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class ViewPeserta extends ViewRecord
{
    protected static string $resource = PesertaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Profil Utama')
                    ->schema([
                        Grid::make(2) 
                        ->schema([ 

                            Section::make('Detail Akun')
                                ->schema([
                                    TextEntry::make('name')
                                        ->label('Nama Lengkap')
                                        ->icon('heroicon-m-user')
                                        ->weight('bold'), 

                                    TextEntry::make('email')
                                        ->label('Email')
                                        ->icon('heroicon-m-envelope')
                                        ->copyable()
                                        ->copyMessage('Email berhasil disalin'),

                                    Grid::make(2)
                                    ->schema([
                                        TextEntry::make('status')
                                            ->label('Status')
                                            ->badge()
                                            ->formatStateUsing(fn($state) => $state ? 'Aktif' : 'Nonaktif')
                                            ->color(fn($state) => $state ? 'success' : 'danger'),

                                        TextEntry::make('created_at')
                                            ->label('Tanggal Daftar')
                                            ->dateTime('d M Y, H:i')
                                            ->icon('heroicon-m-calendar'),
                                    ])
                                ])
                                ->columnSpan(1), 
                        ]),
                    ]),

                Section::make('Informasi Kontak & Pekerjaan')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 3,
                        ])
                        ->schema([
                            TextEntry::make('profile.nomor_hp')
                                ->label('Nomor HP')
                                ->icon('heroicon-m-phone')
                                ->default('-')
                                ->copyable()
                                ->copyMessage('Nomor HP disalin'),

                            TextEntry::make('profile.tempat_mengajar')
                                ->label('Tempat Mengajar')
                                ->icon('heroicon-m-building-office')
                                ->default('-'),

                            TextEntry::make('profile.alamat')
                                ->label('Alamat Lengkap')
                                ->icon('heroicon-m-map-pin')
                                ->default('-')
                                ->columnSpan([
                                    'md' => 3, 
                                ]),
                        ]),
                    ]),

                Section::make('Statistik Aktivitas')
                    ->schema([
                        TextEntry::make('submissions_count')
                            ->label('Tugas Dikumpulkan')
                            ->icon('heroicon-m-document-check')
                            ->badge()
                            ->color('info')
                            ->state(fn($record) => $record->submissions()->count())
                            ->helperText('Total tugas yang telah dikumpulkan'),
                    ])
                    ->collapsible(),
            ]);
    }
}