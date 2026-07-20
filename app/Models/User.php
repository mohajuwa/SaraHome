<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'avatar_path', 'preferred_style', 'budget_range',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim((string) $this->name));
        $first = mb_substr($parts[0] ?? '', 0, 1);
        $second = isset($parts[1]) ? mb_substr($parts[1], 0, 1) : '';

        return $first.$second;
    }
}
