<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $projects = [
            ['title' => 'شقة الرياض الدافئة', 'room' => 'غرفة معيشة', 'style' => 'مودرن دافئ', 'area' => '32 م²', 'image' => 'rooms/living-warm.svg', 'note' => 'لوحة تيراكوتا وإضاءة متعددة الطبقات خلقت جلسة عائلية دافئة.'],
            ['title' => 'ملاذ النوم الهادئ', 'room' => 'غرفة نوم', 'style' => 'سكندنافي', 'area' => '20 م²', 'image' => 'rooms/bedroom-scandi.svg', 'note' => 'ألوان فاتحة وخشب طبيعي لجوٍّ يبعث على الاسترخاء.'],
            ['title' => 'مكتب منزلي مركّز', 'room' => 'مكتب منزلي', 'style' => 'بسيط', 'area' => '12 م²', 'image' => 'rooms/office-minimal.svg', 'note' => 'مساحة عمل نظيفة بإضاءة موجّهة وتخزين مخفي.'],
            ['title' => 'زاوية الطعام العائلية', 'room' => 'غرفة طعام', 'style' => 'مودرن دافئ', 'area' => '18 م²', 'image' => 'rooms/dining-warm.svg', 'note' => 'طاولة خشبية وثريا دافئة كنقطة جذب للعائلة.'],
            ['title' => 'ركن القراءة', 'room' => 'ركن مطالعة', 'style' => 'ألوان طبيعية', 'area' => '8 م²', 'image' => 'rooms/reading-nook.svg', 'note' => 'كرسي مريح وإضاءة ناعمة لأمسيات هادئة.'],
            ['title' => 'جلسة كلاسيكية أنيقة', 'room' => 'غرفة معيشة', 'style' => 'كلاسيكي', 'area' => '40 م²', 'image' => 'rooms/living-classic.svg', 'note' => 'تفاصيل ذهبية وألوان كستنائية بلمسة فاخرة.'],
        ];

        $stats = [
            ['value' => '1,200+', 'label' => 'مشروع مكتمل'],
            ['value' => '4.8', 'label' => 'متوسط التقييم'],
            ['value' => '14', 'label' => 'مدينة'],
            ['value' => '96%', 'label' => 'رضا العملاء'],
        ];

        return view('client.portfolio', compact('projects', 'stats'));
    }
}
