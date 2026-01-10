<?php

namespace App\Models\Gaji;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class GajiUmum extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'gaji';

    protected $table = 'gaji_umum';

    protected $primaryKey = 'id';

    protected $fillable = [
        'umum_id',
        'nominal',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer',
        'nominal' => 'decimal:2',
    ];
}
