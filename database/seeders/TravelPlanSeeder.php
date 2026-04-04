<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TravelPlan;
use App\Models\User;

class TravelPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        TravelPlan::create([
            'user_id' => $user->id,
            'title' => 'フィンランド旅行',
            'country' => 'フィンランド',
            'city' => 'ヘルシンキ',
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-05',
            'overview' => 'サウナと自然を楽しむ旅',
            'is_public' => true,
            'status' => 'planned',
        ]);

        TravelPlan::create([
            'user_id' => $user->id,
            'title' => '大阪旅行',
            'country' => '日本',
            'city' => '大阪',
            'start_date' => '2025-03-10',
            'end_date' => '2025-03-12',
            'overview' => '食べ歩きツアー',
            'is_public' => true,
            'status' => 'completed',
        ]);

        TravelPlan::create([
            'user_id' => $user->id,
            'title' => 'パリ旅行',
            'country' => 'フランス',
            'city' => 'パリ',
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-07',
            'overview' => '美術館巡り',
            'is_public' => false,
            'status' => 'planned',
        ]);
            }
        }
