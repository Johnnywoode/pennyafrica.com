<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->call(UserSeeder::class);
            $user = User::first();
        }

        $account = $user->account;

        // Deduct the decimal part
        $account->deductDecimalPart(Transaction::TYPE_CREDIT);
    }
}
