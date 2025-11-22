<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasEncryptedParameters;

class Invoice extends Model
{
    use HasEncryptedParameters;

    protected $fillable = [
        'file_path'
        // Tambahkan field lain jika diperlukan
    ];
}