<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\TugasGuruResource\Pages;
use App\Models\Task;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TugasGuruResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Tugas';

    protected static ?string $modelLabel = 'Tugas';

    protected static ?string $pluralModelLabel = 'Semua Tugas';

    protected static ?string $slug = 'tugas';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['teacher', 'groups', 'questions', 'approvers']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Tugas')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Tugas')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Tipe Tugas')
                            ->options([
                                'voice_note' => '🎵 Voice Note (Audio)',
                                'video'      => '🎬 Video',
                                'quiz'       => '📝 Kuis (Google Form)',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        Textarea::make('description')
                            ->label('Deskripsi / Perintah')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Select::make('group_ids')
                            ->label('Kirim ke Kelompok')
                            ->options(fn () => \App\Models\Group::pluck('name', 'id'))
                            ->multiple()
                            ->required()
                            ->preload()
                            ->searchable()
                            ->afterStateHydrated(function ($component, $record) {
                                $component->state($record?->groups?->pluck('id')->toArray() ?? []);
                            })
                            ->placeholder('Pilih satu atau lebih kelompok')
                            ->columnSpanFull(),

                        DateTimePicker::make('deadline')
                            ->label('Deadline')
                            ->native(false)
                            ->seconds(false)
                            ->minDate(now())
                            ->helperText('Kosongkan kalau tugas ini bebas, tanpa batas waktu'),

                        Select::make('approver_ids')
                            ->label('Guru Lain yang Bisa Approve/Reject')
                            ->options(fn () => User::where('role', 'guru')
                                ->where('id', '!=', Auth::id())
                                ->pluck('name', 'id'))
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->afterStateHydrated(function ($component, $record) {
                                $component->state($record?->approvers?->pluck('id')->toArray() ?? []);
                            })
                            ->placeholder('Opsional, kosongkan kalau cuma kamu yang review')
                            ->helperText('Guru lain yang bisa dipilih jadi approver'),

                    ])->columns(2),

                Section::make('Soal Kuis')
                    ->description('Buat soal pilihan ganda. Nilai murid dihitung otomatis begitu kuis dikumpulkan.')
                    ->schema([
                        Repeater::make('questions')
                            ->relationship('questions')
                            ->label('Daftar Soal')
                            ->schema([
                                Textarea::make('question')
                                    ->label('Pertanyaan')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('option_a')
                                    ->label('Pilihan A')
                                    ->required(),

                                TextInput::make('option_b')
                                    ->label('Pilihan B')
                                    ->required(),

                                TextInput::make('option_c')
                                    ->label('Pilihan C (opsional)'),

                                TextInput::make('option_d')
                                    ->label('Pilihan D (opsional)'),

                                Radio::make('correct_option')
                                    ->label('Jawaban Benar')
                                    ->options([
                                        'a' => 'A',
                                        'b' => 'B',
                                        'c' => 'C',
                                        'd' => 'D',
                                    ])
                                    ->required()
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? 'Soal baru')
                            ->addActionLabel('+ Tambah Soal')
                            ->minItems(1)
                            ->reorderable()
                            ->orderColumn('order')
                            ->collapsible()
                            ->required(fn ($get) => $get('type') === 'quiz')
                            ->columnSpanFull(),
                    ])
                    ->hidden(fn ($get) => $get('type') !== 'quiz'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // --- KOLOM UTAMA (Selalu Tampil) ---
                TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable()
                    ->limit(30), // Batasi panjang teks agar rapi

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'voice_note' => '🎵 Voice Note',
                        'video'      => '🎬 Video',
                        'quiz'       => '📝 Kuis',
                        default      => $state,
                    }),

                TextColumn::make('deadline')
                    ->label('Batas Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('submissions_count')
                    ->label('Total Kumpul')
                    ->counts('submissions')
                    ->sortable(),

                // --- KOLOM SEKUNDER (Bisa disembunyikan / di-toggle) ---
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true), // Tersembunyi default

                TextColumn::make('google_form_url')
                    ->label('Link Kuis')
                    ->url(fn ($record) => $record->google_form_url)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
            'index'  => Pages\ListTugasGurus::route('/'),
            'create' => Pages\CreateTugasGuru::route('/create'),
            'view'   => Pages\ViewTugasGuru::route('/{record}'),
            'edit'   => Pages\EditTugasGuru::route('/{record}/edit'),
        ];
    }
}