<?php

namespace App\Livewire;

use App\Models\Submission;
use App\Models\Task;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PesertaKerjakanTugas extends Component
{
    use WithFileUploads;

    public Task $task;
    public ?Submission $submission = null;

    public $uploadedFile    = null;
    public $screenshotFile  = null; 

    public ?string $recordedFileData = null;
    public ?string $recordedFileName = null;

    public string $mode = 'record';

    public bool $isRecording  = false;
    public bool $hasRecording = false;

    public function mount(int $taskId): void
    {
        $this->task = Task::findOrFail($taskId);

        $this->submission = Submission::where('task_id', $taskId)
            ->where('student_id', Auth::id())
            ->latest()
            ->first();

        if ($this->submission && in_array($this->submission->status, ['pending', 'approved'])) {
            $this->redirect(route('filament.peserta.pages.tugas'));
            return;
        }

        if ($this->task->type === 'quiz') {
            $this->mode = 'upload';
        }
    }

    public function setMode(string $mode): void
    {
        $this->mode             = $mode;
        $this->uploadedFile     = null;
        $this->screenshotFile   = null;
        $this->recordedFileData = null;
        $this->hasRecording     = false;
    }

    public function saveRecordedData(string $base64Data, string $fileName): void
    {
        $this->recordedFileData = $base64Data;
        $this->recordedFileName = $fileName;
        $this->hasRecording     = true;
    }

    public function submit(): void
    {
        $studentId     = Auth::id();
        $directory     = "submissions/{$this->task->id}/{$studentId}";
        $filePath      = null;
        $screenshotPath = null;

        if ($this->task->type === 'quiz') {
            $this->validate([
                'screenshotFile' => [
                    'required',
                    'file',
                    'max:10240', 
                    'mimes:jpg,jpeg,png,webp',
                ],
            ], [
                'screenshotFile.required' => 'Upload screenshot bukti pengerjaan kuis.',
                'screenshotFile.mimes'    => 'Format harus JPG, PNG, atau WEBP.',
                'screenshotFile.max'      => 'Ukuran maksimal 10MB.',
            ]);

            if ($this->submission && $this->submission->status === 'rejected') {
                if ($this->submission->screenshot_path) {
                    Storage::disk('public')->delete($this->submission->screenshot_path);
                }
                if ($this->submission->file_path) {
                    Storage::disk('public')->delete($this->submission->file_path);
                }
            }

            $screenshotPath = $this->screenshotFile->storeAs(
                $directory,
                'screenshot_' . time() . '.' . $this->screenshotFile->getClientOriginalExtension(),
                'public'
            );
            $filePath = $screenshotPath; 

            if ($this->submission && $this->submission->status === 'rejected') {
                $this->submission->update([
                    'file_path'       => $filePath,
                    'screenshot_path' => $screenshotPath,
                    'status'          => 'pending',
                    'attempts_count'  => $this->submission->attempts_count + 1,
                ]);
            } else {
                Submission::create([
                    'task_id'         => $this->task->id,
                    'student_id'      => $studentId,
                    'file_path'       => $filePath,
                    'screenshot_path' => $screenshotPath,
                    'status'          => 'pending',
                    'attempts_count'  => 1,
                ]);
            }

            Notification::make()
                ->title('Bukti kuis berhasil dikirim!')
                ->body('Tunggu verifikasi dari guru.')
                ->success()
                ->send();

            $this->redirect(route('filament.peserta.pages.tugas'));
            return;
        }

        if ($this->mode === 'record') {
            if (! $this->recordedFileData) {
                Notification::make()
                    ->title('Belum ada rekaman!')
                    ->body('Silakan rekam audio/video terlebih dahulu.')
                    ->warning()
                    ->send();
                return;
            }

            $base64   = preg_replace('/^data:\w+\/[\w\-\+]+;base64,/', '', $this->recordedFileData);
            $binary   = base64_decode($base64);
            $fileName = 'rekaman_' . time() . '.webm';
            $fullPath = $directory . '/' . $fileName;

            Storage::disk('public')->put($fullPath, $binary);
            $filePath = $fullPath;

        } elseif ($this->mode === 'upload') {
            $this->validate([
                'uploadedFile' => [
                    'required',
                    'file',
                    'max:51200',
                    $this->task->type === 'voice_note'
                        ? 'mimes:mp3,wav,webm,ogg'
                        : 'mimes:mp4,webm,mov',
                ],
            ], [
                'uploadedFile.required' => 'Pilih file terlebih dahulu.',
                'uploadedFile.mimes'    => 'Format file tidak sesuai.',
                'uploadedFile.max'      => 'Ukuran file maksimal 50MB.',
            ]);

            $filePath = $this->uploadedFile->storeAs(
                $directory,
                'upload_' . time() . '.' . $this->uploadedFile->getClientOriginalExtension(),
                'public'
            );
        }

        if (! $filePath) {
            Notification::make()
                ->title('Gagal menyimpan file!')
                ->danger()
                ->send();
            return;
        }

        if ($this->submission && $this->submission->status === 'rejected') {
            if ($this->submission->file_path) {
                Storage::disk('public')->delete($this->submission->file_path);
            }
            $this->submission->update([
                'file_path'      => $filePath,
                'status'         => 'pending',
                'attempts_count' => $this->submission->attempts_count + 1,
            ]);
        } else {
            Submission::create([
                'task_id'        => $this->task->id,
                'student_id'     => $studentId,
                'file_path'      => $filePath,
                'status'         => 'pending',
                'attempts_count' => 1,
            ]);
        }

        Notification::make()
            ->title('Tugas berhasil dikumpulkan!')
            ->body('Tunggu koreksi dari guru.')
            ->success()
            ->send();

        $this->redirect(route('filament.peserta.pages.tugas'));
    }

    public function render()
    {
        return view('livewire.peserta-kerjakan-tugas');
    }
}