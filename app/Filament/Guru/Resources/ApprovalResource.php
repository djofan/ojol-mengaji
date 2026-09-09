<?php

namespace App\Filament\Guru\Resources;
use App\Filament\Guru\Resources\ApprovalResource\Pages;
use App\Models\Submission;
use App\Models\SubmissionLog;
use App\Models\Task;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ApprovalResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    protected static ?string $navigationLabel = 'Approval Tugas';

    protected static ?string $modelLabel = 'Submission';

    protected static ?string $pluralModelLabel = 'Approval Tugas';

    protected static ?string $slug = 'approval';

    public static function getEloquentQuery(): Builder
    {
        $guruId = Auth::id();

        return parent::getEloquentQuery()
            ->where('status', 'pending')
            // Kuis native auto-graded & auto-approved, jadi ga pernah masuk sini.
            ->whereHas('task', fn (Builder $q) => $q->where('type', '!=', 'quiz'))
            // Cuma pembuat tugas atau guru yang ditunjuk jadi approver yang bisa lihat/review.
            ->whereHas('task', function (Builder $q) use ($guruId) {
                $q->where('teacher_id', $guruId)
                    ->orWhereHas('approvers', fn (Builder $q2) => $q2->where('users.id', $guruId));
            })
            ->with(['task', 'task.teacher', 'task.approvers', 'student', 'logs.teacher']);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Peserta')
                    ->schema([
                        TextEntry::make('student.name')
                            ->label('Nama Peserta'),

                        TextEntry::make('student.email')
                            ->label('Email'),

                        TextEntry::make('task.title')
                            ->label('Judul Tugas'),

                        TextEntry::make('task.teacher.name')
                            ->label('Guru Pembuat'),

                        TextEntry::make('task.type')
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
                            }),

                        TextEntry::make('attempts_count')
                            ->label('Percobaan Ke'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'pending'  => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default    => 'gray',
                            }),
                    ])->columns(3),

                Section::make('Link Google Form')
                    ->schema([
                        TextEntry::make('task.google_form_url')
                            ->label('Link Form')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->color('info')
                            ->placeholder('Tidak ada link'),
                    ])
                    ->visible(fn (Submission $record) => $record->task?->type === 'quiz'),

                Section::make('File Rekaman')
                    ->schema([
                        ViewEntry::make('file_path')
                            ->label('Player')
                            ->view('filament.infolists.components.media-player'),
                    ])
                    ->visible(fn (Submission $record) => $record->task?->type !== 'quiz'),

                Section::make('Bukti Screenshot')
                    ->schema([
                        ViewEntry::make('screenshot_path')
                            ->label('Screenshot')
                            ->view('filament.infolists.components.screenshot-viewer'),
                    ])
                    ->visible(fn (Submission $record) => $record->task?->type === 'quiz'),

                Section::make('Riwayat Koreksi')
                    ->schema([
                        ViewEntry::make('logs')
                            ->label('Riwayat')
                            ->view('filament.infolists.components.submission-logs'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // --- KOLOM UTAMA (Selalu Tampil) ---
                TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('task.title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending'  => 'warning',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'approved' => '✅ Disetujui',
                        'rejected' => '❌ Ditolak',
                        'pending'  => '⏳ Menunggu',
                        default    => $state,
                    }),

                // --- KOLOM SEKUNDER (Bisa di-toggle / disembunyikan default) ---
                TextColumn::make('file_path')
                    ->label('File Tugas')
                    ->formatStateUsing(fn ($state) => $state ? '📄 Lihat File' : 'Tidak ada file')
                    ->url(fn ($record) => $record->file_path ? asset('storage/' . $record->file_path) : null)
                    ->openUrlInNewTab()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('attempts_count')
                    ->label('Percobaan ke-')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Waktu Kumpul')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'pending'  => '⏳ Menunggu',
                        'approved' => '✅ Disetujui',
                        'rejected' => '❌ Ditolak',
                    ]),
            ])
            ->actions([
                // Tombol Cepat untuk Approve langsung dari tabel (Opsional)
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'approved']))
                    ->visible(fn ($record) => $record->status === 'pending'),

                // Tombol Cepat untuk Reject langsung dari tabel (Opsional)
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'rejected']))
                    ->visible(fn ($record) => $record->status === 'pending'),

                ViewAction::make(),
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
            'index' => Pages\ListApprovals::route('/'),
            'view'  => Pages\ViewApproval::route('/{record}'),
        ];
    }
}