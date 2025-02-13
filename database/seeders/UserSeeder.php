<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'phone' => '233244000000',
            'status' => true,
        ])->details()->create([
            'name' => 'User',
            'email' => 'user@pennyafrica.com',
            'password' => Hash::make('aaaaaaaa'),
        ])->user->account()->create([
            'balance' => 100.79,
        ]);
    }
}
