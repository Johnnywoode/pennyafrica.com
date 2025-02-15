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
            'is_admin' => true,
            'status' => true,
        ])->details()->create([
            'name' => 'Super Admin',
            'email' => 'admin@pennyafrica.com',
            'password' => Hash::make('aaaaaaaa'),
        ])->user->account()->create([
            'balance' => 1000.79,
        ]);

        $user = User::create([
            'phone' => '233244111111',
            'status' => true,
        ])->details()->create([
            'name' => 'John Doe',
            'email' => 'user@pennyafrica.com',
            'password' => Hash::make('aaaaaaaa'),
        ])->user->account()->create([
            'balance' => 100.99,
        ]);
    }
}
