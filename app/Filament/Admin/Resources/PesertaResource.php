<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PesertaResource\Pages;
use App\Models\User;
use App\Models\Group;
use App\Services\WilayahService;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class PesertaResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Peserta';

    protected static ?string $modelLabel = 'Peserta';

    protected static ?string $pluralModelLabel = 'Data Peserta';

    protected static ?string $slug = 'peserta';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'peserta');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('code')
                            ->label('Kode Login')
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn (string $operation) => $operation === 'edit')
                            ->helperText('Kode ini yang dipakai peserta buat login, bukan email'),

                        TextInput::make('email')
                            ->label('Email (opsional)')
                            ->email()
                            ->nullable()
                            ->unique(table: User::class, ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation) => $operation === 'create')
                            ->maxLength(255)
                            ->helperText('Kosongkan jika tidak ingin mengubah password'),

                        Toggle::make('status')
                            ->label('Status Aktif')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger'),
                    ])->columns(2),

                Section::make('Informasi Profil')
                    ->relationship('profile')
                    ->schema([
                        TextInput::make('nomor_hp')
                            ->label('Nomor HP')
                            ->maxLength(15),

                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'laki-laki' => '👨 Laki-laki',
                                'perempuan' => '👩 Perempuan',
                            ])
                            ->native(false),

                        Select::make('group_id')
                            ->label('Kelompok')
                            ->options(fn () => Group::pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('Pilih kelompok')
                            ->native(false),

                        TextInput::make('tempat_mengajar')
                            ->label('Tempat Mengajar')
                            ->maxLength(255),

                        FileUpload::make('foto')
                            ->label('Foto')
                            ->image()
                            ->directory('foto-peserta')
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),

                        Select::make('provinsi_id')
                            ->label('Provinsi')
                            ->options(function () {
                                $data = WilayahService::provinsi();
                                return collect($data)->pluck('name', 'id');
                            })
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('kota_id', null);
                                $set('kecamatan_id', null);
                                $set('kelurahan_id', null);
                                $set('kota_nama', null);
                                $set('kecamatan_nama', null);
                                $set('kelurahan_nama', null);

                                if (! $state) {
                                    $set('provinsi_nama', null);
                                    return;
                                }
                                $data = WilayahService::provinsi();
                                $found = collect($data)->firstWhere('id', $state);
                                $set('provinsi_nama', $found['name'] ?? null);
                            }),

                        Select::make('kota_id')
                            ->label('Kota / Kabupaten')
                            ->options(function ($get) {
                                $provinsiId = $get('provinsi_id');
                                if (! $provinsiId) return [];
                                $data = WilayahService::kota($provinsiId);
                                return collect($data)->pluck('name', 'id');
                            })
                            ->searchable()
                            ->live()
                            ->disabled(fn ($get) => ! $get('provinsi_id'))
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $set('kecamatan_id', null);
                                $set('kelurahan_id', null);
                                $set('kecamatan_nama', null);
                                $set('kelurahan_nama', null);

                                $provinsiId = $get('provinsi_id');
                                if (! $provinsiId || ! $state) {
                                    $set('kota_nama', null);
                                    return;
                                }
                                $data = WilayahService::kota($provinsiId);
                                $found = collect($data)->firstWhere('id', $state);
                                $set('kota_nama', $found['name'] ?? null);
                            }),

                        Select::make('kecamatan_id')
                            ->label('Kecamatan')
                            ->options(function ($get) {
                                $kotaId = $get('kota_id');
                                if (! $kotaId) return [];
                                $data = WilayahService::kecamatan($kotaId);
                                return collect($data)->pluck('name', 'id');
                            })
                            ->searchable()
                            ->live()
                            ->disabled(fn ($get) => ! $get('kota_id'))
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $set('kelurahan_id', null);
                                $set('kelurahan_nama', null);

                                $kotaId = $get('kota_id');
                                if (! $kotaId || ! $state) {
                                    $set('kecamatan_nama', null);
                                    return;
                                }
                                $data = WilayahService::kecamatan($kotaId);
                                $found = collect($data)->firstWhere('id', $state);
                                $set('kecamatan_nama', $found['name'] ?? null);
                            }),

                        Select::make('kelurahan_id')
                            ->label('Kelurahan / Desa')
                            ->options(function ($get) {
                                $kecamatanId = $get('kecamatan_id');
                                if (! $kecamatanId) return [];
                                $data = WilayahService::kelurahan($kecamatanId);
                                return collect($data)->pluck('name', 'id');
                            })
                            ->searchable()
                            ->live()
                            ->disabled(fn ($get) => ! $get('kecamatan_id'))
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $kecamatanId = $get('kecamatan_id');
                                if (! $kecamatanId || ! $state) {
                                    $set('kelurahan_nama', null);
                                    return;
                                }
                                $data = WilayahService::kelurahan($kecamatanId);
                                $found = collect($data)->firstWhere('id', $state);
                                $set('kelurahan_nama', $found['name'] ?? null);
                            }),

                        Textarea::make('alamat')
                            ->label('Alamat Detail (Nama Jalan, Perumahan, RT/RW)')
                            ->rows(3)
                            ->placeholder('Contoh: Puri Nirwana 3, Blok C No. 5, RT 02/RW 04')
                            ->columnSpanFull(),

                        Hidden::make('provinsi_nama'),
                        Hidden::make('kota_nama'),
                        Hidden::make('kecamatan_nama'),
                        Hidden::make('kelurahan_nama'),
                    ])->columns(2),

                Hidden::make('role')
                    ->default('peserta'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile.foto')
                    ->label('Foto')
                    ->circular()
                    ->url(fn ($record) => $record->profile?->foto
                        ? asset('storage/' . $record->profile->foto)
                        : null)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('code')
                    ->label('Kode Login')
                    ->badge()
                    ->color('success')
                    ->copyable()
                    ->copyMessage('Kode disalin!')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('profile.group.name')
                    ->label('Kelompok')
                    ->default('-')
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('profile.nomor_hp')
                    ->label('No. HP')
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('profile.gender')
                    ->label('Kelamin')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'laki-laki' => '👨 Laki-laki',
                        'perempuan' => '👩 Perempuan',
                        default     => '-',
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'laki-laki' => 'info',
                        'perempuan' => 'danger',
                        default     => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('profile.tempat_mengajar')
                    ->label('Tempat Mengajar')
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('submissions_count')
                    ->label('Tugas Dikumpul')
                    ->counts('submissions')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('status')
                    ->label('Status Aktif')
                    ->onColor('success')
                    ->offColor('danger')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Didaftarkan')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),

                TernaryFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->trueLabel('👨 Laki-laki')
                    ->falseLabel('👩 Perempuan')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('profile', fn ($q) => $q->where('gender', 'laki-laki')),
                        false: fn (Builder $query) => $query->whereHas('profile', fn ($q) => $q->where('gender', 'perempuan')),
                        blank: fn (Builder $query) => $query,
                    ),

                SelectFilter::make('group')
                    ->label('Filter Kelompok')
                    ->relationship('profile.group', 'name'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPesertas::route('/'),
            'create' => Pages\CreatePeserta::route('/create'),
            'view'   => Pages\ViewPeserta::route('/{record}'),
            'edit'   => Pages\EditPeserta::route('/{record}/edit'),
        ];
    }
}