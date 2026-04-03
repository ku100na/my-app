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
    ]);
    }
}
