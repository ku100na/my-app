<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TravelPlan;
use App\Models\Day;
use App\Models\Spot;
use App\Models\User;

class TravelPlanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $plans = [
            [
                'title' => '東京2泊3日旅行',
                'country' => '日本',
                'city' => '東京',
            ],
            [
                'title' => '東京グルメ旅',
                'country' => '日本',
                'city' => '東京',
            ],
            [
                'title' => '京都のんびり旅',
                'country' => '日本',
                'city' => '京都',
            ],
            [
                'title' => '北海道ドライブ旅行',
                'country' => '日本',
                'city' => '北海道',
            ],
        ];

        foreach ($plans as $data) {

            $plan = TravelPlan::create([
                'title' => $data['title'],
                'user_id' => $users->random()->id,
                'country' => $data['country'],
                'city' => $data['city'],
                'start_date' => now()->addDays(rand(1, 10)),
                'end_date' => now()->addDays(rand(11, 20)),
                'status' => collect(['planned', 'completed'])->random(),
                'overview' => '観光とグルメを楽しむ旅行プラン',
                'is_public' => (bool) rand(0, 1),
            ]);

            $day = $plan->days()->create([
                'day_number' => 1,
                'title' => '観光1日目',
            ]);

            $day->spots()->create([
                'name' => '人気観光スポット',
                'duration' => 90,
                'review' => 'とても良かったです',
            ]);

            // ⭐ TravelRecordも追加
            $plan->travelRecord()->create([
                'review' => 'とても充実した旅行でした',
                'cost' => 50000,
            ]);
        }
    }
}
