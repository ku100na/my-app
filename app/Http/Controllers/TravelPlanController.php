<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelPlan;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
    
    public function store(Request $request): RedirectResponse {
        $travelPlan = TravelPlan::create([
            'user_id' => $request->id,
            'title' => $request->title,
            'country' => $request->country,
            'city' => $request->city,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'overview' => $request->overview,
            'is_public' => $request->is_public,
            'photo_url' => $request->photo_url,
            'status' => $request->status
        ]);
        event(new Registered($travelPlan));

        // Intervention Imageでリサイズ
        $image = Image::make($file)
            ->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio(); // 縦横比を維持
                $constraint->upsize();      // 元より大きくならない
            });

        return redirect('travel-plans');
    }
}
