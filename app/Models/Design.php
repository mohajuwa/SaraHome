<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'palette', 'furniture', 'lighting', 'summary', 'estimated_cost',
    ];

    protected function casts(): array
    {
        return [
            'palette' => 'array',
            'furniture' => 'array',
            'lighting' => 'array',
            'estimated_cost' => 'integer',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
