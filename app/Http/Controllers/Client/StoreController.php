<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $results = $q === '' ? null : Product::with('category')
            ->where(fn ($query) => $query
                ->where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
                ->orWhere('style', 'like', "%{$q}%"))
            ->orderByDesc('is_featured')
            ->get();

        $categories = Category::whereNull('parent_id')
            ->orderBy('sort_order')
            ->with('children')
            ->get();

        return view('client.store.index', [
            'q' => $q,
            'results' => $results,
            'categories' => $categories,
            'featured' => Product::with('category')->where('is_featured', true)->first(),
            'productCount' => Product::count(),
        ]);
    }

    public function category(Category $category): View
    {
        $category->load('children', 'parent');

        return view('client.store.category', [
            'category' => $category,
            'children' => $category->children,
            'products' => $category->products()->orderByDesc('is_featured')->get(),
        ]);
    }

    public function show(\Illuminate\Http\Request $request, Product $product): View
    {
        $product->load('category', 'reviews.user');

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('client.store.show', [
            'product' => $product,
            'related' => $related,
            'isFavorite' => $request->user()->favorites()->where('product_id', $product->id)->exists(),
            'userReview' => $product->reviews->firstWhere('user_id', $request->user()->id),
        ]);
    }
}
