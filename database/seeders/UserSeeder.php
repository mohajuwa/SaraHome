<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@serahome.test'], [
            'name' => 'مشرف Sera',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+966500000000',
        ]);

        User::updateOrCreate(['email' => 'sara@serahome.test'], [
            'name' => 'سارة أحمد',
            'password' => Hash::make('password'),
            'role' => 'client',
            'preferred_style' => 'مودرن دافئ',
            'budget_range' => '5,000 - 10,000 ريال',
        ]);

        $clients = [
            ['name' => 'نورة الحربي', 'email' => 'noura@serahome.test'],
            ['name' => 'محمد السالم', 'email' => 'mohammed@serahome.test'],
            ['name' => 'ليان العتيبي', 'email' => 'layan@serahome.test'],
        ];

        foreach ($clients as $c) {
            User::updateOrCreate(['email' => $c['email']], [
                'name' => $c['name'],
                'password' => Hash::make('password'),
                'role' => 'client',
            ]);
        }
    }
}
