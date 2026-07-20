<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories', [
            'categories' => Category::whereNull('parent_id')->orderBy('sort_order')->with('children')->get(),
            'parents' => Category::whereNull('parent_id')->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $slug = Str::slug($data['name']);
        if ($slug === '' || Category::where('slug', $slug)->exists()) {
            $slug = ($slug ?: 'cat').'-'.Str::lower(Str::random(5));
        }

        Category::create([
            'name' => $data['name'],
            'slug' => $slug,
            'parent_id' => $data['parent_id'] ?? null,
            'sort_order' => $data['sort_order'] ?? 100,
            'image_path' => 'rooms/living-warm.svg',
        ]);

        return back()->with('status', 'تمت إضافة القسم.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $category->update([
            'name' => $data['name'],
            'sort_order' => $data['sort_order'] ?? $category->sort_order,
        ]);

        return back()->with('status', 'تم تحديث القسم.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->children()->exists() || $category->products()->exists()) {
            return back()->with('status', 'لا يمكن حذف قسم يحتوي على أقسام فرعية أو منتجات.');
        }

        $category->delete();

        return back()->with('status', 'تم حذف القسم.');
    }
}
