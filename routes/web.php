<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/debug', function () {
    dd(env('DB_CONNECTION'));
});
Route::get('/', [GuestController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/travel-plans', [TravelPlanController::class, 'index'])->name('travel-plans.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/travel-plans/create',function() {
        return view('travel_plans.create');
    })->name('travel-plans.create');
    Route::post('/travel-plans', [TravelPlanController::class, 'store'])->name('travel-plans.store');
    Route::get('/travel-plans/{travelPlan}/edit', [TravelPlanController::class, 'edit'])->name('travel-plans.edit');
    Route::put('/travel-plans/{travelPlan}', [TravelPlanController::class, 'update'])->name('travel-plans.update');
    Route::post('/travel-plans/{travelPlan}/favorite', [TravelPlanController::class, 'toggleFavorite'])->name('travel-plans.toggleFavorite');
    Route::delete('/travel-plans/{travelPlan}', [TravelPlanController::class, 'destroy'])->name('travel-plans.destroy');
});

Route::get('/travel-plans/{travelPlan}', [TravelPlanController::class, 'show'])->name('travel-plans.show');

require __DIR__.'/auth.php';