<?php

namespace Database\Seeders;

use App\Models\Inspiration;
use Illuminate\Database\Seeder;

class InspirationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'راحة بلون التيراكوتا', 'style' => 'مودرن دافئ', 'tag' => 'مودرن دافئ', 'accent_color' => '#C15F3C', 'image_path' => 'rooms/living-warm.svg'],
            ['title' => 'نوم هادئ ومضيء', 'style' => 'سكندنافي', 'tag' => 'سكندنافي', 'accent_color' => '#6D8A96', 'image_path' => 'rooms/bedroom-scandi.svg'],
            ['title' => 'مكتب عملي وناعم', 'style' => 'بسيط', 'tag' => 'مساحات صغيرة', 'accent_color' => '#8C8177', 'image_path' => 'rooms/office-minimal.svg'],
            ['title' => 'ركن قراءة دافئ', 'style' => 'ألوان طبيعية', 'tag' => 'ألوان هادئة', 'accent_color' => '#C0913E', 'image_path' => 'rooms/reading-nook.svg'],
            ['title' => 'توازن في غرفة الطعام', 'style' => 'مودرن دافئ', 'tag' => 'غرفة طعام', 'accent_color' => '#4C7A63', 'image_path' => 'rooms/dining-warm.svg'],
            ['title' => 'جلسة كلاسيكية أنيقة', 'style' => 'كلاسيكي', 'tag' => 'كلاسيكي', 'accent_color' => '#7A4A32', 'image_path' => 'rooms/living-classic.svg'],
        ];

        foreach ($items as $item) {
            Inspiration::updateOrCreate(['title' => $item['title']], $item);
        }

        // Remove any stale rows from earlier seeds (keeps the gallery in sync).
        Inspiration::whereNotIn('title', array_column($items, 'title'))->delete();
    }
}
