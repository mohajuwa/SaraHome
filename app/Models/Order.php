<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total', 'note'];

    protected function casts(): array
    {
        return ['total' => 'integer'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLabel(): string
    {
        return [
            'new' => 'جديد',
            'preparing' => 'قيد التجهيز',
            'delivered' => 'تم التوصيل',
            'cancelled' => 'ملغي',
        ][$this->status] ?? $this->status;
    }
}
