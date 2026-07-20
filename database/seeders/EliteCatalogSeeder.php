<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Imports the real supplier catalog (Elite Furniture) into the store.
 * Prices are quoted on request, so price is stored as 0 and rendered
 * as "السعر عند الطلب" by Product::priceLabel().
 */
class EliteCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $bedrooms = Category::where('slug', 'bedrooms')->first();

        // Categories that the catalog needs but the store didn't have yet.
        $newCats = [
            ['slug' => 'bedroom-sets', 'name' => 'أطقم غرف النوم', 'parent_id' => $bedrooms?->id, 'sort_order' => 0, 'image_path' => 'products/bed.svg'],
            ['slug' => 'tv-units', 'name' => 'طاولات تلفزيون', 'parent_id' => null, 'sort_order' => 35, 'image_path' => 'products/coffee-table.svg', 'description' => 'وحدات وطاولات تلفزيون بتصاميم عصرية.'],
            ['slug' => 'wood-decor', 'name' => 'ديكورات خشبية', 'parent_id' => null, 'sort_order' => 45, 'image_path' => 'swatches/wood-walnut.svg', 'description' => 'ديكورات وتشطيبات خشبية مصنوعة حسب الطلب.'],
            ['slug' => 'projects-hotels', 'name' => 'تأثيث المشاريع والفنادق', 'parent_id' => null, 'sort_order' => 85, 'image_path' => 'rooms/living-classic.svg', 'description' => 'حلول تأثيث متكاملة للمشاريع التجارية والفنادق.'],
            ['slug' => 'interior-design', 'name' => 'التصميم الداخلي', 'parent_id' => null, 'sort_order' => 90, 'image_path' => 'rooms/living-warm.svg', 'description' => 'خدمات تصميم وتنفيذ داخلي بإشراف مصمّمين.'],
        ];

        foreach ($newCats as $c) {
            Category::updateOrCreate(['slug' => $c['slug']], $c);
        }

        $ids = Category::pluck('id', 'slug');
        $base = 'https://eliteonline.me/wp-content/uploads/2025/11/';

        // [category slug, product name, image file, description]
        $items = [
            ['bedroom-sets', 'طقم غرفة نوم — تصميم 1', 'i.webp', 'طقم غرفة نوم متكامل بخامات فاخرة وتشطيب دقيق، يُنفّذ حسب مقاسات غرفتك.'],
            ['bedroom-sets', 'طقم غرفة نوم — تصميم 2', 'i-2.webp', 'تصميم عصري يجمع الأناقة والراحة، مع خيارات ألوان وخامات متعددة.'],
            ['bedroom-sets', 'طقم غرفة نوم — تصميم 3', 'i-1.webp', 'طقم بلمسة كلاسيكية دافئة وتفاصيل مصنوعة يدويًا.'],

            ['wardrobes', 'خزانة ملابس — تصميم 1', 'i-5.webp', 'خزانة بأبواب أنيقة وتقسيمات داخلية عملية، تُصنع بالمقاس.'],
            ['wardrobes', 'خزانة ملابس — تصميم 2', 'i-4.webp', 'خزانة واسعة بتشطيب فاخر ومساحة تخزين مدروسة.'],
            ['wardrobes', 'خزانة ملابس — تصميم 3', 'i-3.webp', 'تصميم عملي يوفّر المساحة مع إمكانية إضافة مرايا وإضاءة.'],

            ['sofas', 'كنب — تصميم 1', 'i-6.webp', 'كنب بتنجيد فاخر وخامات عالية الجودة، متوفر بألوان متعددة.'],
            ['sofas', 'كنب — تصميم 2', 'i-7.webp', 'جلسة مريحة بتصميم عصري تناسب غرف المعيشة الواسعة.'],
            ['sofas', 'كنب — تصميم 3', 'i-8.webp', 'كنب بلمسة كلاسيكية وتفاصيل مميزة في الحياكة.'],

            ['tv-units', 'طاولة تلفزيون — تصميم 1', 'i-9.webp', 'وحدة تلفزيون بتصميم عصري ومساحات تخزين مدمجة.'],
            ['tv-units', 'طاولة تلفزيون — تصميم 2', 'i-10.webp', 'طاولة تلفزيون بخطوط بسيطة تناسب المساحات الحديثة.'],
            ['tv-units', 'طاولة تلفزيون — تصميم 3', 'i-11.webp', 'وحدة جدارية متكاملة مع إضاءة مخفية.'],

            ['wood-decor', 'ديكور خشبي — تصميم 1', 'i-14.webp', 'ديكور خشبي مصنوع حسب الطلب يضيف دفئًا للمساحة.'],
            ['wood-decor', 'ديكور خشبي — تصميم 2', 'i-13.webp', 'تشطيب خشبي فاخر للجدران والفواصل الداخلية.'],
            ['wood-decor', 'ديكور خشبي — تصميم 3', 'i-12.webp', 'وحدات خشبية مخصّصة تجمع الجمال والوظيفة.'],

            ['kitchens', 'مطبخ — تصميم 1', 'i-15.webp', 'مطبخ عصري بخامات مقاومة للرطوبة وتصميم عملي.'],
            ['kitchens', 'مطبخ — تصميم 2', 'i-16.webp', 'مطبخ بتشطيب فاخر ومساحات تخزين مدروسة.'],
            ['kitchens', 'مطبخ — تصميم 3', 'i-17.webp', 'تصميم يُنفّذ بالمقاس مع خيارات ألوان وإكسسوارات متعددة.'],

            ['projects-hotels', 'تأثيث مشاريع — نموذج 1', 'i-18.webp', 'حلول تأثيث متكاملة للفنادق والشقق الفندقية.'],
            ['projects-hotels', 'تأثيث مشاريع — نموذج 2', 'i-20.webp', 'تنفيذ أثاث المشاريع التجارية بجودة عالية وبكميات.'],
            ['projects-hotels', 'تأثيث مشاريع — نموذج 3', 'i-19.webp', 'تصميم وتوريد أثاث للمكاتب والمرافق العامة.'],

            ['interior-design', 'تصميم داخلي — مشروع 1', 'i-21.webp', 'خدمة تصميم وتنفيذ داخلي كاملة بإشراف مصمّم مختص.'],
            ['interior-design', 'تصميم داخلي — مشروع 2', 'i-22.webp', 'تحويل المساحة إلى تصميم متكامل يوازن الأناقة والراحة.'],
            ['interior-design', 'تصميم داخلي — مشروع 3', 'i-23.webp', 'استشارة وتصميم وتنفيذ لكل تفاصيل المساحة الداخلية.'],
        ];

        foreach ($items as [$slug, $name, $file, $desc]) {
            Product::updateOrCreate(
                ['name' => $name],
                [
                    'category_id' => $ids[$slug] ?? null,
                    'style' => null,
                    'price' => 0,                 // quoted on request
                    'image_path' => $base.$file,  // external catalog image
                    'description' => $desc,
                    'is_featured' => false,
                ]
            );
        }
    }
}
