<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'room_type', 'style', 'budget',
        'status', 'progress', 'image_path', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'progress' => 'integer',
        ];
    }

    public const STATUSES = [
        'new' => 'جديد',
        'in_review' => 'قيد المراجعة',
        'completed' => 'مكتمل',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function design(): HasOne
    {
        return $this->hasOne(Design::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /** Tailwind color key used by the status pill component. */
    public function statusKey(): string
    {
        return match ($this->status) {
            'completed' => 'pine',
            'in_review' => 'clay',
            default => 'ochre',
        };
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
