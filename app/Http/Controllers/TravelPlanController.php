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

        $user = Auth::user();

        if ($user) {
            $user->load('favorites');
        }
        
        $query = TravelPlan::query();

        // 表示切替
        if ($request->query('type') === 'mine' && $user) {
            // 自分のプランを表示
            $query->where('user_id', $user->id);
        } else {
            // 自分以外のみんなのプランを表示
            $query->where('is_public', true);
        }

        // キーワード検索
        if ($request->keyword) {
            $keywords = preg_split('/[\s　]+/u', trim($request->keyword));

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($q1) use ($word) {
                        
                        // TravelPlans
                        $q1->where('title', 'like', "%{$word}%")
                            ->orWhere('overview', 'like', "%{$word}%")

                            // Days
                            ->orWhereHas('days', function ($q2) use ($word) {
                                $q2->where('title', 'like', "%{$word}%");
                            })

                            // Spots
                            ->orWhereHas('days.spots', function ($q3) use ($word) {
                                $q3->where('name', 'like', "%{$word}%");
                            });
                    });
                }
            });
        }

        // 国検索
        if ($request->country) {
            $query->where('country', 'like', "%{$request->country}%");
        }

        // 都市検索
        if ($request->city) {
            $query->where('city', 'like', "%{$request->city}%");
        }

        // 予算検索
        if ($request->min_budget) {
            $query->whereHas('travelRecord', function ($q) use ($request) {
                $q->where('cost', '>=', $request->min_budget);
            });
        }

        if ($request->max_budget) {
            $query->whereHas('travelRecord', function ($q) use ($request) {
                $q->where('cost', '<=', $request->max_budget);
            });
        }

        // お気に入り
        if ($request->favorited && $user) {
            $query->whereHas('favoritedUsers', function ($q) use ($user) {
                $q->where('users.id', $user->id); 
            });
        }

        // 並び
        $plans = $query
            ->with('favoritedUsers')
            ->orderBy('start_date','desc')
            ->paginate(2)
            ->withQueryString();

        return view ('travel_plans.index', compact('plans', 'user'));
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

        foreach($days as $dayIndex => $day) {
            if(empty($day['title'])) continue;
            $dayModel = $travelPlan->days()->create([
                'day_number' => $dayNumber,
                'title' => $day['title'] ?? null,
            ]);

            // spots
            if(!empty($day['spots'])) {
                foreach($day['spots'] as $spotIndex => $spot) {
                    // 空のスポットはスキップ
                    $duration = (($spot['hours'] ?? 0) * 60) + ($spot['minutes'] ?? 0);
                    
                    if ($duration > 0 || !empty($spot['review'])) {
                        if(empty($spot['name'])) {
                            return back()
                            ->withErrors([
                                "days.$dayIndex.spots.$spotIndex.name"
                                => 'スポット名は関連項目が設定されている場合必須です。'
                            ])
                            ->withInput();
                        }
                    }

                    if (!empty($spot['name'])) {
                        $dayModel->spots()->create([
                            'name' => $spot['name'] ?? null,
                            'duration' => $duration,
                            'review' => $spot['review'] ?? null,
                        ]);
                    }
                }
            }
            $dayNumber++;
        }

        if (!empty($request->review) && !empty($request->cost)) {
            $travelPlan->travelRecord()->create([
                'review' => $request->review,
                'cost' => $request->cost,
            ]);
        }

        return redirect()->route('travel-plans.show', $travelPlan->id)->with('success', 'プランを作成しました。');
    }

    public function show(TravelPlan $travelPlan): View
    {
        $travelPlan->load([
            'travelRecord',
            'days.spots',
            'favoritedUsers'
        ]);

        $user = Auth::user();
        if ($user) {
            $user->load('favorites');
        }

        return view('travel_plans.show', compact('travelPlan', 'user'));
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
                    $duration = $spot->duration ?? 0;
                    return [
                        'name' => $spot->name,
                        'duration' => $spot->duration,
                        'hours' => intdiv($duration, 60),
                        'minutes' => $duration % 60,
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
            'overview' => $request->overview,
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

        foreach ($days as $dayIndex => $day) {
            if (empty($day['title'])) continue;
            $dayModel = $travelPlan->days()->create([
                'day_number' => $dayNumber,
                'title' => $day['title'],
            ]);

            // spots
            if (!empty($day['spots'])) {
                foreach ($day['spots'] as $spotIndex => $spot) {
                    // 空のスポットはスキップ
                    $duration = (($spot['hours'] ?? 0) * 60) + ($spot['minutes'] ?? 0);

                    if ($duration >0 || !empty($spot['review'])) {
                        if (empty($spot['name'])) {
                            return back()
                            ->withErrors([
                                "days.$dayIndex.spots.$spotIndex.name"
                                => 'スポット名は関連項目が設定されている場合必須です。'
                            ])
                            ->withInput();
                        }
                    }

                    if (!empty($spot['name'])) {
                        $dayModel->spots()->create([
                            'name' => $spot['name'] ?? null,
                            'duration' => (($spot['hours'] ?? 0) * 60) + ($spot['minutes'] ?? 0),
                            'review' => $spot['review'] ?? null,
                        ]);
                    }
                }
            }
            $dayNumber++;
        }

        // travel records更新・作成
        $review = $request->review;
        $cost = $request->cost;
        if (blank($review) && blank($cost)) {
            $travelPlan->travelRecord()->delete();
        } else {
            $travelPlan->travelRecord()->updateOrCreate(
                ['travel_plan_id' => $travelPlan->id],
                [
                    'review' => $request->review,
                    'cost' => $request->cost,
                ]
            );
        }

        return redirect()
            ->route('travel-plans.show', $travelPlan)
            ->with('success', 'プランを更新しました。');
    }

    public function toggleFavorite(TravelPlan $travelPlan) {
        $user = Auth::user();

        if ($user->favorites()->where('travel_plan_id', $travelPlan->id)->exists()) {
            $user->favorites()->detach($travelPlan->id);
        } else {
            $user->favorites()->attach($travelPlan->id);
        }

        return back();
    }
}
