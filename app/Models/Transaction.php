<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\ScopeWhereLike;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory, HasUuid, ScopeWhereLike, SoftDeletes;

    public const STATUS_TRUE = true;
    public const STATUS_FALSE = false;

    public const TYPE_CREDIT = 'credit';
    public const TYPE_DEBIT = 'debit';

    protected $fillable = ['type', 'amount', 'balance_before', 'balance_after', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function displayType()
    {
         switch ($this->type) {
            case self::TYPE_CREDIT:
                $type = '<span class="badge rounded-pill text-bg-success">'. ucfirst($this->type) .'</span>';
                break;

            case self::TYPE_DEBIT:
                $type = '<span class="badge rounded-pill text-bg-danger">'. ucfirst($this->type) .'</span>';
                break;

            default:
                $type = $this->type;
                break;
         }

         return $type;
    }

    public function displayStatus(){
        return $this->status ?
            '<i class="bi bi-check-circle-fill text-success fs-3"></i>' :
            '<i class="bi bi-x-circle-fill text-danger fs-3"></i>';
    }
}
