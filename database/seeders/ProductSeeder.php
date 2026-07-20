<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catIds = Category::pluck('id', 'slug');

        // [category slug, name, style, price, image, description, featured]
        $products = [
            // ---- الأسرّة ----
            ['beds', 'سرير مزدوج منجّد', 'سكندنافي', 2790, 'products/bed.svg', 'سرير منجّد بلون أزرق ضبابي يبعث على الاسترخاء.', true],
            ['beds', 'سرير كنق بمسند مبطّن', 'مودرن دافئ', 3450, 'products/bed.svg', 'سرير واسع بمسند رأس ناعم ومريح.', false],
            ['beds', 'سرير بأدراج تخزين', 'بسيط', 3100, 'products/bed.svg', 'سرير عملي بأدراج تخزين مدمجة أسفله.', false],
            ['beds', 'سرير أطفال خشبي', 'بسيط', 1450, 'products/bed.svg', 'سرير آمن بخامات طبيعية لغرفة الأطفال.', false],
            // ---- التسريحات ----
            ['vanities', 'تسريحة بمرآة دائرية', 'مودرن دافئ', 1650, 'products/vanity.svg', 'تسريحة أنيقة بمرآة دائرية وأدراج تخزين.', true],
            ['vanities', 'تسريحة عصرية بأدراج', 'بسيط', 1350, 'products/vanity.svg', 'خطوط بسيطة ومساحة تخزين عملية.', false],
            ['vanities', 'تسريحة بإضاءة جانبية', 'كلاسيكي', 1980, 'products/vanity.svg', 'إضاءة موزّعة حول المرآة بلمسة فاخرة.', false],
            // ---- الخزائن ----
            ['wardrobes', 'خزانة أربعة أبواب', 'بسيط', 2950, 'products/wardrobe.svg', 'خزانة واسعة بأبواب سادة وتقسيمات داخلية.', true],
            ['wardrobes', 'خزانة بأبواب منزلقة', 'مودرن دافئ', 3600, 'products/wardrobe.svg', 'أبواب منزلقة موفّرة للمساحة بمرآة.', false],
            ['wardrobes', 'خزانة بمرآة', 'سكندنافي', 3200, 'products/wardrobe.svg', 'خزانة بمرآة كاملة وخامات فاتحة.', false],
            // ---- الكمدينات ----
            ['nightstands', 'كمدينة بدرجين', 'مودرن دافئ', 540, 'products/nightstand.svg', 'تخزين عملي بجانب السرير بدرجين.', false],
            ['nightstands', 'كمدينة معلّقة', 'بسيط', 420, 'products/nightstand.svg', 'كمدينة جدارية توفّر مساحة الأرضية.', false],
            ['nightstands', 'كمدينة خشبية كلاسيك', 'كلاسيكي', 690, 'products/nightstand.svg', 'خشب متين بمقابض دقيقة.', false],
            // ---- الشفنيرات ----
            ['chiffoniers', 'شفنيرة خمسة أدراج', 'بسيط', 1750, 'products/chiffonier.svg', 'خمسة أدراج واسعة لتنظيم الملابس.', true],
            ['chiffoniers', 'شفنيرة عريضة', 'مودرن دافئ', 2100, 'products/chiffonier.svg', 'سطح عريض ومساحة تخزين كبيرة.', false],
            ['chiffoniers', 'شفنيرة بمرآة', 'كلاسيكي', 2400, 'products/chiffonier.svg', 'شفنيرة بمرآة علوية بلمسة كلاسيكية.', false],
            // ---- الستائر ----
            ['curtains', 'ستارة كتان طبيعية', 'ألوان طبيعية', 480, 'products/curtain.svg', 'كتان بملمس طبيعي يمرّر ضوءاً ناعماً.', true],
            ['curtains', 'ستارة بلاك آوت', 'بسيط', 620, 'products/curtain.svg', 'تعتيم كامل لنوم مريح.', false],
            ['curtains', 'ستارة شيفون شفافة', 'سكندنافي', 350, 'products/curtain.svg', 'طبقة شفّافة تضيف خفّة وأناقة.', false],
            ['curtains', 'ستارة مزدوجة الطبقة', 'كلاسيكي', 780, 'products/curtain.svg', 'طبقتان للتحكّم بالخصوصية والإضاءة.', false],
            // ---- الكنب ----
            ['sofas', 'كنبة زاوية دافئة', 'مودرن دافئ', 3450, 'products/sofa.svg', 'كنبة زاوية بقماش قابل للغسل ولون تيراكوتا.', true],
            ['sofas', 'كنبة ثلاثة مقاعد', 'بسيط', 2600, 'products/sofa.svg', 'كنبة مريحة بخطوط بسيطة تناسب كل غرفة.', false],
            ['sofas', 'كنبة سرير قابلة للفتح', 'مودرن دافئ', 2950, 'products/sofa.svg', 'كنبة تتحوّل إلى سرير للضيوف.', false],
            ['sofas', 'كرسي مفرد مريح', 'سكندنافي', 720, 'products/chair.svg', 'كرسي مفرد داعم للظهر بلمسة دافئة.', false],
            // ---- المطابخ ----
            ['kitchens', 'مطبخ مودرن بجزيرة', 'مودرن دافئ', 18500, 'products/kitchen.svg', 'مطبخ عصري بجزيرة وسطح واسع.', true],
            ['kitchens', 'مطبخ كلاسيك خشبي', 'كلاسيكي', 21000, 'products/kitchen.svg', 'خزائن خشبية بتفاصيل كلاسيكية.', false],
            ['kitchens', 'مطبخ صغير عملي', 'بسيط', 9800, 'products/kitchen.svg', 'حلّ ذكي للمساحات الصغيرة.', false],
            // ---- المساكات ----
            ['handles', 'مسكة ذهبية', null, 45, 'hardware/handle-gold.svg', 'مسكة أنيقة بطلاء ذهبي.', true],
            ['handles', 'مسكة سوداء مطفية', null, 38, 'hardware/handle-black.svg', 'مسكة عصرية بلون أسود مطفي.', false],
            ['handles', 'مسكة خشبية', null, 42, 'hardware/handle-wood.svg', 'مسكة بخامة خشبية دافئة.', false],
            ['handles', 'مسكة وردية نحاسية', null, 48, 'hardware/handle-rose.svg', 'لمسة نحاسية وردية مميّزة.', false],
            // ---- سحابات الأدراج ----
            ['drawer-slides', 'سحّاب هيدروليك ناعم', null, 65, 'products/drawer-slide.svg', 'إغلاق ناعم وهادئ للأدراج.', true],
            ['drawer-slides', 'سحّاب تلسكوبي كامل', null, 55, 'products/drawer-slide.svg', 'فتح كامل للوصول لكل محتويات الدرج.', false],
            ['drawer-slides', 'سحّاب دفع وفتح', null, 72, 'products/drawer-slide.svg', 'فتح بلمسة بدون مقابض (Push-Open).', false],
            // ---- الخشب (بجميع الألوان) — السعر للمتر ----
            ['wood', 'خشب بلوط فاتح', null, 220, 'swatches/wood-oak.svg', 'درجة بلوط فاتحة ودافئة. السعر للمتر.', true],
            ['wood', 'خشب جوزي', null, 260, 'swatches/wood-walnut.svg', 'بني جوزي غني وفاخر. السعر للمتر.', false],
            ['wood', 'خشب رمادي', null, 240, 'swatches/wood-gray.svg', 'رمادي عصري محايد. السعر للمتر.', false],
            ['wood', 'خشب أبيض', null, 210, 'swatches/wood-white.svg', 'أبيض ناعم للمساحات الفاتحة. السعر للمتر.', false],
            ['wood', 'خشب بني داكن', null, 250, 'swatches/wood-dark.svg', 'بني داكن أنيق. السعر للمتر.', false],
            ['wood', 'خشب طبيعي', null, 230, 'swatches/wood-natural.svg', 'لون خشبي طبيعي متعدّد الاستخدام. السعر للمتر.', false],
            // ---- القماش (بجميع الألوان) — السعر للمتر ----
            ['fabric', 'قماش بيج', null, 90, 'swatches/fabric-beige.svg', 'قماش تنجيد بيج هادئ. السعر للمتر.', true],
            ['fabric', 'قماش رمادي', null, 95, 'swatches/fabric-gray.svg', 'رمادي عملي يناسب كل الأثاث. السعر للمتر.', false],
            ['fabric', 'قماش أخضر زيتي', null, 110, 'swatches/fabric-olive.svg', 'أخضر زيتي دافئ وأنيق. السعر للمتر.', false],
            ['fabric', 'قماش أزرق ضبابي', null, 105, 'swatches/fabric-blue.svg', 'أزرق هادئ يبعث على الراحة. السعر للمتر.', false],
            ['fabric', 'قماش تيراكوتا', null, 115, 'swatches/fabric-terracotta.svg', 'تيراكوتا دافئ بهوية Sera. السعر للمتر.', false],
            ['fabric', 'قماش كريمي', null, 100, 'swatches/fabric-cream.svg', 'كريمي ناعم ومحايد. السعر للمتر.', false],
        ];

        $keepNames = [];
        foreach ($products as [$slug, $name, $style, $price, $image, $desc, $featured]) {
            $keepNames[] = $name;
            Product::updateOrCreate(
                ['name' => $name],
                [
                    'category_id' => $catIds[$slug] ?? null,
                    'style' => $style,
                    'price' => $price,
                    'image_path' => $image,
                    'description' => $desc,
                    'is_featured' => $featured,
                ]
            );
        }

        // Prune only the demo products this seeder owns (bundled illustrations),
        // so imported supplier catalogs and admin-added products are never touched.
        Product::whereNotIn('name', $keepNames)
            ->where(function ($q) {
                $q->where('image_path', 'like', 'products/%')
                    ->orWhere('image_path', 'like', 'swatches/%')
                    ->orWhere('image_path', 'like', 'hardware/%');
            })
            ->delete();
    }
}
