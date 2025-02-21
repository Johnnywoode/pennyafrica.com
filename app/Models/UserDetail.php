<?php

namespace App\Models;

use App\Traits\HasUuid;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['name', 'email', 'password', 'dob', 'gender'];

    protected $casts = [
        'dob' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAge()
    {
        $dob = new DateTime($this->dob);
        $today = new DateTime();
        $age = $dob->diff($today)->y;
        return $age;
    }
}
