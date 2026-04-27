<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'テストユーザー1',
            'email' => 'test1@example.com',
            'password' => Hash::make('password'),
        ]);
        User::firstOrCreate([
            'name' => 'テストユーザー2',
            'email' => 'test2@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
