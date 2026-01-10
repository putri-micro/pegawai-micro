<?php

namespace App\Models\Gaji;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class GajiTrx extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $connection = 'gaji';

    protected $table = 'gaji_trx';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaksi_id',
        'periode_id',
        'total_penghasil',
        'total_potongan',
        'total_dibayar',
        'id_sdm',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer',
        'total_penghasil' => 'decimal:2',
        'total_potongan' => 'decimal:2',
        'total_dibayar' => 'decimal:2',
    ];
}
