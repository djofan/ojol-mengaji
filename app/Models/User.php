<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'code',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'status'            => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if ($user->code) {
                return;
            }

            if (! in_array($user->role, ['guru', 'peserta'])) {
                return;
            }

            $user->code = static::generateCode($user->role);
        });
    }

    public static function generateCode(string $role): string
    {
        $rolePrefix    = $role === 'guru' ? 'G' : 'P';
        $programPrefix = 'OM';

        $count = static::where('role', $role)->count();

        do {
            $count++;
            $code = $rolePrefix . $programPrefix . str_pad($count, 3, '0', STR_PAD_LEFT);
        } while (static::where('code', $code)->exists());

        return $code;
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class, 'teacher_id');
    }

    public function submissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Submission::class, 'student_id');
    }

    public function approvingTasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_approvers');
    }

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isGuru(): bool    { return $this->role === 'guru'; }
    public function isPeserta(): bool { return $this->role === 'peserta'; }

    public function canAccessPanel(Panel $panel): bool
    {
        if (! $this->status) return false;

        return match($panel->getId()) {
            'admin'   => $this->isAdmin(),
            'guru'    => $this->isGuru(),
            'peserta' => $this->isPeserta(),
            default   => false,
        };
    }
}
