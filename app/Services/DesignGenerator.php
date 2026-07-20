<?php

namespace App\Services;

use App\Models\Design;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Turns a project's style + room + budget into a concrete design proposal
 * (color palette, furniture list, lighting plan and an estimated cost).
 *
 * Uses OpenAI when an API key is configured, and transparently falls back to
 * the built-in rule-based logic on any failure (or when no key is set), so the
 * rest of the app keeps working either way.
 */
class DesignGenerator
{
    public function __construct(protected OpenAiDesignClient $ai)
    {
    }

    /** Color palettes keyed by design style. */
    protected array $palettes = [
        'مودرن دافئ' => [
            ['name' => 'تيراكوتا', 'hex' => '#C15F3C'],
            ['name' => 'رملي دافئ', 'hex' => '#E7D3BE'],
            ['name' => 'بُني محروق', 'hex' => '#7A4A32'],
            ['name' => 'كريمي فاتح', 'hex' => '#F5ECE0'],
        ],
        'سكندنافي' => [
            ['name' => 'أبيض ثلجي', 'hex' => '#F7F5F1'],
            ['name' => 'رمادي فاتح', 'hex' => '#D8D5CE'],
            ['name' => 'خشب البتولا', 'hex' => '#C9A87C'],
            ['name' => 'أزرق ضبابي', 'hex' => '#6D8A96'],
        ],
        'بسيط' => [
            ['name' => 'أوف وايت', 'hex' => '#F3EFE9'],
            ['name' => 'حجري', 'hex' => '#CBC3B8'],
            ['name' => 'فحمي هادئ', 'hex' => '#3A3733'],
            ['name' => 'بيج', 'hex' => '#E3D8C7'],
        ],
        'كلاسيكي' => [
            ['name' => 'ذهبي عتيق', 'hex' => '#C0913E'],
            ['name' => 'كستنائي', 'hex' => '#6E3B2E'],
            ['name' => 'عاجي', 'hex' => '#EFE7D6'],
            ['name' => 'أخضر زمردي', 'hex' => '#4C7A63'],
        ],
    ];

    /** Base furniture per room type: [name, note]. Prices come from the budget tier. */
    protected array $furniture = [
        'غرفة المعيشة' => [
            ['كنبة زاوية مريحة', 'قماش قابل للغسل بلون محايد'],
            ['طاولة قهوة خشبية', 'خطوط بسيطة تناسب المساحة'],
            ['سجادة ناعمة', 'تربط ألوان الغرفة معاً'],
            ['وحدة إضاءة أرضية', 'إضاءة دافئة غير مباشرة'],
        ],
        'غرفة النوم' => [
            ['سرير بتنجيد ناعم', 'لون هادئ يبعث على الاسترخاء'],
            ['طاولتان جانبيتان', 'تخزين عملي بجانب السرير'],
            ['خزانة ملابس', 'أبواب سادة بمقابض دقيقة'],
            ['إضاءة قراءة جدارية', 'ضوء موجّه وموفّر للمساحة'],
        ],
        'مكتب منزلي' => [
            ['مكتب عملي واسع', 'سطح يتّسع لشاشة وملفات'],
            ['كرسي مريح داعم للظهر', 'مناسب لساعات العمل الطويلة'],
            ['رفوف مفتوحة', 'تنظيم الكتب والديكور'],
            ['إضاءة مكتب موجّهة', 'تقلّل إجهاد العين'],
        ],
        'غرفة طعام' => [
            ['طاولة طعام لِستّة', 'خشب متين بلمسة دافئة'],
            ['ستة كراسي منجّدة', 'راحة تدوم أثناء الجلسات'],
            ['بوفيه تخزين', 'لأدوات الضيافة والديكور'],
            ['ثريا معلّقة', 'نقطة جذب فوق الطاولة'],
        ],
    ];

    /** Lighting plan per style. */
    protected array $lighting = [
        'مودرن دافئ' => ['إضاءة دافئة 2700K', 'طبقات إضاءة: سقفية + أرضية + نقطية', 'دلّاية فوق نقطة محورية واحدة'],
        'سكندنافي' => ['الاعتماد على الضوء الطبيعي', 'إضاءة بيضاء ناعمة 3000K', 'مصابيح بخامات فاتحة'],
        'بسيط' => ['إضاءة مخفية على المحيط', 'مصدر ضوء رئيسي واحد نظيف', 'تجنّب الزخارف الكثيرة'],
        'كلاسيكي' => ['ثريا مركزية فاخرة', 'أباليك جدارية متناظرة', 'إضاءة دافئة تُبرز التفاصيل'],
    ];

    /**
     * Produce and persist a design proposal for the project.
     * Tries the AI client first, then falls back to rule-based logic.
     */
    public function generate(Project $project): Design
    {
        [$floor, $ceiling] = $this->budgetBracket($project->budget);

        try {
            $proposal = $this->ai->generate($project, ['floor' => $floor, 'ceiling' => $ceiling]);
            $proposal['source'] = 'ai';
        } catch (Throwable $e) {
            Log::info('DesignGenerator falling back to rule-based logic: '.$e->getMessage());
            $proposal = $this->ruleBasedProposal($project);
            $proposal['source'] = 'rules';
        }

        return Design::updateOrCreate(
            ['project_id' => $project->id],
            [
                'palette' => $proposal['palette'],
                'furniture' => $proposal['furniture'],
                'lighting' => $proposal['lighting'],
                'summary' => $proposal['summary'],
                'estimated_cost' => $proposal['estimated_cost'],
            ]
        );
    }

    /**
     * The original deterministic proposal, used as a fallback.
     *
     * @return array<string, mixed>
     */
    protected function ruleBasedProposal(Project $project): array
    {
        $style = $project->style;
        $room = $project->room_type;

        $palette = $this->palettes[$style] ?? $this->palettes['مودرن دافئ'];
        $items = $this->furniture[$room] ?? $this->furniture['غرفة المعيشة'];
        [$base, $ceiling] = $this->budgetBracket($project->budget);

        // Spread item prices across the bracket, biggest piece first.
        $weights = [0.42, 0.26, 0.18, 0.14];
        $furniture = [];
        foreach ($items as $i => $item) {
            $price = (int) round(($base + ($ceiling - $base) * ($weights[$i] ?? 0.15)) * ($weights[$i] ?? 0.15) / 0.25);
            $price = max(150, (int) (round($price / 50) * 50));
            $furniture[] = [
                'name' => $item[0],
                'note' => $item[1],
                'price' => $price,
            ];
        }

        $estimated = array_sum(array_column($furniture, 'price'));

        $summary = "تصوّر {$style} لـ{$room}: توازن بين الراحة والجمال ضمن ميزانيتك، "
            .'مع لوحة ألوان متناسقة وقطع أساسية مختارة بعناية وخطة إضاءة تُبرز المساحة.';

        return [
            'palette' => $palette,
            'furniture' => $furniture,
            'lighting' => $this->lighting[$style] ?? $this->lighting['مودرن دافئ'],
            'summary' => $summary,
            'estimated_cost' => $estimated,
        ];
    }

    /** Returns [floor, ceiling] spend range parsed from an Arabic budget label. */
    protected function budgetBracket(string $budget): array
    {
        $digits = (int) preg_replace('/\D/', '', str_replace(',', '', $budget));

        return match (true) {
            str_contains($budget, 'أقل') => [2000, 5000],
            str_contains($budget, 'أكثر') => [10000, 22000],
            $digits >= 100000 => [10000, 20000], // "10,000 - 20,000"
            $digits >= 5000 => [5000, 10000],     // "5,000 - 10,000"
            default => [3000, 8000],
        };
    }
}
