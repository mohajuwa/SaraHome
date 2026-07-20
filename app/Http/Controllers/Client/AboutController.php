<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $services = [
            ['icon' => 'sparkle', 'title' => 'تصميم بمساعدة الذكاء', 'desc' => 'ارفعي صورة غرفتك واحصلي على لوحة ألوان وأثاث وخطة إضاءة مقترحة في ثوانٍ.'],
            ['icon' => 'store', 'title' => 'أثاث مختار', 'desc' => 'قطع منسّقة مع أسلوبك وميزانيتك، جاهزة للطلب مباشرة من المتجر.'],
            ['icon' => 'portfolio', 'title' => 'إشراف مصمّم', 'desc' => 'مصمّم يراجع تصوّرك ويضيف اللمسات النهائية قبل التنفيذ.'],
            ['icon' => 'chat', 'title' => 'دعم متواصل', 'desc' => 'فريقنا يجيب على استفساراتك عبر الدردشة وواتساب في كل مرحلة.'],
        ];

        $steps = [
            ['n' => '1', 'title' => 'ارفعي صورة الغرفة', 'desc' => 'صورة واضحة لمساحتك الحالية.'],
            ['n' => '2', 'title' => 'حدّدي ذوقك وميزانيتك', 'desc' => 'اختاري الأسلوب ونطاق الإنفاق.'],
            ['n' => '3', 'title' => 'استلمي التصوّر', 'desc' => 'ألوان وأثاث وإضاءة مصمّمة لك.'],
            ['n' => '4', 'title' => 'نفّذي بسهولة', 'desc' => 'اطلبي القطع وتابعي التنفيذ.'],
        ];

        return view('client.about', compact('services', 'steps'));
    }
}
