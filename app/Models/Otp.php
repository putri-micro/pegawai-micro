<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Otp extends Model
{
    protected $fillable = [
        'email', 'otp_code', 'expired_at', 'attempts', 'is_verified'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return Carbon::now()->greaterThan($this->expired_at);
    }
}
