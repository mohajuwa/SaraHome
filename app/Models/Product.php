<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'style', 'price', 'image_path', 'description', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }

    /** Bundled illustrations, admin uploads, or an external catalog URL. */
    public function imageUrl(): string
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return str_starts_with($this->image_path, 'uploads/')
            ? \Illuminate\Support\Facades\Storage::url($this->image_path)
            : asset('images/'.$this->image_path);
    }

    /** Catalog items with price 0 are quoted on request. */
    public function priceOnRequest(): bool
    {
        return (int) $this->price === 0;
    }

    public function priceLabel(): string
    {
        return $this->priceOnRequest()
            ? 'السعر عند الطلب'
            : number_format($this->price).' ريال';
    }
}
