<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['name', 'email', 'password'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
