<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Account extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['balance'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deductDecimalPart(string  $type) : void
    {
        $balance = $this->balance;
        $decimalPart = $this->balance - floor($balance);

        if ($decimalPart > 0) {
            $newBalance = floor($balance);
            $this->update(['balance' => $newBalance]);


            $this->user->transactions()->create([
                'type' => $type,
                'amount' => $decimalPart,
                'balance_before' => $balance,
                'balance_after' => $newBalance,
                'status' => true,
            ]);
        }
    }

}
