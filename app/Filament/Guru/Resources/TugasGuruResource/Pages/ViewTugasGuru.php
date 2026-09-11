<?php

namespace App\Filament\Guru\Resources\TugasGuruResource\Pages;

use App\Filament\Guru\Resources\TugasGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTugasGuru extends ViewRecord
{
    protected static string $resource = TugasGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}