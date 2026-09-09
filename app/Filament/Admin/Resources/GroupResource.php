<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GroupResource\Pages;
use App\Models\Group;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Kelompok';

    protected static ?string $modelLabel = 'Kelompok';

    protected static ?string $pluralModelLabel = 'Data Kelompok';

    protected static ?string $slug = 'kelompok';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kelompok')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kelompok')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Kelompok Ojol Mengaji 1')
                            ->helperText('Kode kelompok otomatis dibuat urut: OM001, OM002, dst'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->color('success')
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('name')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->default('-')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('profiles_count')
                    ->label('Jumlah Anggota')
                    ->counts('profiles')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                TextColumn::make('tasks_count')
                    ->label('Tugas Terkirim')
                    ->counts('tasks')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index'  => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'view'   => Pages\ViewGroup::route('/{record}'),
            'edit'   => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
