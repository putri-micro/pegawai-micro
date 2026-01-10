<?php

namespace App\Models\Gaji;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class KomponenGaji extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'gaji';

    protected $table = 'komponen_gaji';

    protected $primaryKey = 'id';

    protected $fillable = [
        'komponen_id',
        'nama_komponen',
        'jenis',
        'deskripsi',
        'is_umum',
        'umum_id',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer',
        'is_umum' => 'integer',
    ];
}
