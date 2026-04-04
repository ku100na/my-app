<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function index() {
        // ログイン済みの場合はプラン一覧画面に遷移
        if (Auth::check()) {
            return redirect('/travel-plans');
        }
        return view('welcome');
        
    }
}
