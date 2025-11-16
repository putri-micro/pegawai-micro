<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Otp extends Model
{
    protected $table = 'otps';

    protected $fillable = [
        'email',
        'otp_code',
        'expired_at',
        'attempts',
        'is_verified',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expired_at);
    }

    // Cek apakah melebihi batas percobaan
    public function isMaxAttemptsExceeded()
    {
        return $this->attempts >= 5;
    }

    // Tambah percobaan
    public function addAttempt()
    {
        $this->increment('attempts');
    }

    // Hapus OTP lama untuk email tertentu
    public static function clearOldOtps($email)
    {
        return self::where('email', $email)->delete();
    }
}