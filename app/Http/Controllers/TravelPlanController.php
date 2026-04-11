<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelPlanRequest;
use Illuminate\Http\Request;
use App\Models\TravelPlan;
use App\Models\TravelRecord;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\View\View;

class TravelPlanController extends Controller
{
    public function index(Request $request) {

        // ログインユーザー取得
        $user = auth()->user();
        $activeTab = 'index';

        // 表示切替
        if ($request->query('type') === 'mine' && $user) {
            // 自分のプランを表示
            $plans = TravelPlan::where('user_id', $user->id)
                ->orderBy('start_date', 'desc')
                ->paginate(2);
        } else {
            // 自分以外のみんなのプランを表示
            $plans = TravelPlan::where('is_public', true)
                ->when($user, fn($q) => $q->where('user_id', '!=', $user->id))
                ->orderBy('start_date', 'desc')
                ->paginate(2);
        }

        return view ('travel_plans.index', [
            'plans' => $plans]);
        }
    
    public function store(TravelPlanRequest $request): RedirectResponse {
        $travelPlan = TravelPlan::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'country' => $request->country,
            'city' => $request->city,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'overview' => $request->overview,
            'is_public' => $request->boolean('is_public'),
            'status' => $request->status
        ]);

        if($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');

            $image = Image::make($file)->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $savePath = storage_path('app/public/photos/' . $filename);
            $image->save($savePath);

            $travelPlan->photo_url = $filename;
            $travelPlan->save();
        }

        $dayNumber = 1;
        $days = $request->input('days', []);

        foreach($days as $day) {
            if(empty($day['title'])) continue;
            $dayModel = $travelPlan->days()->create([
                'day_number' => $dayNumber,
                'title' => $day['title'] ?? null,
            ]);

            // spots
            if(!empty($day['spots'])) {
                foreach($day['spots'] as $spot) {
                    // 空のスポットはスキップ
                    if(empty($spot['name'])) continue;

                    $dayModel->spots()->create([
                        'name' => $spot['name'] ?? null,
                        'duration' => (($spot['hours'] ?? 0) * 60) + ($spot['minutes'] ?? 0),
                        'review' => $spot['review'] ?? null,
                    ]);
                }
            }
            $dayNumber++;
        }

        $travelPlan->travelRecord()->create([
            'review' => $request->review,
            'cost' => $request->cost,
        ]);

        return redirect()->route('travel-plans.show', $travelPlan->id)->with('success', 'プランを作成しました。');
    }

    public function show(TravelPlan $travelPlan): View
    {
        $travelPlan->load([
            'travelRecord',
            'days.spots',
        ]);

        return view('travel_plans.show', compact('travelPlan'));
    }

    public function edit(TravelPlan $travelPlan): View
    {
        $travelPlan->load([
            'travelRecord',
            'days.spots',
        ]);

        $days = $travelPlan->days->map(function ($day) {
            return [
                'title' => $day->title,
                'spots' => $day->spots->map(function ($spot) {
                    return [
                        'name' => $spot->name,
                        'hours' => $spot->hours,
                        'minutes' => $spot->minutes,
                        'review' => $spot->review,
                    ];
                })->values()
            ];
        })->values();

        return view('travel_plans.edit', compact('travelPlan', 'days'));
    }

    public function update(TravelPlanRequest $request, TravelPlan $travelPlan)
    {
        // 親の更新
        $travelPlan->update([
            'title' => $request->title,
            'country' => $request->country,
            'city' => $request->city,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_public' => $request->boolean('is_public'),
            'status' => $request->status,
        ]);

        // 画像
        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');

            $image = Image::make($file)->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $savePath = storage_path('app/public/photos/' . $filename);
            $image->save($savePath);

            $travelPlan->update([
                'photo_url' => $filename
            ]);
        }

        // 子データ全削除
        $travelPlan->days()->delete();

        // 子データ再作成
        $days = $request->input('days', []);
        $dayNumber = 1;

        foreach ($days as $day) {
            if (empty($day['title'])) continue;
            $dayModel = $travelPlan->days()->create([
                'day_number' => $dayNumber,
                'title' => $day['title'],
            ]);

            // spots
            if (!empty($day['spots'])) {
                foreach ($day['spots'] as $spot) {
                    if (empty($spot['name'])) continue;

                    $dayModel->spots()->create([
                        'name' => $spot['name'] ?? null,
                        'duration' => (($spot['hours'] ?? 0) * 60) + ($spot['minutes'] ?? 0),
                        'review' => $spot['review'] ?? null,
                    ]);
                }
            }
            $dayNumber++;
        }

        // travel records更新・作成
        $travelPlan->travelRecord()->updateOrCreate(
            ['travel_plan_id' => $travelPlan->id],
            [
                'review' => $request->review,
                'cost' => $request->cost,
            ]
        );

        return redirect()
            ->route('travel-plans.show', $travelPlan)
            ->with('success', 'プランを更新しました。');
    }
}
