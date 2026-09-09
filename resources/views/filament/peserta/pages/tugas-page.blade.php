<x-filament-panels::page>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/2.44.0/iconfont/tabler-icons.min.css">

@php
    $myGroup = auth()->user()->profile?->group?->name ?? 'Belum ditentukan';
@endphp

{{-- Header Banner Kelompok --}}
<div style="position:relative;background:linear-gradient(145deg,#f8fafc,#f1f5f9);border:1px solid #e2e8f0;border-radius:18px;padding:1px;overflow:hidden;margin-bottom:20px;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
    <div style="position:relative;background:#ffffff;border-radius:17px;padding:20px 22px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">

        <div style="display:flex;align-items:center;gap:14px;">
            <div>
                <p style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 2px;">Kelompok kamu</p>
                <p style="font-size:19px;font-weight:700;color:#0f172a;margin:0;">{{ $myGroup }}</p>
            </div>
        </div>

        @if($myGroup !== 'Belum ditentukan')
            <div style="display:flex;align-items:center;gap:10px;padding:8px 14px;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.25);border-radius:12px;">
                <span style="width:7px;height:7px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
                <span style="font-size:12.5px;color:#16a34a;font-weight:600;">Aktif</span>
            </div>
        @else
            <div style="display:flex;align-items:center;gap:10px;padding:8px 14px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);border-radius:12px;">
                <i class="ti ti-alert-triangle" style="font-size:14px;color:#dc2626;"></i>
                <span style="font-size:12.5px;color:#dc2626;font-weight:600;">Hubungi admin</span>
            </div>
        @endif

    </div>
</div>

{{-- Grid List Tugas --}}
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;">
@forelse($this->getTasks() as $task)
    @php $status = $task->submission_status; @endphp

    <div style="display:flex;flex-direction:column;border:1px solid #e2e8f0;border-radius:18px;overflow:hidden;background:#ffffff;min-height:280px;box-shadow:0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02);">

        <div style="padding:20px;display:flex;flex-direction:column;flex:1;">

            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:16px;">
                @if($task->type === 'voice_note')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#eff6ff;color:#2563eb;">🎵 Voice note</span>
                @elseif($task->type === 'video')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#fffbeb;color:#d97706;">🎬 Video</span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#f0fdf4;color:#16a34a;">📝 Kuis</span>
                @endif

                @if($status === 'approved' && $task->type === 'quiz')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#f0fdf4;color:#16a34a;">✓ Nilai: {{ $task->submission_score }}</span>
                @elseif($status === 'approved')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#f0fdf4;color:#16a34a;">✓ Selesai</span>
                @elseif($status === 'pending')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#eff6ff;color:#2563eb;">🕐 Menunggu</span>
                @elseif($status === 'rejected')
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#fef2f2;color:#dc2626;">✕ Ditolak</span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#f1f5f9;color:#475569;">Belum dikerjakan</span>
                @endif

                @if($task->is_late)
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#fff7ed;color:#ea580c;">⏰ Terlambat</span>
                @endif
            </div>

            <div style="font-size:19px;font-weight:700;line-height:1.35;margin-bottom:6px;color:#0f172a;">
                {{ $task->title }}
            </div>
            <div style="font-size:13px;font-weight:600;color:#16a34a;margin-bottom:12px;">
                oleh {{ $task->teacher?->name ?? '-' }}
            </div>
            <div style="font-size:13.5px;line-height:1.65;color:#475569;margin-bottom:auto;">
                {{ $task->description }}
            </div>

            @if($task->deadline)
                <div style="display:flex;align-items:center;gap:6px;margin-top:14px;font-size:12.5px;font-weight:600;color:{{ $task->is_locked ? '#dc2626' : '#64748b' }};">
                    {{ $task->is_locked ? '🔒' : '⏳' }}
                    {{ $task->is_locked ? 'Deadline lewat:' : 'Deadline:' }}
                    {{ \Illuminate\Support\Carbon::parse($task->deadline)->translatedFormat('d M Y, H:i') }}
                </div>
            @endif

            @if($task->type === 'quiz' && $task->google_form_url)
                <a href="{{ $task->google_form_url }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;font-size:13px;font-weight:600;color:#2563eb;text-decoration:none;">
                    🔗 Buka Google Form
                </a>
            @endif
        </div>

        <div style="padding:16px 20px;display:flex;flex-wrap:wrap;gap:10px;align-items:center;border-top:1px solid #f1f5f9;background:#f8fafc;">

            @if($status === 'belum')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:38px;padding:0 16px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #cbd5e1;color:#334155;background:#ffffff;">
                    Detail
                </a>
                @if($task->is_locked)
                    <span style="height:38px;padding:0 14px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:#fef2f2;color:#dc2626;">
                        🔒 Deadline lewat
                    </span>
                @elseif($task->type === 'quiz')
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kuis', ['task' => $task->id]) }}"
                       style="height:38px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:#16a34a;color:#fff;box-shadow:0 2px 4px rgba(22,163,74,0.2);">
                        📝 Mulai Kuis
                    </a>
                @else
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kerjakan', ['task' => $task->id]) }}"
                       style="height:38px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:#d97706;color:#fff;box-shadow:0 2px 4px rgba(217,119,6,0.2);">
                        Kerjakan Tugas →
                    </a>
                @endif

            @elseif($status === 'pending')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:38px;padding:0 16px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #cbd5e1;color:#334155;background:#ffffff;">
                    Detail
                </a>
                <span style="height:38px;padding:0 14px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;">
                    {{ $task->type === 'quiz' ? '🕐 Menunggu verifikasi' : '🕐 Menunggu koreksi' }}
                </span>

            @elseif($status === 'rejected')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:38px;padding:0 16px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #cbd5e1;color:#334155;background:#ffffff;">
                    Lihat catatan
                </a>
                @if($task->is_locked)
                    <span style="height:38px;padding:0 14px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:600;background:#fef2f2;color:#dc2626;">
                        🔒 Deadline lewat
                    </span>
                @else
                    <a href="{{ route('filament.peserta.pages.tugas.{task}.kerjakan', ['task' => $task->id]) }}"
                       style="height:38px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:#dc2626;color:#fff;box-shadow:0 2px 4px rgba(220,38,38,0.2);">
                        Kerjakan ulang →
                    </a>
                @endif

            @elseif($status === 'approved')
                <a href="{{ route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]) }}"
                   style="height:38px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:700;text-decoration:none;background:#16a34a;color:#fff;box-shadow:0 2px 4px rgba(22,163,74,0.2);">
                    ✓ Lihat detail
                </a>
            @endif
        </div>
    </div>

@empty
    <div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;padding:80px 20px;text-align:center;">
        <div style="font-size:60px;margin-bottom:14px;">📭</div>
        <div style="font-size:16px;font-weight:600;color:#0f172a;margin-bottom:6px;">
            Belum ada tugas
        </div>
        <div style="font-size:13px;color:#64748b;">
            Tugas akan muncul di sini setelah guru membuat tugas untuk kelompokmu
        </div>
    </div>
@endforelse
</div>

</x-filament-panels::page>