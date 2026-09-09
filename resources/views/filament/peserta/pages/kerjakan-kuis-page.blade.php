<x-filament-panels::page>

<div class="max-w-2xl mx-auto" style="display:flex;flex-direction:column;gap:20px;">

    <!-- Hero Card Kuis -->
    <div style="position:relative;background:#ffffff;border-radius:18px;padding:24px 26px;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <span style="display:inline-flex;align-items:center;gap:6px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;padding:5px 14px;border-radius:999px;font-size:12px;font-weight:600;">
            📝 Kuis · {{ $task->questions->count() }} Soal
        </span>
        <p style="font-size:20px;font-weight:700;color:#0f172a;margin:14px 0 4px;">{{ $task->title }}</p>
        <p style="font-size:13px;color:#64748b;font-weight:500;">Diberikan oleh <span style="color:#0f172a;font-weight:600;">{{ $task->teacher?->name }}</span></p>
        <p style="font-size:13.5px;color:#475569;line-height:1.6;margin-top:14px;">{{ $task->description }}</p>
    </div>

    @if($task->questions->isEmpty())
        <div style="text-align:center;padding:60px 20px;color:#64748b;background:#ffffff;border:1px solid #e2e8f0;border-radius:18px;">
            Guru belum menambahkan soal untuk kuis ini.
        </div>
    @else
        <form wire:submit="submitQuiz" style="display:flex;flex-direction:column;gap:16px;">
            @foreach($task->questions as $index => $question)
                <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:16px;padding:20px 22px;box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                    <p style="font-size:14.5px;font-weight:600;color:#0f172a;margin-bottom:14px;line-height:1.5;">
                        {{ $index + 1 }}. {{ $question->question }}
                    </p>

                    <div style="display:flex;flex-direction:column;gap:8px;">
                        @foreach($question->getOptionsList() as $key => $label)
                            <label
                                style="display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:10px;border:1.5px solid {{ ($answers[$question->id] ?? null) === $key ? '#16a34a' : '#e2e8f0' }};background:{{ ($answers[$question->id] ?? null) === $key ? '#f0fdf4' : '#f8fafc' }};cursor:pointer;transition:all .12s;"
                            >
                                <input
                                    type="radio"
                                    name="answers-{{ $question->id }}"
                                    value="{{ $key }}"
                                    wire:model="answers.{{ $question->id }}"
                                    style="accent-color:#16a34a;width:16px;height:16px;"
                                >
                                <span style="font-size:13.5px;color:#1e293b;">
                                    <strong style="color:#64748b;">{{ strtoupper($key) }}.</strong>
                                    {{ $label }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div style="display:flex;justify-content:flex-end;gap:10px;padding-top:6px;">
                <a href="{{ route('filament.peserta.pages.tugas') }}"
                    style="height:40px;padding:0 18px;border-radius:10px;display:inline-flex;align-items:center;font-size:13.5px;font-weight:600;text-decoration:none;border:1px solid #cbd5e1;color:#334155;background:#ffffff;">
                    Batal
                </a>
                <button type="submit"
                        style="height:40px;padding:0 22px;border-radius:10px;border:none;font-size:13.5px;font-weight:700;color:#ffffff;background:#16a34a;cursor:pointer;box-shadow:0 2px 4px rgba(22,163,74,0.2);">
                    Kumpulkan Kuis
                </button>
            </div>
        </form>
    @endif

</div>

</x-filament-panels::page>