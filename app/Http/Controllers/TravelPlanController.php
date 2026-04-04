<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelPlan;

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
    }
