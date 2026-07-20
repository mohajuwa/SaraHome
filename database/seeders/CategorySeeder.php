<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Top-level categories, in display order.
        $top = [
            ['slug' => 'bedrooms', 'name' => 'غرف النوم', 'sort_order' => 10, 'image_path' => 'rooms/bedroom-scandi.svg', 'description' => 'أسرّة وتسريحات وخزائن وكمدينات وشفنيرات.'],
            ['slug' => 'curtains', 'name' => 'الستائر', 'sort_order' => 20, 'image_path' => 'products/curtain.svg', 'description' => 'ستائر بأقمشة وأطوال متنوّعة.'],
            ['slug' => 'sofas', 'name' => 'الكنب', 'sort_order' => 30, 'image_path' => 'products/sofa.svg', 'description' => 'كنب زوايا ومقاعد وكنب أسرّة.'],
            ['slug' => 'kitchens', 'name' => 'المطابخ', 'sort_order' => 40, 'image_path' => 'products/kitchen.svg', 'description' => 'مطابخ مودرن وكلاسيك وحلول للمساحات الصغيرة.'],
            ['slug' => 'handles', 'name' => 'المساكات', 'sort_order' => 50, 'image_path' => 'hardware/handle-gold.svg', 'description' => 'مساكات وأزرار للأبواب والأدراج بألوان متعددة.'],
            ['slug' => 'drawer-slides', 'name' => 'سحابات الأدراج', 'sort_order' => 60, 'image_path' => 'products/drawer-slide.svg', 'description' => 'سحابات هيدروليك وتلسكوبية ودفع-فتح.'],
            ['slug' => 'wood', 'name' => 'الخشب', 'sort_order' => 70, 'image_path' => 'swatches/wood-oak.svg', 'description' => 'خشب بجميع الألوان والدرجات.'],
            ['slug' => 'fabric', 'name' => 'القماش', 'sort_order' => 80, 'image_path' => 'swatches/fabric-terracotta.svg', 'description' => 'أقمشة تنجيد بجميع الألوان.'],
        ];

        foreach ($top as $c) {
            Category::updateOrCreate(['slug' => $c['slug']], $c + ['parent_id' => null]);
        }

        $bedrooms = Category::where('slug', 'bedrooms')->first();

        // Sub-categories under غرف النوم.
        $subs = [
            ['slug' => 'beds', 'name' => 'الأسرّة', 'sort_order' => 1, 'image_path' => 'products/bed.svg'],
            ['slug' => 'vanities', 'name' => 'التسريحات', 'sort_order' => 2, 'image_path' => 'products/vanity.svg'],
            ['slug' => 'wardrobes', 'name' => 'الخزائن', 'sort_order' => 3, 'image_path' => 'products/wardrobe.svg'],
            ['slug' => 'nightstands', 'name' => 'الكمدينات', 'sort_order' => 4, 'image_path' => 'products/nightstand.svg'],
            ['slug' => 'chiffoniers', 'name' => 'الشفنيرات', 'sort_order' => 5, 'image_path' => 'products/chiffonier.svg'],
        ];

        foreach ($subs as $s) {
            Category::updateOrCreate(['slug' => $s['slug']], $s + ['parent_id' => $bedrooms->id]);
        }
    }
}
