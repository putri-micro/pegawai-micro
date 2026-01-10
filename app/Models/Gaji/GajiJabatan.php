<?php

namespace App\Models\Gaji;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class GajiJabatan extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'gaji';

    protected $table = 'gaji_jabatan';

    protected $primaryKey = 'id';

    protected $fillable = [
        'gaji_master_id',
        'komponen_id',
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
