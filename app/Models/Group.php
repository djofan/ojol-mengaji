<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
    ];

    protected static function booted(): void
    {
        static::creating(function (Group $group) {
            if ($group->code) {
                return;
            }

            $prefix = 'OM';
            $count  = static::count();

            do {
                $count++;
                $code = $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);
            } while (static::where('code', $code)->exists());

            $group->code = $code;
        });
    }

    public function profiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_group');
    }
}
