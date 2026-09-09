<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int | array
    {
        return [
            'default' => 3,
            'md' => 3,
        ];
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Guru Aktif', User::where('role', 'guru')->where('status', true)->count()),

            Stat::make('Total Peserta Aktif', User::where('role', 'peserta')->where('status', true)->count()),

            Stat::make('Total Tugas Berjalan', Task::count()),
        ];
    }
}