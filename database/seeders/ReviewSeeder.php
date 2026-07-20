<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            ['noura@serahome.test', 'كنبة زاوية دافئة', 5, 'جودة ممتازة واللون طلع أجمل من الصور. التوصيل كان سريعاً.'],
            ['mohammed@serahome.test', 'كنبة زاوية دافئة', 4, 'مريحة جداً، بس التجميع أخذ وقت شوي.'],
            ['layan@serahome.test', 'سرير مزدوج منجّد', 5, 'أفضل شراء! غيّر شكل الغرفة كاملة.'],
            ['noura@serahome.test', 'تسريحة بمرآة دائرية', 4, 'أنيقة وعملية، الأدراج واسعة.'],
            ['layan@serahome.test', 'ستارة كتان طبيعية', 5, 'الخامة فخمة والإضاءة تعدّي بشكل ناعم وجميل.'],
            ['mohammed@serahome.test', 'مطبخ مودرن بجزيرة', 5, 'تنفيذ احترافي والتصميم عملي جداً للعائلة.'],
        ];

        foreach ($reviews as [$email, $productName, $rating, $comment]) {
            $user = User::where('email', $email)->first();
            $product = Product::where('name', $productName)->first();

            if (! $user || ! $product) {
                continue;
            }

            Review::updateOrCreate(
                ['user_id' => $user->id, 'product_id' => $product->id],
                ['rating' => $rating, 'comment' => $comment]
            );
        }
    }
}
