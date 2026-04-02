<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // プロフィール項目を追加
            $table->string('icon_image')->nullable(); // アイコン画像
            $table->text('bio')->nullable();          // 自己紹介
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // プロフィール項目を追加
            $table->dropColumn(['icon_image', 'bio']);
        });
    }
};
