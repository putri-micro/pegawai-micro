<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class Admin extends Authenticatable
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'id_admin';
    protected $keyType = 'string';
    protected $table = 'admin';

    protected $fillable = [
        'id_admin',
        'username',
        'nama',
        'email',
        'phone',
        'password',
        'role',
        'is_verified',
        'failed_attempt',
        'lock_until',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'lock_until' => 'datetime',
        'is_verified' => 'boolean',
    ];

    // Scope untuk username case-insensitive
    public function scopeWhereUsername($query, $username)
    {
        return $query->whereRaw('LOWER(username) = ?', [strtolower($username)]);
    }

    // Cek apakah akun terkunci
    public function isLocked()
    {
        return $this->lock_until && now()->lessThan($this->lock_until);
    }

    // Reset percobaan gagal
    public function resetFailedAttempts()
    {
        $this->update([
            'failed_attempt' => 0,
            'lock_until' => null,
        ]);
    }

    // Tambah percobaan gagal
    public function addFailedAttempt()
    {
        $failedAttempt = $this->failed_attempt + 1;
        
        if ($failedAttempt >= 5) {
            $this->update([
                'failed_attempt' => $failedAttempt,
                'lock_until' => now()->addMinutes(5),
            ]);
        } else {
            $this->update(['failed_attempt' => $failedAttempt]);
        }
    }
}