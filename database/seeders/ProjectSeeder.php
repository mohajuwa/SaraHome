<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Services\DesignGenerator;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(DesignGenerator $generator): void
    {
        $sara = User::where('email', 'sara@serahome.test')->first();
        $noura = User::where('email', 'noura@serahome.test')->first();
        $mohammed = User::where('email', 'mohammed@serahome.test')->first();
        $layan = User::where('email', 'layan@serahome.test')->first();

        $seed = [
            [$sara, 'ركن الراحة', 'غرفة المعيشة', 'مودرن دافئ', '5,000 - 10,000 ريال', 'in_review', 68, true],
            [$sara, 'ملاذ هادئ', 'غرفة النوم', 'سكندنافي', '5,000 - 10,000 ريال', 'completed', 100, true],
            [$noura, 'مكتب الإبداع', 'مكتب منزلي', 'بسيط', 'أقل من 5,000 ريال', 'new', 12, false],
            [$mohammed, 'جلسة العائلة', 'غرفة المعيشة', 'كلاسيكي', '10,000 - 20,000 ريال', 'new', 12, false],
            [$layan, 'زاوية الطعام', 'غرفة طعام', 'سكندنافي', '5,000 - 10,000 ريال', 'in_review', 45, true],
        ];

        foreach ($seed as [$user, $name, $room, $style, $budget, $status, $progress, $withDesign]) {
            if (! $user) {
                continue;
            }

            $project = Project::updateOrCreate(
                ['user_id' => $user->id, 'name' => $name],
                [
                    'room_type' => $room,
                    'style' => $style,
                    'budget' => $budget,
                    'status' => $status,
                    'progress' => $progress,
                ]
            );

            if ($withDesign) {
                $generator->generate($project);
            }
        }

        // A short conversation on Sara's living-room project.
        $project = Project::where('name', 'ركن الراحة')->first();
        if ($project) {
            $admin = User::where('role', 'admin')->first();
            $convo = [
                [$admin->id, true, 'أهلاً سارة، جهّزت لك لوحة ألوان أولية لغرفة المعيشة. 🌿'],
                [$admin->id, true, 'أضفت لون التيراكوتا كلمسة دافئة مع خلفية رملية هادئة.'],
                [$project->user_id, false, 'فكرة جميلة، هل يمكن أن نجعل السجادة بلون أفتح؟'],
                [$admin->id, true, 'بالتأكيد، سأحدّث الاقتراح وأرسله لكِ قريباً.'],
            ];

            foreach ($convo as [$uid, $fromDesigner, $body]) {
                Message::updateOrCreate(
                    ['project_id' => $project->id, 'body' => $body],
                    ['user_id' => $uid, 'is_from_designer' => $fromDesigner]
                );
            }
        }
    }
}
