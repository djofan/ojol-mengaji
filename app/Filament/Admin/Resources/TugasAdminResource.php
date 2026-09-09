<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TugasAdminResource\Pages;
use App\Models\Task;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;

class TugasAdminResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Monitor Tugas';

    protected static ?string $modelLabel = 'Tugas';

    protected static ?string $pluralModelLabel = 'Semua Tugas';

    protected static ?string $slug = 'monitor-tugas';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            // Perbaikan 2: Gunakan method ->components() pada instansiasi schema terluar
            ->components([
                Section::make('Informasi Tugas')
                    ->description('Detail dari tugas yang diberikan.')
                    ->schema([ // Di dalam layout komponen, method ->schema() tetap digunakan
                        TextEntry::make('title')
                            ->label('Judul Tugas')
                            ->weight('bold'),
                            
                        TextEntry::make('description') 
                            ->label('Deskripsi Tugas')
                            ->html() 
                            ->columnSpanFull(),

                        Grid::make(2)->schema([
                            TextEntry::make('deadline') 
                                ->label('Batas Waktu')
                                ->dateTime('d M Y, H:i')
                                ->icon('heroicon-m-calendar'),
                                
                            TextEntry::make('status') 
                                ->label('Status')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'aktif' => 'success',
                                    'ditutup' => 'danger',
                                    'menunggu' => 'warning',
                                    default => 'gray',
                                }),
                        ]),
                    ]),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('teacher.name')
                    ->label('Guru Pembuat')
                    ->searchable()
                    ->sortable()
                    ->default('-')
                    ->toggleable(),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'voice_note' => '🎵 Voice Note',
                        'video'      => '🎬 Video',
                        'quiz'       => '📝 Kuis',
                        default      => $state,
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'voice_note' => 'info',
                        'video'      => 'warning',
                        'quiz'       => 'success',
                        default      => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('google_form_url')
                    ->label('Link Kuis')
                    ->formatStateUsing(fn ($state) => $state ? 'Lihat Form' : '-')
                    ->url(fn (Task $record) => $record->google_form_url ?? null)
                    ->openUrlInNewTab()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('submissions_count')
                    ->label('Total Kumpul')
                    ->counts('submissions')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('submissions_pending_count')
                    ->label(' Pending')
                    ->counts([
                        'submissions as submissions_pending_count' => fn (Builder $q) => $q->where('status', 'pending'),
                    ])
                    ->sortable()
                    ->color(fn ($state) => $state > 0 ? 'warning' : 'gray')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('teacher.profile.nomor_hp')
                    ->label('WA Guru')
                    ->default('-')
                    ->formatStateUsing(fn ($state) => $state !== '-' ? $state : '-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe Tugas')
                    ->options([
                        'voice_note' => '🎵 Voice Note',
                        'video'      => '🎬 Video',
                        'quiz'       => '📝 Kuis',
                    ]),

                SelectFilter::make('has_pending')
                    ->label('Status Pending')
                    ->options([
                        'yes' => '⏳ Ada yang pending',
                        'no'  => '✅ Tidak ada pending',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['value'])) return $query;
                        return $data['value'] === 'yes'
                            ? $query->whereHas('submissions', fn ($q) => $q->where('status', 'pending'))
                            : $query->whereDoesntHave('submissions', fn ($q) => $q->where('status', 'pending'));
                    }),
            ])
            ->actions([
                Action::make('whatsapp')
                    ->label('Ingatkan via WA')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->url(function (Task $record) {
                        $phone  = $record->teacher?->profile?->nomor_hp;
                        $pending = $record->submissions()->where('status', 'pending')->count();

                        if (! $phone || $pending === 0) return null;

                        $phone = preg_replace('/^0/', '62', preg_replace('/\D/', '', $phone));

                        $pesan = urlencode(
                            "Assalamu'alaikum Ustadz/Ustadzah {$record->teacher?->name},\n\n" .
                            "Ada *{$pending} tugas* yang menunggu koreksi untuk tugas:\n" .
                            "*\"{$record->title}\"*\n\n" .
                            "Mohon segera diperiksa ya. Jazakallahu khairan 🙏"
                        );

                        return "https://wa.me/{$phone}?text={$pesan}";
                    })
                    ->openUrlInNewTab()
                    ->visible(function (Task $record) {
                        $phone   = $record->teacher?->profile?->nomor_hp;
                        $pending = $record->submissions()->where('status', 'pending')->count();
                        return $phone && $pending > 0;
                    }),

                ViewAction::make(),
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
            'index' => Pages\ListTugasAdmins::route('/'),
            'view'  => Pages\ViewTugasAdmin::route('/{record}'),
        ];
    }
}