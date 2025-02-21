<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'phone' => '233244000000',
            'is_admin' => true,
            'network' => User::NETWORK_MTN,
            'status' => true,
        ])->details()->create([
            'name' => 'Super Admin',
            'dob' => '1989-05-18',
            'gender' => 'male',
            'email' => 'admin@pennyafrica.com',
            'password' => Hash::make('aaaaaaaa'),
        ])->user->account()->create([
            'balance' => 1000.79,
        ]);

        User::create([
            'phone' => '233200000000',
            'network' => User::NETWORK_TELECEL,
            'status' => true,
        ])->details()->create([
            'name' => 'John Doe',
            'dob' => '1994-07-20',
            'gender' => 'male',
            'email' => 'user@pennyafrica.com',
            'password' => Hash::make('aaaaaaaa'),
        ])->user->account()->create([
            'balance' => 100.99,
        ]);
    }
}
