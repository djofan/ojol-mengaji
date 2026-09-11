<?php

namespace App\Filament\Peserta\Widgets;

use App\Models\Submission;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PesertaStatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int | array
    {
        return [
            'default' => 2,
            'md' => 4,
        ];
    }

    protected function getStats(): array
    {
        $student   = Auth::user();
        $studentId = $student->id;
        $groupId   = $student->profile?->group_id;

        $totalTugas = Task::when($groupId, function ($q) use ($groupId) {
            $q->whereHas('groups', fn ($q2) => $q2->where('groups.id', $groupId));
        }, function ($q) {
            $q->whereRaw('1 = 0');
        })->count();

        $dikerjakan = Submission::where('student_id', $studentId)->pluck('task_id');

        $belumDikerjakan = $totalTugas - $dikerjakan->unique()->count();
        if ($belumDikerjakan < 0) $belumDikerjakan = 0;

        $menunggu = Submission::where('student_id', $studentId)
            ->where('status', 'pending')->count();

        $harusUlang = Submission::where('student_id', $studentId)
            ->where('status', 'rejected')->count();

        $selesai = Submission::where('student_id', $studentId)
            ->where('status', 'approved')->count();

        return [
            Stat::make('Belum Dikerjakan', $belumDikerjakan),

            Stat::make('Menunggu Koreksi', $menunggu),

            Stat::make('Harus Diulang', $harusUlang),

            Stat::make('Selesai', $selesai),
        ];
    }
}