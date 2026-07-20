<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Calls OpenAI to turn a project's brief into a concrete design proposal.
 *
 * Returns a plain array in the same shape DesignGenerator persists:
 * ['palette' => [...], 'furniture' => [...], 'lighting' => [...],
 *  'summary' => string, 'estimated_cost' => int].
 *
 * Throws on any problem (missing key, network error, malformed reply) so the
 * caller can fall back to the rule-based generator.
 */
class OpenAiDesignClient
{
    public function isConfigured(): bool
    {
        return ! empty(config('services.openai.key'));
    }

    /**
     * @param  array{floor:int, ceiling:int}  $bracket  Spend range for the budget tier.
     * @return array<string, mixed>
     */
    public function generate(Project $project, array $bracket): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('OpenAI API key is not configured.');
        }

        $response = Http::withToken(config('services.openai.key'))
            ->timeout(config('services.openai.timeout', 30))
            ->acceptJson()
            ->post(rtrim(config('services.openai.base_url'), '/').'/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'temperature' => 0.7,
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    ['role' => 'system', 'content' => $this->systemPrompt()],
                    ['role' => 'user', 'content' => $this->userPrompt($project, $bracket)],
                ],
            ]);

        if ($response->failed()) {
            throw new RuntimeException('OpenAI request failed: HTTP '.$response->status());
        }

        $content = data_get($response->json(), 'choices.0.message.content');

        if (! is_string($content) || $content === '') {
            throw new RuntimeException('OpenAI returned an empty response.');
        }

        $data = json_decode($content, true);

        if (! is_array($data)) {
            throw new RuntimeException('OpenAI response was not valid JSON.');
        }

        return $this->normalize($data, $bracket);
    }

    protected function systemPrompt(): string
    {
        return <<<'PROMPT'
        أنت مصمم داخلي محترف يعمل داخل منصة "Sera Home". تعطيك تفاصيل مشروع
        (نوع الغرفة، الأسلوب، الميزانية) فتقترح تصميماً واقعياً ومتناسقاً.

        أعد الرد بصيغة JSON فقط، بالمفاتيح التالية وباللغة العربية:
        {
          "palette":   [ {"name": "اسم اللون بالعربية", "hex": "#RRGGBB"}, ... 4 ألوان متناسقة ],
          "furniture": [ {"name": "اسم القطعة", "note": "ملاحظة قصيرة", "price": عدد صحيح بالريال}, ... 4 إلى 6 قطع ],
          "lighting":  [ "عبارة إضاءة 1", "عبارة إضاءة 2", "عبارة إضاءة 3" ],
          "summary":   "فقرة قصيرة (جملتان) تصف روح التصميم",
          "estimated_cost": عدد صحيح = مجموع أسعار القطع
        }

        قواعد مهمة:
        - اجعل مجموع أسعار الأثاث ضمن نطاق الميزانية المعطى.
        - استخدم أكواد ألوان hex صحيحة.
        - لا تكتب أي نص خارج كائن الـ JSON.
        PROMPT;
    }

    /**
     * @param  array{floor:int, ceiling:int}  $bracket
     */
    protected function userPrompt(Project $project, array $bracket): string
    {
        $room = $project->room_type;
        $style = $project->style;
        $budget = $project->budget;
        $floor = $bracket['floor'];
        $ceiling = $bracket['ceiling'];

        return "المشروع:\n"
            ."- نوع الغرفة: {$room}\n"
            ."- الأسلوب المطلوب: {$style}\n"
            ."- الميزانية المُعلنة: {$budget}\n"
            ."- نطاق الإنفاق المستهدف لمجموع الأثاث: بين {$floor} و {$ceiling} ريال.\n\n"
            .'اقترح تصميماً كاملاً وفق الصيغة المطلوبة.';
    }

    /**
     * Validate and clean the model output, clamping the total into the bracket.
     *
     * @param  array<string, mixed>  $data
     * @param  array{floor:int, ceiling:int}  $bracket
     * @return array<string, mixed>
     */
    protected function normalize(array $data, array $bracket): array
    {
        $palette = [];
        foreach ((array) ($data['palette'] ?? []) as $color) {
            $hex = is_array($color) ? ($color['hex'] ?? '') : '';
            $name = is_array($color) ? ($color['name'] ?? '') : '';
            if (preg_match('/^#[0-9A-Fa-f]{6}$/', (string) $hex) && $name !== '') {
                $palette[] = ['name' => (string) $name, 'hex' => strtoupper((string) $hex)];
            }
        }

        $furniture = [];
        foreach ((array) ($data['furniture'] ?? []) as $item) {
            if (! is_array($item) || empty($item['name'])) {
                continue;
            }
            $furniture[] = [
                'name' => (string) $item['name'],
                'note' => (string) ($item['note'] ?? ''),
                'price' => max(0, (int) round((float) ($item['price'] ?? 0))),
            ];
        }

        if (count($palette) < 3 || count($furniture) < 2) {
            throw new RuntimeException('OpenAI response was missing required fields.');
        }

        $lighting = array_values(array_filter(
            array_map('strval', (array) ($data['lighting'] ?? [])),
            fn ($line) => trim($line) !== '',
        ));

        $estimated = array_sum(array_column($furniture, 'price'));

        // If the model drifted outside the bracket, scale prices to fit.
        if ($estimated > 0 && ($estimated < $bracket['floor'] || $estimated > $bracket['ceiling'])) {
            $target = (int) round(($bracket['floor'] + $bracket['ceiling']) / 2);
            $factor = $target / $estimated;
            foreach ($furniture as &$item) {
                $item['price'] = max(50, (int) (round($item['price'] * $factor / 50) * 50));
            }
            unset($item);
            $estimated = array_sum(array_column($furniture, 'price'));
        }

        return [
            'palette' => $palette,
            'furniture' => $furniture,
            'lighting' => $lighting !== [] ? $lighting : ['إضاءة دافئة متعددة الطبقات'],
            'summary' => trim((string) ($data['summary'] ?? '')) ?: 'تصميم متناسق يوازن بين الجمال والوظيفة ضمن ميزانيتك.',
            'estimated_cost' => $estimated,
        ];
    }
}
