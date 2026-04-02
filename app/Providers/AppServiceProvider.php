<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8)
                ->letters()      // 文字を含む
                ->mixedCase()    // 大文字と小文字を含む
                ->numbers()      // 数字を含む
                ->symbols()      // 記号を含む
                ->uncompromised(); // 漏洩したパスワードでないかチェック
        });
    }
}
