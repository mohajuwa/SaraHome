<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'sort_order', 'image_path', 'description',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function isParent(): bool
    {
        return $this->children()->exists();
    }

    /** Total products in this category and all of its children. */
    public function totalProductsCount(): int
    {
        $count = $this->products()->count();
        foreach ($this->children as $child) {
            $count += $child->products()->count();
        }

        return $count;
    }
}
