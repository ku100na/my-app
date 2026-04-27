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
        User::updateOrCreate(
            ['email' => 'test1@example.com'],
            [
                'name' => 'テストユーザー1',
                'password' => Hash::make('password'),
            ]
        );       
        User::updateOrCreate(
            ['email' => 'test2@example.com'],
            [
                'name' => 'テストユーザー2',
                'password' => Hash::make('password'),
            ]
        );    
    }
}
