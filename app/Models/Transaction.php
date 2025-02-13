<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    public const STATUS_TRUE = true;
    public const STATUS_FALSE = false;

    public const TYPE_CREDIT = 'credit';
    public const TYPE_DEBIT = 'debit';

    protected $fillable = ['type', 'amount', 'balance_before', 'balance_after', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
