<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::with('category')->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image_path'] = $this->storeImage($request) ?? 'products/sofa.svg';

        Product::create($data);

        return redirect()->route('admin.products')->with('status', 'تمت إضافة المنتج بنجاح.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request);

        if ($path = $this->storeImage($request)) {
            $data['image_path'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('status', 'تم تحديث المنتج.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('status', 'تم حذف المنتج.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'style' => ['nullable', 'string', 'max:40'],
            'price' => ['required', 'integer', 'min:0', 'max:1000000'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_featured' => ['nullable', 'boolean'],
        ]) + ['is_featured' => $request->boolean('is_featured')];
    }

    protected function storeImage(Request $request): ?string
    {
        $request->validate(['image' => ['nullable', 'image', 'max:4096']]);

        return $request->hasFile('image')
            ? $request->file('image')->store('uploads/products', 'public')
            : null;
    }

    /** Leaf categories only (a product belongs to a leaf, not a parent). */
    protected function categoryOptions()
    {
        return Category::orderBy('sort_order')
            ->with('parent')
            ->get()
            ->filter(fn ($c) => ! $c->isParent())
            ->values();
    }
}
