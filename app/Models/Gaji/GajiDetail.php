<?php

namespace App\Models\Gaji;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class GajiDetail extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'gaji';

    protected $table = 'gaji_detail';

    protected $primaryKey = 'id';

    protected $fillable = [
        'detail_id',
        'komponen_id',
        'nominal',
        'keterangan',
        'transaksi_id',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer',
        'nominal' => 'decimal:2',
    ];
}
